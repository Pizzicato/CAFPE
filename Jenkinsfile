pipeline {
    agent none
    stages {
        stage('Set Up') {
            agent any
            steps {
                parallel (
                    Composer: {
                         echo '************ Installing Composer packages ************'
                        sh 'rm -rf ./vendor; composer install'
                    },
                    NodeJS: {
                        echo '************ Installing Node modules ************'
                        sh 'rm -rf ./node_modules; npm set progress=false; npm install;'
                    }
                )
            }
        }
        stage('Test') {
            agent any
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
            agent any
            steps {
                timeout(time: 5, unit: 'MINUTES') {
                    echo ' ************ Creating Assets ************'
                    sh 'npm run build'
                }
            }
        }
        stage('Staging') {
            agent any
            steps {
                echo ' ************ Deploying to staging server ************'
                withCredentials([usernamePassword(credentialsId: 'eddefcd8-350c-4a75-9f2e-bed38fab48c8', passwordVariable: 'FTP_PASSWORD', usernameVariable: 'FTP_USERNAME')]) {
                    sh "./deploy.bash ${env.FTPWPD_HOST} ${FTP_USERNAME} ${FTP_PASSWORD} ${env.CAFPE_DEV_DB} ${env.CAFPE_PROD_DB}"
                }
            }
        }
        stage('Sanity check') {
            agent none
            steps {
                echo ' ************ Decide Release to production server ************'
                timeout(time:1, unit:'MINUTES') {
                    input message:"Does the staging environment look OK?", submitter: 'pabloguaza,pablo'
                }
            }
            post {
                always {
                    steps {
                        script {
                            currentBuild.result = "SUCCESS"
                        }
                    }
                }
            }
        }

        stage('Production') {
            agent any
            steps {
                echo ' ************ Release to production server ************'
            }
        }
    }
}
