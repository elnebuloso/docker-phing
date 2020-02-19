# docker-phing

![Release](https://github.com/elnebuloso/docker-phing/workflows/Release/badge.svg)
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
    <import file="/srv/phing/commons/base.xml"/>
</project>
```

##### commons templates

- use commons templates with pre-defined configurations
- import the specific commons in your build.xml

```
<import file="/srv/phing/commons/base.xml"/>
```

```
<import file="/srv/phing/commons/bolt3.xml"/>
```

```
<import file="/srv/phing/commons/laravel5.xml"/>
```

```
<import file="/srv/phing/commons/laravel6.xml"/>
```

```
<import file="/srv/phing/commons/lumen5.xml"/>
```

```
<import file="/srv/phing/commons/lumen6.xml"/>
```

```
<import file="/srv/phing/commons/symfony4.xml"/>
```

```
<import file="/srv/phing/commons/symfony5.xml"/>
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

## run scripts

- [see linux bash script](https://github.com/elnebuloso/docker-phing/blob/master/phing.sh)
- [see windows powershell script](https://github.com/elnebuloso/docker-phing/blob/master/phing.ps1)

## phing targets

- calling phing without target, outputs complete help overview

```
phing
```

- calling phing with target and specific target help
- echo target has a sub-target :help

```
phing TARGETNAME
phing TARGETNAME:help
```

## available tools

- **docker** *19.03.6*
- **docker-compose** *1.25.1*
- **kubectl** *v1.17.3*

## available tools via dockerception

- some features are available through docker containers
- all features can be configured through docker environment variables when calling the phing container
- all featured are defined with default variables
- use the environment variable in your build.env file to configure this feature

### dockerception tools with defaults

### [closure-compiler](docker/bin/closure-compiler.sh)

```
PHING_CLOSURE_COMPILER=elnebuloso/google-closure-compiler:latest
```

### [compass](docker/bin/compass.sh)

```
PHING_COMPASS=elnebuloso/compass:latest
```

### [composer](docker/bin/composer.sh)

```
PHING_COMPOSER=composer
```

### [csso](docker/bin/csso.sh)

```
PHING_CSSO=elnebuloso/csso-cli:latest
```

### [csso](docker/bin/helm.sh)

```
PHING_CSSO=alpine/helm:latest
```

### [npm](docker/bin/npm.sh)

```
PHING_NPM=node:lts-alpine
```

### [phpmetrics1](docker/bin/phpmetrics1.sh)

```
PHING_PHPMETRICS1=elnebuloso/php-phpmetrics:1
```

### [phpmetrics2](docker/bin/phpmetrics2.sh)

```
PHING_PHPMETRICS2=elnebuloso/php-phpmetrics:2
```

### [prettier](docker/bin/prettier.sh)

```
PHING_PHPMETRICS2=elnebuloso/prettier:latest
```

### [prettier](docker/bin/prettier.sh)

```
PHING_PRETTIER=elnebuloso/prettier:latest
```

### [sonarqube-scanner](docker/bin/sonarqube-scanner.sh)  

```
PHING_SONARQUBE_SCANNER=elnebuloso/sonarqube-scanner:latest
```

### [yarn](docker/bin/yarn.sh)

```
PHING_YARN=node:lts-alpine
```