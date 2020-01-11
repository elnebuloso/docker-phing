#!/usr/bin/env bash

##########################################################################################################

set -e

##########################################################################################################

: ${PHING_COMPOSER:=composer}
: ${PHING_COMPOSER_CACHE_VOLUME:=phing-composer}
: ${PHING_COMPOSER_CACHE_DIR:=/tmp}
: ${PHING_COMPOSER_EXEC:=}

##########################################################################################################

docker-pull ${PHING_COMPOSER}
docker-run --volume ${PHING_COMPOSER_CACHE_VOLUME}-uid-$(id -u):${PHING_COMPOSER_CACHE_DIR} ${PHING_COMPOSER} ${PHING_COMPOSER_EXEC} $@

##########################################################################################################
