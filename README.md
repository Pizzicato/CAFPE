# CAFPE
[![Build Status](http://localhost:8090/buildStatus/icon?job=cafpe)](http://localhost:8090/job/cafpe/)
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
