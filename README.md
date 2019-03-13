# docker-phing

Docker Phing + Commons

## usage

### configure

#### create build.xml

- build.xml file will be placed in your project root directory

```
<?xml version="1.0" encoding="UTF-8"?>

<project name="application" basedir="." default="commons:help">

    <property file="build.properties"/>
    <property file="build.properties.local"/>
    
    <import file="/srv/phing/commons/standard.xml"/>
    
</project>
```

####  create build.properties file

- build.properties file will be placed in your project root directory
- project.name = the_name_of_your_project

#### create VERSION file

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
       elnebuloso/phing phing ${@:1}
```

## run script (windows powershell)

```
$dockerImage = "elnebuloso/phing"
$pwd = [string](Get-Location)
$pwd = $pwd.Replace("\", "/")
$pwdLinux = "/host_mnt/" + $pwd.Replace(":", "").ToLower()

docker pull $dockerImage
docker run -it --rm --volume /var/run/docker.sock:/var/run/docker.sock --volume ${pwd}:${pwdLinux} -w ${pwdLinux} --env-file ${pwd}/build.env $dockerImage phing $args
```
