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
            echo "Set up process failed. Deploy halted: ${error.message}"
            throw error
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
            echo "Tests failed. Deploy halted: ${error.message}"
            throw error
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
            echo "Error: Something went wrong during deployment to staging server"
            throw error
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
            echo "Warning: Timeout reached or user aborted production deployment"
            throw error
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
            echo "Error: Something went wrong during deployment to production server"
            throw error
        }
    }
}
catch(error) {
    echo "Error: Althought build was SUCCESSFUL, deployment process couldn't be completed: ${error.message}"
}
finally {
    // If the script has passed the tests, it has to be marked as successful
    // even if deployment stages failed, or execution is aborted
    currentBuild.result = "SUCCESS"
}
