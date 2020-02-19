#!/bin/bash

tty=
tty -s && tty=--tty

phing_image="elnebuloso/phing:4"
phing_env_arg=""

if [[ -f "$(pwd)/build.env" ]]; then
    phing_env_arg="--env-file $(pwd)/build.env"
fi

docker pull ${phing_image} \
    && docker run $tty --interactive --rm --user $(id -u) \
       --volume /var/run/docker.sock:/var/run/docker.sock \
       --volume $(pwd):$(pwd) \
       --workdir $(pwd) \
       ${phing_env_arg} ${phing_image} phing ${@:1}