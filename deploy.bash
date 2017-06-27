#!/usr/bin/env bash

##
# Description:
# Deploys CAFPE site to its FTP server destination
# Arguments:
#   - S1 -> Host
#   - $2 -> Username
#   - $3 -> Password
#   - $4 -> Development DB location
#   - $5 -> Production DB location
##

# Global variables
HOST=$1
USERNAME=$2
PASSWORD=$3
DEV_DB=$4
PROD_DB=$5
FTP_ACCESS="ftp://$USERNAME:$PASSWORD@$HOST"
TRANSFERRED_LOG="lftp_transferred.log"
DEBUG_LOG="lftp_debug.log"
LFTP_OPTIONS="set ftp:list-options -a;
            set cmd:fail-exit yes;
            set ftp:ssl-allow no;
            set ssl:verify-certificate no;
            set xfer:log true;
            set log:file/xfer $TRANSFERRED_LOG;
            set log:show-time/xfer false;
            set ftp:use-site-utime false;
            set ftp:use-site-utime2 false;
            set net:timeout 5;
            set dns:fatal-timeout 5;
            set dns:max-retries 3;
            debug 4 -o $DEBUG_LOG -T;"

##
# Runs gulp using gulpfile in repo to create production assets
##
function create_assets() {
    echo "ASSETS CREATION [INFO]: Building assets"
    npm run build
    if [[ $? != 0 ]]; then
        echo "ASSETS CREATION [ERROR]: Building process failed"
        return 1
    fi
    echo "ASSETS CREATION [INFO]: Done"
}



##
# Sets environment to production modifing /public/.htaccess
##
function set_environment() {
    HTACCESS="public/.htaccess"
    echo "SETTING ENVIRONMENT [INFO]: Editing $HTACCESS"
    if [[ ! -f $HTACCESS ]]; then
        echo "SETTING ENVIRONMENT [ERROR]: $HTACCESS doesn'exist"
        return 1
    fi
    sed -i 's/development/production/' $HTACCESS
    echo "SETTING ENVIRONMENT [INFO]: Done"
}

##
# Activates maintenance mode in CI
# $1 -  new status (string -> 'true' or 'false')
##
function set_maintenance_mode() {
    if [[ $1 != 'true' && $1 != 'false' ]]; then
        echo "CHANGING MAINTENANCE MODE [INFO]: '$1' is not a valid parameter. Only 'true' or 'false' are valid."
        return 1
    fi
    MAINTENANCE_FILE="application/config/maintenance.php"
    echo "CHANGING MAINTENANCE MODE TO $1 [INFO]: Editing '$MAINTENANCE_FILE'"
    if [[ ! -f $MAINTENANCE_FILE ]]; then
        echo "CHANGING MAINTENANCE MODE TO $1 [ERROR]: '$MAINTENANCE_FILE' doesn'exist"
        return 1
    fi
    sed -i "s/\(^\s*\$config\['site_under_maintenance'\]\s*=\s*\).*;/\1$1;/i" $MAINTENANCE_FILE
    echo "CHANGING MAINTENANCE MODE TO $1 [INFO]: Uploading '$MAINTENANCE_FILE'"

    if ! ftp_upload_file $MAINTENANCE_FILE $MAINTENANCE_FILE; then
        return 1
    fi
    echo "CHANGING MAINTENANCE MODE TO $1 [INFO]: Done"
}

##
# Looks for error codes in LFTP debug log
##
function check_ftp_errors() {
    echo "FTP TRANSFER CHECK DEBUG [INFO]: Checking errors in debug log"
    if ! tail -1 $DEBUG_LOG| grep -q '221 Goodbye'; then
        echo "FTP TRANSFERS CHECK DEBUG [ERROR]: Connection wasn't finished properly. Transfer could have not been completed."
        return 1
    fi
    # Get FTP server return codes (second column) and check for errors (4XX, 5XX or 6XX)
    awk '$2~/^[4-6]/ { print "FTP TRANSFER CHECK DEBUG [ERROR]: " $0; errors++; } END { if(errors){ exit errors; } }' $DEBUG_LOG
    ERRORS=$?
    if [[ $ERRORS > 0 ]]; then
        echo "FTP TRANSFER CHECK DEBUG [INFO]: Done, $ERRORS error(s)"
        return 1
    fi
    echo "FTP TRANSFER CHECK DEBUG [INFO]: Done, no errors"
}

##
# Checks if sizes of files in local storage are the same as logged size
# Return values:
#    1 - Error
#   -1 - No files tranferred
##
function check_ftp_transfers() {
    FTP_URL="ftp://$USERNAME@$HOST"
    echo "FTP TRANSFERS CHECK [INFO]: Checking transferred files log"
    # error if nothing was uploaded
    if [[ ! -f $1 ]]; then
        echo "FTP TRANSFERS CHECK [WARNING]: No files were transferred, check FTP log above"
        return -1
    fi
    ERRORS=0
    # check if each file size is the same as bytes uploaded, using the log file created by LFTP
    while IFS="|" read TRANSFERRED_FNAME TRANSFERRED_FSIZE; do
        ACTUAL_FSIZE=$(ls -nl $TRANSFERRED_FNAME | awk '{print $5}')
        if [[ $ACTUAL_FSIZE != $TRANSFERRED_FSIZE ]]; then
            echo "FTP TRANSFERS CHECK [ERROR]: Possible corrupted file: $TRANSFERRED_FNAME $ACTUAL_FSIZE $TRANSFERRED_FSIZE SS"
            ((ERRORS++))
        fi
    # process transfers log so it has two columns: local file name|transferred size
    done <<< `sed 's/\(^ftp.* -> \(\/.*\)\|\(\/.*\) -> ftp.*\) [0-9]\+-\([0-9]\+\) .*/\2\3|\4/g'  $TRANSFERRED_LOG`
    if [[ $ERRORS > 0 ]]; then
        echo "FTP TRANSFERS CHECK [INFO]: Done, $ERRORS error(s)"
        return 1
    fi
    echo "FTP TRANSFERS CHECK [INFO]: Done, no errors"
}

##
# Deletes LFTP logs if present
##
function remove_lftp_logs() {
    if [[ -f $TRANSFERRED_LOG ]]; then
        rm $TRANSFERRED_LOG
    fi
    if [[ -f $DEBUG_LOG ]]; then
        rm $DEBUG_LOG
    fi
}

##
# Renames a file in ftp server
#
# $1 - Current file name
# $2 - New file name
function ftp_rename_file() {
    echo "FTP RENAME [INFO]: Renaming '$1' to '$2'"
    remove_lftp_logs
    lftp -c "$LFTP_OPTIONS
    open '$FTP_ACCESS';
    mv $1 $2"
    if ! check_ftp_errors $DEBUG_LOG; then
        return 1
    fi
    echo "FTP RENAME [INFO]: Done"
}

##
# Downloads a file from ftp server
#
# $1 - Remote file name
# $2 - Destination file name
function ftp_download_file() {
    echo "FTP DOWNLOAD [INFO]: Downloading '$1' from FTP server"
    remove_lftp_logs
    mkdir -p `dirname $2`
    lftp -c "$LFTP_OPTIONS
    open '$FTP_ACCESS';
    get $1 -o $2"
    echo "FTP DOWNLOAD [INFO]: Done"
    if ! check_ftp_errors $DEBUG_LOG; then
        return 1
    fi
    if ! check_ftp_transfers $TRANSFERRED_LOG; then
        return 1
    fi
}

##
# Uploads a file to ftp server
#
# $1 - Local file name
# $2 - Destination file name
# $3 - (optional) permissions in octal format. If present updated file
#      will be chmoded accordingly
function ftp_upload_file() {
    echo "FTP UPLOAD [INFO]: Uploading '$1' to FTP server"
    if [[ $# > 2 ]]; then
        CHMOD="chmod $3 $2"
    fi
    remove_lftp_logs
    lftp -c "$LFTP_OPTIONS
    open '$FTP_ACCESS';
    mkdir -p -f `dirname $2`;
    put $1 -o $2;
    $CHMOD;"
    echo "FTP UPLOAD [INFO]: Done"
    if ! check_ftp_errors $DEBUG_LOG; then
        return 1
    fi
    if ! check_ftp_transfers $TRANSFERRED_LOG; then
        return 1
    fi
}

##
# Uploads whole site to ftp server
##
function ftp_upload_site() {
    echo "FTP UPLOAD [INFO]: Uploading site to FTP server"
    remove_lftp_logs
    # Change public name folder to public_html
    mv public public_html
    lftp -c "$LFTP_OPTIONS
    open '$FTP_ACCESS';
    mirror --reverse --ignore-time \
    --delete \
    --verbose \
    --exclude-glob='*' \
    --include='public_html/' \
    --exclude='public_html/assets/src' \
    --include='vendor/' \
    --exclude-glob='vendor/*/' \
    --exclude-glob='vendor/?*' \
    --include='vendor/codeigniter/' \
    --exclude-glob='vendor/codeigniter/*/' \
    --include='vendor/codeigniter/framework' \
    --exclude-glob='vendor/codeigniter/framework/*/' \
    --exclude-glob='vendor/codeigniter/framework/?*' \
    --include='vendor/codeigniter/framework/system' \
    --include='application/' \
    --exclude-glob='application/cache/ci_session*' \
    --exclude-glob='application/logs/*.php' \
    --exclude='application/migrations/' \
    --exclude='application/db/' \
    --exclude='application/tests/'"
    echo "FTP UPLOAD [INFO]: Done"
    if ! check_ftp_errors $DEBUG_LOG; then
        return 1
    fi
    check_ftp_transfers $TRANSFERRED_LOG
    # ignore if return value is -1 (no tranfers)
    if [[ $? == 1 ]]; then
        return 1
    fi
    mv public_html public
}

##
# Returns 0 if migrations were run, 1 if there were no pending migrations
##
function run_migrations() {
    CURRENT=`php cli migrate version|grep database|awk '{ print $2 }'`
    LATEST=`php cli migrate version|grep latest|awk '{ print $2 }'`
    if [[ $CURRENT < $LATEST ]]; then
        php cli migrate $LATEST
        return 0
    fi
    return 1
}

##
# Updates db if there are pending migrations
##
function update_db() {
    echo "DB MIGRATIONS [INFO]: Updating DB"
    echo "DB MIGRATIONS [INFO]: Downloading DB from FTP server"
    # CLI that runs migrations uses current environment DB
    # So download production DB naming it as development DB
    if [[ -f $DEV_DB ]]; then
        rm $DEV_DB
    fi
    if ! ftp_download_file $PROD_DB $DEV_DB; then
        return 1
    fi
    echo "DB MIGRATIONS [INFO]: Running migrations"
    # if migrations were run
    if run_migrations; then
        # rename production db with date appended to name (backup)
        echo "DB MIGRATIONS [INFO]: Backing up DB"
        if ! ftp_rename_file $PROD_DB ${PROD_DB}`date +"%d%m%Y"`; then
            return 1
        fi
        # upload db as production db
        echo "DB MIGRATIONS [INFO]: Uploading DB"
        if ! ftp_upload_file $DEV_DB $PROD_DB 666; then
            return 1
        fi
    else
        echo "DB MIGRATIONS [INFO]: No pending migrations"
    fi
    echo "DB MIGRATIONS [INFO]: Done"
}

echo
echo "-------------------------- DEPLOYMENT [BEGIN] --------------------------"
if ! create_assets; then
    echo "[FATAL] Fatal error creating assets, script halted"
    exit 1
fi

if ! set_maintenance_mode 'true'; then
    echo "[FATAL] Fatal error enabling maintenance mode, script halted"
    exit 1
fi

# Set production environment
if ! set_environment; then
    echo "[FATAL] Fatal error setting environment, script halted"
    exit 1
fi

# Upload site
if ! ftp_upload_site; then
    echo "[FATAL] Fatal error uploading site, script halted"
    exit 1
fi

# Update DB
if ! update_db; then
    echo "[FATAL] Fatal error updating DB, script halted"
    exit 1
fi

if ! set_maintenance_mode 'false'; then
    echo "[FATAL] Fatal error disabling maintenance mode, script halted"
    exit 1
else
    echo "[INFO] Deployment done correctly"
    echo
    echo "-------------------------- DEPLOYMENT [END] --------------------------"
    exit 0
fi
