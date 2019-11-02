#!/usr/bin/env bash

##########################################################################################################

set -e

##########################################################################################################

: ${PHING_NPM:=node:lts-alpine}
: ${PHING_NPM_CACHE_VOLUME:=phing-npm}
: ${PHING_NPM_CACHE_DIR:=/tmp/npm/cache}
: ${PHING_NPM_EXEC:=npm}

##########################################################################################################

_docker-pull-image ${PHING_NPM}

##########################################################################################################

tty=
tty -s && tty=--tty
run="docker run $tty --interactive --rm --user $(id -u) --workdir $(pwd) --volume $(pwd):$(pwd) --volume ${PHING_NPM_CACHE_VOLUME}-uid-$(id -u):${PHING_NPM_CACHE_DIR} ${PHING_NPM} ${PHING_NPM_EXEC} $@"

##########################################################################################################

_docker-run-image "${run}"

##########################################################################################################
