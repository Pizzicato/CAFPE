#!/usr/bin/env groovy
pipeline {
    agent any

   stages {
       stage('Prepare') {
           // composer install
           // npm install
           steps {
               echo 'Preparing PHP packages and Node modules...'
               sh 'composer install'
               sh 'npm set progress=false'
               sh 'npm install'
           }
       }
       stage('Test') {
           steps {
               echo 'Testing...'
               sh 'vendor/bin/phpunit -c application/tests'
           }
       }
       stage('Deploy to staging Server') {
           // create_assets
           // set_maintenance_mode true
           // ftp_upload_site
           // update_db
           // set_maintenance_mode false
           steps {
               echo 'Deploying to staging server...'
           }
       }
       stage('Deploy to production server') {
           // create_assets
           // set_maintenance_mode true
           // ftp_upload_site
           // update_db
           // set_maintenance_mode false
           steps {
               echo 'Deploying to production server - manual...'
           }
       }
   }
}
