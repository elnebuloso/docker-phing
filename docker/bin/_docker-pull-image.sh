#!/usr/bin/env bash

##########################################################################################################

set -e

##########################################################################################################

: ${PHING_VERBOSE_LEVEL:=0}
: ${PHING_DOCKER_IMAGES_PULL_ALWAYS:=no}
: ${PHING_DOCKER_IMAGES_PULL_PERIOD:=1 hour}

##########################################################################################################

if [[ ${PHING_DOCKER_IMAGES_PULL_ALWAYS} = "yes" ]]; then
    if [[ ${PHING_VERBOSE_LEVEL} -gt 0 ]]; then
        echo "***** pulling image: $1 forced *****"
    fi
    docker pull $1 > /dev/null 2>&1
else
    if [[ "$(docker run --volume is_expired:/tmp elnebuloso/is-expired $1 ${PHING_DOCKER_IMAGES_PULL_PERIOD})" = "yes" ]]; then
        if [[ ${PHING_VERBOSE_LEVEL} -gt 0 ]]; then
            echo "***** pulling image: $1 expired ${PHING_DOCKER_IMAGES_PULL_PERIOD} *****"
        fi
        docker pull $1 > /dev/null 2>&1
    fi;
fi

##########################################################################################################
