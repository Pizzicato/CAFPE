#!/usr/bin/env bash
##
# Description:
# Deploys CAFPE site to its FTP server destination
# Arguments:
#   - S1 -> HOST
#   - $2 -> USERNAME
#   - $3 -> PASSWORD
##

##
# Sets environment to production modifing /public/.htaccess
##
function set_environment() {
    HTACCESS=$1.htaccess
    echo "SETTING ENVIRONMENT [INFO]: Editing $HTACCESS..."
    if [[ ! -f $HTACCESS ]]; then
        echo "SETTING ENVIRONMENT [ERROR]: $HTACCESS doesn'exist"
        return 1
    fi
    sed -i -- 's/development/production/' $HTACCESS
    echo "SETTING ENVIRONMENT [INFO]: Done"
}

##
# Runs gulp using gulpfile in repo to create production assets
##
function create_assets() {
    npm set progress=false
    echo "ASSETS CREATION [INFO]: Installing dependencies"
    npm install --production
    echo "ASSETS CREATION [INFO]: Installing dependencies done"
    echo "ASSETS CREATION [INFO]: Building assets"
    npm run build
    if [[ $? != 0 ]]; then
        echo "ASSETS CREATION [ERROR]: Building process failed"
        return 1
    fi
    echo "ASSETS CREATION [INFO]: Building assets done"
}

# $1 -> LFTP debug log file
function check_ftp_errors() {
    echo "FTP UPLOAD CHECK DEBUG [INFO]: Checking errors in debug log..."
    # Get FTP server return codes (second column) and check for errors (4XX, 5XX or 6XX)
    awk '$2~/^[4-6]/ { print "FTP UPLOAD CHECK DEBUG [ERROR]: " $0; errors++; } END { if(errors){ exit errors; } }' $1
    ERRORS=$?
    if [[ $ERRORS > 0 ]]; then
        echo "FTP UPLOAD CHECK DEBUG [INFO]: Done, $ERRORS error(s)"
        return 1
    else
        echo "FTP UPLOAD CHECK DEBUG [INFO]: Done, no errors"
    fi
}

# $1 -> LFTP uploaded files log
function check_ftp_upload() {
    echo "FTP UPLOAD CHECK UPLOAD [INFO]: Checking uploaded files log..."
    # error if nothing was uploaded
    if [[ ! -f $1 ]]; then
        echo "FTP UPLOAD CHECK UPLOAD [WARNING]: No files were uploaded, check FTP transfers above"
        return 0
    fi
    ERRORS=0
    # Chechk if each file size is the same as bytes uploaded, using the log file created by LFTP
    while read UPLOADED_FNAME UPLOADED_FSIZE; do
        ACTUAL_FSIZE=$(ls -nl $UPLOADED_FNAME | awk '{print $5}')
        if [[ $ACTUAL_FSIZE != $UPLOADED_FSIZE ]]; then
            echo "FTP UPLOAD CHECK UPLOAD [ERROR]: Possible corrupted file in FTP server: $UPLOADED_FNAME"
            ((ERRORS++))
        fi
    # AWK: Make $3 relative path instead of absolute. Remove first characters from $6, only leaving file size
    done <<< `awk -v pwd="$PWD/" '{ sub(pwd, "", $3); sub("^[0-9]+-", "", $6)} { print $3, $6 }' $1`
    if [[ $ERRORS > 0 ]]; then
        echo "FTP UPLOAD CHECK UPLOAD [INFO]: Done, $ERRORS error(s)"
        return 1
    else
        echo "FTP UPLOAD CHECK UPLOAD [INFO]: Done, no errors"
        return 0
    fi
}

# $1 - FTP URL
# $2 - Local folder
# $3 - Remote folder
function ftp_upload_folder() {
    echo "FTP UPLOAD [INFO]: Uploading $2 to FTP server..."
    UPLOADED_LOG="lftp_uploaded.log"
    DEBUG_LOG="lftp_debug.log"
    # Remove uploaded files log since, if present, input is appended
    if [[ -f $UPLOADED_LOG ]]; then
        rm $UPLOADED_LOG
    fi
    lftp -c "set ftp:list-options -a;
    set cmd:fail-exit yes;
    set ssl:verify-certificate no;
    set xfer:log true;
    set xfer:log-file $UPLOADED_LOG;
    set ftp:use-site-utime false;
    set ftp:use-site-utime2 false;
    set net:timeout 5;
    set dns:fatal-timeout 5;
    set dns:max-retries 3;
    debug 4 -o $DEBUG_LOG -T;
    open '$1';
    lcd $2;
    cd $3;
    mirror --reverse --ignore-time\
    --delete \
    --verbose \
    --exclude assets/src/"
    echo "FTP UPLOAD [INFO]: Done"
    check_ftp_errors $DEBUG_LOG
    if [[ $? != 0 ]]; then
        return 1
    fi
    check_ftp_upload $UPLOADED_LOG
    return $?
}

# $1 - FTP_HOST
# $2 - FTP_USERNAME
# $3 - FTP_PASSWORD
function ftp_upload_repo() {
    # Check if repo was initiated
    git ftp push -D -u $2 -p $3 ftp://$1 &> /dev/null
    if [[ $? != 0 ]]; then
        echo "GIT FTP [INFO]: Repo not in FTP site yet. Trying first upload..."
        git ftp init -u $2 -p $3 ftp://$1
        if [[ $? != 0 ]]; then
            echo "GIT FTP [ERROR]: Couldn't do first upload"
            return 1
        fi
    else
        echo "GIT FTP [INFO]: Pushing repo"
        git ftp push -u $2 -p $3 ftp://$1
        if [[ $? != 0 ]]; then
            echo "GIT FTP [ERROR]: Couldn't upload changes"
            return 1
        fi
    fi
}

function fatal_error() {
    echo "[FATAL] Fatal error deploying. Script halted"
    exit 1
}

function successful_deployment() {
    echo "[INFO] Deployment done correctly"
    exit 0
}

LOCAL_PUBLIC_FOLDER='public/'
REMOTE_PUBLIC_FOLDER='public_html/'
HOST=$1
USERNAME=$2
PASSWORD=$3

# Create Assets
create_assets
if [[ $? != 0 ]]; then
    fatal_error
fi

# Upload repo
ftp_upload_repo $HOST $USERNAME $PASSWORD
if [[ $? != 0 ]]; then
    fatal_error
fi

# Set production environment
set_environment $LOCAL_PUBLIC_FOLDER
if [[ $? != 0 ]]; then
    fatal_error
fi

# Upload public folder
ftp_upload_folder "ftp://$USERNAME:$PASSWORD@$HOST" $LOCAL_PUBLIC_FOLDER $REMOTE_PUBLIC_FOLDER
if [[ $? != 0 ]]; then
     fatal_error
else
    successful_deployment
fi
