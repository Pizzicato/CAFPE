pipeline {
    agent any
    stages {
        stage('Prepare') {
            steps {
                timeout(time: 5, unit: 'MINUTES') {
                    echo ' ************ Installing Composer packages and Node modules ************'
                    echo "FTP HOST: ${env.FTPWPD_HOST}"
                    sh 'rm -rf ./vendor; composer install'
                    sh 'rm -rf ./node_modules; npm set progress=false; npm install;'
                }
            }
        }
        stage('Test') {
            steps {
                echo ' ************ Testing  ************'
                sh 'vendor/bin/phpunit --log-junit results/phpunit/phpunit.xml -c application/tests'
            }
            post {
                always {
                    junit 'application/tests/results/phpunit/phpunit.xml'
                }
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
