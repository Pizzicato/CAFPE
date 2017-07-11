#!/usr/bin/env groovy

stage('Set Up') {
    node {
        try {
            // delete all untracked files. Use '|| true' in case repo hasn't been checked out previously
            sh 'git clean -dfx || true'
            echo '************ Getting Repo ************'
            checkout scm
            echo '************ Installing Composer packages ************'
            sh 'composer install'
            echo '************ Installing Node modules ************'
            sh 'npm set progress=false'
            sh 'npm install'
            echo '************ Creating Assets ************'
            sh 'npm run build'
            stash 'complete-workspace'
        }
        catch(error) {
            error('Set up process failed. Deploy halted: ${error.message}')
        }

    }
}

stage('Test') {
    node {
        unstash 'complete-workspace'
        echo '************ Testing  ************'
        try {
            sh 'vendor/bin/phpunit --log-junit results/phpunit/phpunit.xml -c application/tests'
        }
        catch(error) {
            error('Tests failed. Deploy halted: ${error.message}')
        }
        finally {
            junit allowEmptyResults: true, testResults: 'application/tests/results/phpunit/phpunit.xml'
        }
    }
}

try {
    stage('Staging') {
        try {
            node {
                echo ' ************ Deploying to staging server ************'
                withCredentials([usernamePassword(credentialsId: 'eddefcd8-350c-4a75-9f2e-bed38fab48c8', passwordVariable: 'FTP_PASSWORD', usernameVariable: 'FTP_USERNAME')]) {
                    unstash 'complete-workspace'
                    sh "./deploy.bash ${env.FTPWPD_HOST} ${FTP_USERNAME} ${FTP_PASSWORD} ${env.CAFPE_DEV_DB} ${env.CAFPE_PROD_DB}"
                }
            }
        }
        catch(error) {
            error("Error: Something went wrong during deployment to staging server")
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
        catch(error) {
            error("Warning: Timeout reached or user aborted production deployment")
        }
    }
    stage('Production') {
        try {
            node {
                echo ' ************ Release to production server ************'
                // TODO: Don't forget unstash
            }
        }
        catch(error) {
            error("Error: Something went wrong during deployment to production server")
        }
    }
}
catch(error) {
    error("Error: Althought build was successful, deployment process couldn't be completed: ${error.message}")
}
finally {
    // If the script has passed the tests, it has to be marked as successful
    // even if deployment stages failed, or execution is aborted
    currentBuild.result = "SUCCESS"
}
