# docker-phing

![Main workflow](https://github.com/elnebuloso/docker-phing/workflows/Main%20workflow/badge.svg)
[![Docker Pulls](https://img.shields.io/docker/pulls/elnebuloso/phing.svg)](https://hub.docker.com/r/elnebuloso/phing)
[![GitHub](https://img.shields.io/github/license/elnebuloso/docker-ansible.svg)](https://github.com/elnebuloso/docker-phing)

Dockerized Phing + Commons for Continuous Integration

## usage

### configure

#### create build.xml

- build.xml file will be placed in your project root directory

```
<?xml version="1.0" encoding="UTF-8"?>

<project name="application" basedir="." default="commons:help">
   
    <import file="/srv/phing/commons/standard.xml"/>
    
</project>
```

#### create build.yml file

- build.yml file will be placed in your project root directory

```
phing:
  properties:
    project_name: "phing"
```


#### (optional) create build.env file

- build.env file will be placed in your project root directory
- will hold environment configurations for phing

#### (optional) create VERSION file

- VERSION file will be placed in your project root directory
- will hold the semver version of your project

## run script (bash)

```
#!/bin/bash

tty=
tty -s && tty=--tty

docker pull elnebuloso/phing \
    && docker run $tty --interactive --rm --user $(id -u) \
       --volume /var/run/docker.sock:/var/run/docker.sock \
       --volume $(pwd):$(pwd) \
       --workdir $(pwd) \
       --env-file $(pwd)/build.env \
       elnebuloso/phing:4 phing ${@:1}
```

## run script (windows powershell)

```
$dockerImage = "elnebuloso/phing:4"
$pwd = [string](Get-Location)
$pwd = $pwd.Replace("\", "/")
$pwdLinux = "/host_mnt/" + $pwd.Replace(":", "").ToLower()

docker pull $dockerImage
docker run -it --rm --volume /var/run/docker.sock:/var/run/docker.sock --volume ${pwd}:${pwdLinux} -w ${pwdLinux} --env-file ${pwd}/build.env $dockerImage phing $args
```
