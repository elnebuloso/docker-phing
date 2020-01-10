#!/usr/bin/env bash

##########################################################################################################

set -e

##########################################################################################################

: ${PHING_YARN:=node:lts-alpine}
: ${PHING_YARN_CACHE_VOLUME:=phing-yarn}
: ${PHING_YARN_CACHE_DIR:=/tmp}
: ${PHING_YARN_EXEC:=yarn}

##########################################################################################################

docker-pull ${PHING_YARN}
docker-run --volume ${PHING_YARN_CACHE_VOLUME}-uid-$(id -u):${PHING_YARN_CACHE_DIR} --env YARN_CACHE_FOLDER=/tmp ${PHING_YARN} ${PHING_YARN_EXEC} $@

##########################################################################################################
