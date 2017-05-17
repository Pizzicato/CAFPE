# CAFPE
[![Build Status](http://localhost:8090/buildStatus/icon?job=cafpe)](http://localhost:8090/job/cafpe/)

## Set up
After cloning the repository, cd into it and run:

```
$ make init
```

This sets the common git configuration values that all contributors should have in their ```.git/config``` file. More specifically, those that enable the use of shared hooks which are located in the ```.githooks``` folder.

Since git version 2.9 the default hooks folder location can be changed using ```core.hookspath```, allowing to share them among all contributors, and thus keeping commits more stadard.

The only hook configured so far is to generate documentation using ```phpDoc``` before pushing, therefore it should be installed in the development environment.

## Original base installation

### CodeIgniter via Composer

```
$ composer create-project kenjis/codeigniter-composer-installer .
```

`.htaccess` should be configured depending on production server needs.

### PHPUnit Testing environment via Composer

```
$ composer require kenjis/ci-phpunit-test --dev
$ php vendor/kenjis/ci-phpunit-test/install.php
```

## Update

```
$ composer update
```

Files should be updated manually if files in `application` folder or `index.php` change. Check [CodeIgniter User Guide](http://www.codeigniter.com/user_guide/installation/upgrading.html)
