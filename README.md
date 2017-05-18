# CAFPE
[![Build Status](http://localhost:8090/buildStatus/icon?job=cafpe)](http://localhost:8090/job/cafpe/)

## Needed software for development

    - [Git](https://git-scm.com/)
    - [Composer](https://getcomposer.org/)

## Set up
After cloning the repository, cd into it and run:

```
$ make init
```

This sets the common git configuration values that all contributors should have in their ```.git/config``` file. More specifically, those that enable the use of shared hooks which are located in the ```.githooks``` folder.

Since git version 2.9 the default hooks folder location can be changed using ```core.hookspath```, allowing to share them among all contributors, and thus keeping commits more stadard.

The only hook configured so far (pre-commit) regenerates documentation using ```phpDoc``` before pushing, therefore it should be installed in the development environment.

Then install required packages via composer:

```
$ composer install
```

Run install script for CodeIgniter PHPUnit tests integration:
```
$ php vendor/kenjis/ci-phpunit-test/install.php
```

After that edit ```application/tests/Bootstrap.php``` and remove comments in Monkey Patching section.

## Tests

To run tests:

```
$ vendor/bin/phpunit  -c application/tests
```

## Update

```
$ composer update
```

Files should be updated manually if files in `application` folder or `index.php` change. Check [CodeIgniter User Guide](http://www.codeigniter.com/user_guide/installation/upgrading.html)
