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
        echo "SETTING ENVIRONMENT ERROR: Something went wrong. $HTACCESS doesn'exist"
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
    echo "FTP UPLOAD: Uploading $2 to FTP server..."
    lftp -c "set ftp:list-options -a;
    set cmd:fail-exit yes;
    set ssl:verify-certificate no;
    open '$1';
    lcd $2;
    cd $3;
    mirror --reverse \
    --delete \
    --verbose"
    echo "FTP UPLOAD: Done!"
}

# $1 - FTP_HOST
# $2 - FTP_USERNAME
# $3 - FTP_PASSWORD
function ftp_upload_repo() {
    # Check if repo was initiated
    git ftp push -D -u $2 -p $3 ftp://$1 &> /dev/null
    if [[ $? != 0 ]]; then
        echo "GIT FTP INFO: Repo not in FTP site yet. Trying first upload..."
        git ftp init -u $2 -p $3 ftp://$1
        if [[ $? != 0 ]]; then
            echo "GIT FTP ERROR: Couldn't upload repo"
        fi
    else
        echo "GIT FTP INFO: Pushing repo"
        git ftp push -u $2 -p $3 ftp://$1
        if [[ $? != 0 ]]; then
            echo "GIT FTP ERROR: Couldn't upload changed file to repo"
        fi
    fi
}

LOCAL_PUBLIC_FOLDER='public/'
REMOTE_PUBLIC_FOLDER='public_html/'
HOST=$1
USERNAME=$2
PASSWORD=$3

set_environment $LOCAL_PUBLIC_FOLDER
#ftp_upload_repo
ftp_upload_folder "ftp://$USERNAME:$PASSWORD@$HOST" $LOCAL_PUBLIC_FOLDER $REMOTE_PUBLIC_FOLDER
