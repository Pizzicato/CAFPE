#!/usr/bin/env groovy
pipeline {
    agent any

   stages {
       stage('Build') {
           // composer install
           // npm install
           steps {
               echo 'Building...'

           }
       }
       stage('Test') {
           // vendor/bin/phpunit -c application/tests
           steps {
               echo 'Testing...'
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
