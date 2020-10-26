pipeline{
    agent any
    environment{
        DOCKER_TAG = getDockertag()
    }
    stages{
        stage("Build Docker Image"){
            steps{
                sh "docker build -t gagangiri94/wp-image:${DOCKER_TAG}"
            }
        }
    }
}

def getDockertag(){
    def tag = sh script: 'git rev-parse HEAD', returnStdout: true
    return tag
}