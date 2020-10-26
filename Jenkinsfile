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
        stage('Deploy to kubernetes'){
            steps{
                kubernetesDeploy configs: 'wordpress-deployment.yaml', kubeConfig: [path: ''], kubeconfigId: 'k8s-kubeconfig', secretName: '', ssh: [sshCredentialsId: '*', sshServer: ''], textCredentials: [certificateAuthorityData: '', clientCertificateData: '', clientKeyData: '', serverUrl: 'https://B8889935E09181A8D38D6FEB0BE84410.yl4.us-west-1.eks.amazonaws.com']
            }
        }
    }
}

// to use commit id in docker image version
// def getDockertag(){
//     def tag = sh script: 'git rev-parse HEAD', returnStdout: true
//     return tag
// }

