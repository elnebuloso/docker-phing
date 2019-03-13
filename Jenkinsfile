pipeline {
    agent any

	stages {
        stage('compile') {
            steps {
                sh "docker run --rm --user \$(id -u) --workdir \$(pwd)/main --volume \$(pwd)/main:\$(pwd)/main composer install --no-suggest --no-ansi --no-interaction --no-dev --optimize-autoloader"
            }
        }

        stage('bundle') {
            steps {
                sh "cp -R ./main/* ./build/dist"
            }
        }

        stage('build') {
            steps {
                script {
                    image = docker.build("elnebuloso/phing", "--pull --rm --no-cache -f Dockerfile.${type} .")
                }
            }
        }

        stage('push') {
            steps {
                script {
                    env.WORKSPACE = pwd()
                    def version = readFile "${env.WORKSPACE}/VERSION"

                    docker.withRegistry("https://registry.hub.docker.com", '061d45cc-bc11-4490-ac21-3b2276f1dd05'){
                        image.push("")
                        image.push("${version}")
                    }
                }
            }
        }
	}

	post {
	    always {
            cleanWs()
	    }
	}
}
