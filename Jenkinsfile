pipeline{
    agent any
    environment{
        // DOCKER_TAG = getDockertag()
        DOCKER_TAG = "${BUILD_NUMBER}"
    }
    stages{
        stage("Build Docker Image"){
            steps{
                sh "docker build . -t gagangiri94/wp-image:${DOCKER_TAG}"
            }
        }
        stage('Dockerhub push'){
            steps{
                withCredentials([string(credentialsId: 'docker_pass', variable: 'docker_pass')]) {
                    sh "docker login -u gagangiri94 -p ${docker_pass}"
                    sh "docker push gagangiri94/wp-image:${DOCKER_TAG}"
                }
            }
        }
    }
}

// to use commit id in docker image version
// def getDockertag(){
//     def tag = sh script: 'git rev-parse HEAD', returnStdout: true
//     return tag
// }