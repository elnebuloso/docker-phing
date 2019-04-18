#!/usr/bin/env bash

##########################################################################################################

set -e

##########################################################################################################

_gather-environment 'HOME'

##########################################################################################################

: ${PHING_SONARQUBE_SCANNER:=elnebuloso/sonarqube-scanner:latest}
: ${PHING_SONARQUBE_SCANNER_EXEC:=sonar-scanner}

##########################################################################################################

_docker-pull-image ${PHING_SONARQUBE_SCANNER}

##########################################################################################################

tty=
tty -s && tty=--tty
run="docker run $tty --interactive --rm --user $(id -u) --workdir $(pwd) --volume $(pwd):$(pwd) --env-file /tmp/env ${PHING_SONARQUBE_SCANNER} ${PHING_SONARQUBE_SCANNER_EXEC} $@"

##########################################################################################################

_docker-run-image "${run}"

##########################################################################################################
