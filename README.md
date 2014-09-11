SrCalculator
============

A calculator test

### Scenario

### Goals 

### How to use this module 

Install using composer

composer.json
```
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/kaiohken1982/SrCalculator.git"
      }
    ],
    "require": {
      "kaiohken1982/cardtest": "dev-master"
    }
}
```

index.php
```

```

Run from console
```
php index.php
```

### Run unit test 

Please note you must be in the module root. 

``` 
curl -s http://getcomposer.org/installer | php 
php composer.phar install 
./vendor/bin/phpunit 
``` 

If you have xdebug enabled and you want to see 
code coverage run the command below

``` 
./vendor/bin/phpunit --coverage-html data/coverage 
```
