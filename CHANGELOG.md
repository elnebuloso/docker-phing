# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).


## [4.4.0] - 2020-06-21
- add development user and group with id 1000 to use in context like wsl2 etc.


## [4.3.1] - 2020-05-06
- properties:ci:git updated, not using gitversion
- gitversion exception on shallow git fetch


## [4.3.0] - 2020-05-06
- updated php dependencies
- update gitversion to https://github.com/gittools/gitversion/releases/tag/5.3.2
  - gitversion bin name changed


## [4.2.4] - 2020-04-13
- updated grav1 init
- updated sulu2 init


## [4.2.0] - 2020-02-19
- added init application target for https://getgrav.org/
- updated sulu2 docker-compose stack


## [4.1.0] - 2020-02-19
- README.md Updates
- added Phing Runner Bash Script
- added Phing Runner Powershell Script
- renamed commons/standard.xml to commons/base.xml
- added docker login target


## [4.0.0] - 2020-02-19
- configuration update
- configuration via yml file
- properties overrides via branch configuration


## [3.7.0] - 2020-01-23
- fixed resource files
- added docker layer dev, dev-composer, dev-phpunit


## [3.6.0] - 2020-01-17
- fixed docker push behavior


## [3.5.0] - 2020-01-17
- added helm dockerception


## [3.4.1] - 2020-01-17
- bugfix clean:dist, removed as dependency


## [3.4.0] - 2020-01-16
- added prettier dockerception


## [3.3.0] - 2020-01-16
- updated target dependencies
- phpdepend 2.6.1
- phpcpd 4.1.0
- phploc 5.0.0
- phpmd 2.8.1


## [3.2.0] - 2020-01-16
- dropped support php 5.6
- dropped support php 7.1
- default php interpreter 7.4
- fixed application init resources


## [3.1.0] - 2020-01-16
- added npm/yarn upgrade


## [3.0.0] - 2020-01-14
- renamed build properties to underscore notation


## [2.14.0] - 2020-01-13
- updated init resources


## [2.13.0] - 2020-01-12
- updated docker:push, ability to automated push of images by semver
- disabled automated docker:push latest image
- disabled automated docker:push images by semver


## [2.12.0] - 2020-01-11
- added gitversion
- updated docker:build target with new config variables, defined by docker config task
- updated docker:push target with new config variables, defined by docker config task


## [2.11.0] - 2020-01-10
- running composer via dockerception or projectDocker
- removed commons:init
- removed autoloading of custom commons
- fixed commons help targets and descriptions
- updated bolt3 application support
- updated laravel5 application support
- updated laravel6 application support
- updated lumen5 application support
- updated lumen6 application support
- updated symfony4 application support
- added symfony5 application support
- added phpunit test support
- cleanup


## [2.10.1] - 2019-11-03
- bugfix project:version:commit for branches


## [2.10.0] - 2019-11-02
- removed gather environment variables


## [2.9.0] - 2019-10-04
- removed rancher1 targets
- commons:init added
- targets now have :init target depending on


## [2.8.0] - 2019-09-24
- init laravel 6
- init lumen 6


## [2.7.1] - 2019-09-21
- help bugfixes


## [2.7.0] - 2019-09-17
- symfony4 installation update


## [2.6.0] - 2019-08-28
- phpunit testing


## [2.5.0] - 2019-08-23
- init symfony 4 type (min|api|web|full)


## [2.4.0] - 2019-08-19
- init applications update
- init symfony 4 with web|api pre-defined


## [2.3.0] - 2019-08-13
- changed docker contexts in init resources


## [2.2.0] - 2019-06-18
- added import possibility for custom targets
- added rancher1 catalog update
- removed jenkins user


## [2.1.0] - 2019-06-18
### Changed
- added init for bolt3 cms
- configuring composer task


## [2.0.0] - 2019-06-06
### Changed
- rewritten properties to camelCase
- added target before and target after to targets


## [1.5.0] - 2019-04-19
### Changed
- added init target for laravel projects


## [1.4.0] - 2019-04-19
### Changed
- added init target for laravel-lumen5 projects


## [1.3.0] - 2019-04-19
### Changed
- added init target for symfony4 projects


## [1.2.0] - 2019-04-19
### Changed
- added sonarqube report scanner target


## [1.1.0] - 2019-03-14
### Changed
- default jenkins user added to docker group


## [1.0.0] - 2019-03-13
### Changed
- Initial Release
