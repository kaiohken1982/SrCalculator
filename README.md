SrCalculator
============

A calculator test

### Description

This is a calculator that takes an equation from a string and gives the result.

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
      "kaiohken1982/srcalculator": "dev-master"
    }
}
```

index.php
```
<?php 
require __DIR__ . '/vendor/autoload.php';

use \SrCalculator\Calculator\Calculator;

//$argv[0]; // the script name
$equation = isset($argv[1]) ? $argv[1] : ''; // the first parameter
//$argv[2]; // the second parameter

try {
  $calculator = new Calculator($equation);
  echo 'Result is ' . $calculator->calculate() . PHP_EOL;
} catch (Exception $e) {
  echo 'Script ended with this message: ' . $e->getMessage() . PHP_EOL;
}
```

Run from console
```
php index.php 'your equation here'

php index.php 3*2 //6

php index.php '3*2 + 1.1 / 88' // 6.0125

php index.php '1 * hello' // error
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
