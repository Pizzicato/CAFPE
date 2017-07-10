#!/usr/bin/env groovy

stage('Set Up') {
    node {
        echo '************ Getting Repo ************'
        checkout scm
        echo '************ Installing Composer packages ************'
        sh 'composer install'
        echo '************ Installing Node modules ************'
        sh 'npm prune'
        sh 'npm set progress=false'
        sh 'npm install'
        echo '************ Creating Assets ************'
        sh 'npm run build'
        stash 'complete-workspace'
    }
}

stage('Test') {
    node {
        unstash 'complete-workspace'
        echo '************ Testing  ************'
        try {
            sh 'vendor/bin/phpunit --log-junit results/phpunit/phpunit.xml -c application/tests'
        }
        catch(err) {
            error('Tests failed. Deploy process halted.')
        }
        finally {
            junit allowEmptyResults: true, testResults: 'application/tests/results/phpunit/phpunit.xml'
        }
    }
}

try {
    stage('Staging') {
        node {
            echo ' ************ Deploying to staging server ************'
            withCredentials([usernamePassword(credentialsId: 'eddefcd8-350c-4a75-9f2e-bed38fab48c8', passwordVariable: 'FTP_PASSWORD', usernameVariable: 'FTP_USERNAME')]) {
                unstash 'complete-workspace'
                sh "./deploy.bash ${env.FTPWPD_HOST} ${FTP_USERNAME} ${FTP_PASSWORD} ${env.CAFPE_DEV_DB} ${env.CAFPE_PROD_DB}"
            }
        }
    }
    stage('Sanity Check') {
        echo ' ************ Decide Release to production server ************'
        // TODO: Change time
        try {
            timeout(time:1, unit:'MINUTES') {
                input message:'Approve deployment to production?', submitter: 'pablo,pabloguaza'
            }
        }
        catch (err) {
            def user = err.getCauses()[0].getUser()
            echo "TIMEOUT REACHED"
            if('SYSTEM' == user.toString()) { //timeout
                currentBuild.result = "SUCCESS"
            }
        }
    }
    stage('Production') {
        node {
            echo ' ************ Release to production server ************'
            // TODO: Don't forget unstash
        }
    }
}
finally {
    // If the script has passed the tests, it has to be marked as successful
    // even if deployment stages failed, or execution is aborted
    currentBuild.result = "SUCCESS"
}


stage('Cleanup'){

 echo 'prune and cleanup'
 sh 'npm prune'
 sh 'rm node_modules -rf'

 mail body: 'project build successful',
             from: 'xxxx@yyyyy.com',
             replyTo: 'xxxx@yyyy.com',
             subject: 'project build successful',
             to: 'yyyyy@yyyy.com'
}
