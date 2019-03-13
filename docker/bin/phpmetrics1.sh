#!/usr/bin/env bash

##########################################################################################################

set -e

##########################################################################################################

_gather-environment 'HOME'

##########################################################################################################

: ${PHING_PHPMETRICS1:=elnebuloso/php-phpmetrics:1}
: ${PHING_PHPMETRICS1_EXEC:=}

##########################################################################################################

_docker-pull-image ${PHING_PHPMETRICS1}

##########################################################################################################

tty=
tty -s && tty=--tty
run="docker run $tty --interactive --rm --user $(id -u) --workdir $(pwd) --volume $(pwd):$(pwd) --env-file /tmp/env ${PHING_PHPMETRICS1} ${PHING_PHPMETRICS1_EXEC} $@"

##########################################################################################################

_docker-run-image "${run}"

##########################################################################################################
