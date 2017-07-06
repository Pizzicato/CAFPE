pipeline {
    agent any
    stages {
        stage('Set Up') {
            steps {
                parallel (
                    Composer: {
                        sh 'rm -rf ./vendor; composer install'
                    },
                    NodeJS: {
                        sh 'rm -rf ./node_modules; npm set progress=false; npm install;'
                    }
                )
            }
        }
        stage('Test') {
            steps {
                timeout(time: 15, unit: 'MINUTES') {
                    echo ' ************ Testing  ************'
                    sh 'vendor/bin/phpunit --log-junit results/phpunit/phpunit.xml -c application/tests'
                }
            }
            post {
                always {
                    junit allowEmptyResults: true, testResults: 'application/tests/results/phpunit/phpunit.xml'
                }
            }
        }
        stage('Create Assets') {
            steps {
                timeout(time: 5, unit: 'MINUTES') {
                    echo ' ************ Creating Assets ************'
                    sh 'npm run build'
                }
            }
        }
        stage('Deploy to Staging Server') {
            steps {
                echo ' ************ Deploying to staging server ************'
                withCredentials([usernamePassword(credentialsId: 'eddefcd8-350c-4a75-9f2e-bed38fab48c8', passwordVariable: 'FTP_PASSWORD', usernameVariable: 'FTP_USERNAME')]) {
                    sh "./deploy.bash ${env.FTPWPD_HOST} ${FTP_USERNAME} ${FTP_PASSWORD} ${env.CAFPE_DEV_DB} ${env.CAFPE_PROD_DB}"
                }
            }
        }
        stage('Release to Production Server') {
            steps {
                echo ' ************ Release to production server - manual... ************'
            }
        }
    }
}
