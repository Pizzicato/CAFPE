#!/usr/bin/env bash

##
# Description:
# Tasks to prepare the repo for deployment.
# Should be run after repo has been cloned
##

function install_composer_packages() {
    echo "COMPOSER [INFO]: Installing packages"
    composer install
    if [[ $? != 0 ]]; then
        echo "COMPOSER [ERROR]: Installing packages process failed"
        return 1
    fi
    echo "COMPOSER [INFO]: Done"
}


function install_npm_modules() {
    echo "NPM [INFO]: Configuring npm"
    npm set progress=false
    echo "NPM [INFO]: Cleaning node_modules folder"
    if [[ -d node_modules ]]; then
        rm -rf node_modules
    fi
    echo "NPM [INFO]: Installing modules"
    npm install
    if [[ $? != 0 ]]; then
        echo "NPM [ERROR]: Installing modules process failed"
        return 1
    fi
    echo "NPM [INFO]: Done"
}

echo
echo "-------------------------- REPO SETUP FOR DEPLOYMENT [BEGIN] --------------------------"
if ! install_composer_packages; then
    echo "[FATAL] Fatal error intalling composer packages, script halted"
    exit 1
fi

if ! install_npm_modules; then
    echo "[FATAL] Fatal error intalling node modules, script halted"
    exit 1
else
    echo "[INFO] Repo preparation for deployment done correctly"
    echo
    echo "-------------------------- REPO SETUP FOR DEPLOYMENT [END] --------------------------"
    exit 0
fi
