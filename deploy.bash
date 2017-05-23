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
    if [[ ! -f $HTACCESS ]]; then
        echo "Something went wrong: $HTACCESS doesn'exist"
        exit 1
    fi
    sed -i -- 's/development/production/' $HTACCESS
}

##
# Runs gulp using gulpfile in repo to create production assets
##
function create_assets() {
    echo popo
}

# $1 - FTP_URL
# $2 - Local folder
# $3 - Remote folder
function ftp_upload_folder() {
    FTPURL=$1
    LCD=$2
    RCD=$3
    lftp -c "set ftp:list-options -a;
    set cmd:fail-exit yes;
    set ssl:verify-certificate no;
    open '$FTPURL';
    lcd $LCD;
    cd $RCD;
    mirror --reverse \
    --delete \
    --verbose"
}

# $1 - FTP_HOST
# $2 - FTP_USERNAME
# $3 - FTP_PASSWORD
function ftp_upload_repo() {
    # git ftp push <options>
    echo "git ftp"
}

LOCAL_PUBLIC_FOLDER='public/'
REMOTE_PUBLIC_FOLDER='public_html/'
HOST=$1
USERNAME=$2
PASSWORD=$3

#set_environment $LOCAL_PUBLIC_FOLDER
#ftp_upload_repo
ftp_upload_folder "ftp://$USERNAME:$PASSWORD@$HOST" $LOCAL_PUBLIC_FOLDER $REMOTE_PUBLIC_FOLDER
