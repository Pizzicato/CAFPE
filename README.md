# CAFPE
[![Jenkins](https://img.shields.io/jenkins/s/http/ftae31.ugr.es:8090/job/Pizzicato/job/CAFPE/job/master.svg)]()
[![Jenkins](https://img.shields.io/jenkins/t/http/ftae31.ugr.es:8090/job/Pizzicato/job/CAFPE/job/master.svg)]()

## Needed software for development

  - Linux or OSX
  - [Git](https://git-scm.com/): Version control
  - [PHP](http://php.net/)
  - [SQLite](https://sqlite.org): Database
  - [Composer](https://getcomposer.org/): PHP Package installer
  - [Node and npm](https://nodejs.org/): Build assets and some development features
  - [Docker](https://www.docker.com/): Centos 7 running Apache server container with the same configuration as the production environment

## Set up
Follow each section below and run all the commands in the same order as listed.

### Clone repository
```
$ mkdir <repo-dir>
$ git clone https://github.com/Pizzicato/CAFPE.git <repo-dir>
$ cd <repo-dir>
$ make init
```

### Shared hooks
When running ```make init``` among other actions, the common git configuration values that all contributors should have in their ```.git/config``` folder are set. More specifically, those that enable the use of shared hooks which are located in the ```.githooks``` folder.

Since git version 2.9 the default hooks folder location can be changed using ```core.hookspath```, allowing to share them among all contributors, and thus keeping commits more standard.

The only hook configured so far (pre-commit) regenerates documentation using [apiGen](https://github.com/apigen/apigen) when commiting the changes to the repo. This PHP package is installed in the next section.

### PHP Packages
To install the required PHP packages:

```
$ composer install
```

### Local web server
There is a Docker container with the same configuration and software version as the production environment. To use it:

```
$ docker pull pizzicato/centos7-apache-php54-sqlite3
$ docker run --name <name>  -d -p 8020:80 -v <repo-dir>:/var/www/ pizzicato/centos7-apache-php54-sqlite3
```

### Assets generation and development utilities
Node and npm are used for this purpose. To install all needed modules:
```
$ npm install
```

The package.json file npm scripts are the same ones used for deploying the app run by ```deploy.bash```.

It contains two main scripts, run them in liste order to start developing:

Assets creation from sources (SCSS, javascripts, images and fonts)
```
$ npm run build
```
Automatic browse reload when assets change and automatic rebuild of assets if sources are changed:
```
$ npm run watch
```

## Tests

To run tests:

```
$ vendor/bin/phpunit -c application/tests
```

## Updating

```
$ composer update
```

Since 'kenjis/ci-phpunit-test' and 'kenjis/codeigniter-cli' packages use install scripts to copy files from ```vendor/``` to ```application/```, in case they are updated, they might have to be run again.

If there is a new CodeIgniter package release, before pushing changes to repo, check if dependent packages have been updated accordingly.

Note that CodeIgniter base index.php file is in html/, and it's been been changed from the original source code for different reasons. In case this file is updated, it would have to be moved to the html/ folder, check changed lines and solve conflicts.

## Documentation
Chech the ApiGen autogenerated documentation [here](https://pizzicato.github.io/CAFPE/). As described above, it's regenerated automatically before every commit.
