pipeline {
  agent any
  stages {
    stage('Prepare') {
      steps {
        timeout(time: 5, unit: 'MINUTES') {
          echo ' ************ Preparing PHP packages and Node modules ************'
          sh 'composer install'
          sh 'npm set progress=false; npm install;'
        }
        
      }
    }
    stage('Test') {
      steps {
        echo ' ************ Testing...  ************'
        sh 'vendor/bin/phpunit --log-junit results/phpunit/phpunit.xml -c application/tests'
      }
    }
    stage('Deploy to Staging Server') {
      steps {
        echo ' ************ Deploying to staging server ************'
      }
    }
    stage('Release to Production Server') {
      steps {
        echo ' ************ Release to production server - manual... ************'
      }
    }
  }
}