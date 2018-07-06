# PHP Mutilprocessing

    This is high performance PHP Mutilprocessing Task Manager written in PHP, compatible with PHP-FPM and CLI.
	

## Contents

 * [Feature](#feature)
 * [Installation](#installation)
 * [Usage](#usage)
   * [Async-Multi-Tasks](#async-multi-tasks)
 * [Documentation](#documentation)
   * [Async](#Async)
   
   
## Feature
 - By using this tool, PHP scripts can be invoked asynchronously based on multi processes, and finally wait for each process to return results, saving lots of time.
 
 - graceful and efficient

 - can get callable function return value
 
## Installation
You can use composer to install this library from the command line.

```bash
composer require sinacms/multiprocess
```   

## Usage

### distribute tasks and async execute

```php
<?php

use Mutilprocessing\Async;

Async::create()->run('task.php', ['runTest'.$i]);
```

### distribute tasks by a simple function and async execute

!!! WARN:please don't insert a '&&&' string in echo and return for some reason it will break down the program run

```php
<?php

use Mutilprocessing\Async;

Async::create()->startFunc(function($param1, $param2) {
    echo $param1.$param2.PHP_EOL;
}, ['param1' => 'hello', 'param2' => ' world'])

$func = function ($param1, $param2) {
    echo "this is an another func";
};

Async::create()->startFunc($func, ['param1' => 'hello', 'param2' => ' PHP']); 
```

### sync wait for all process end


```php
<?php

use Mutilprocessing\Async;
$outData = [];
Async::join(function($code, $out, $err) use(&$outData) {
//    var_dump($code, $out, $err);
//  you can handle code runtime exception like this
	 if (strlen($err) != 0) {
	 	//  do sth.
	 }
	 // and you can get return value like this
	 // more function detail see examples :)
	 array_push($outData, \Mutilprocessing\Async::getReturn($out));
});

```

outData structure:

echos represent echos in execute

returns represent return in execute

```
array(4) {
  [0] =>
  array(2) {
    'echos' =>
    string(5) "hello"
    'returns' =>
    string(0) ""
  }
  [1] =>
  array(2) {
    'echos' =>
    string(6) "KZ RNG"
    'returns' =>
    string(10) "return 777"
  }
  [2] =>
  array(2) {
    'echos' =>
    string(17) "EDG AFSreturn 888"
    'returns' =>
    string(0) ""
  }
  [3] =>
  array(2) {
    'echos' =>
    string(6) "SKT RW"
    'returns' =>
    string(10) "return 666"
  }
}

```


### getArgs passed from Async::start

```php
// please pass $argv[1] to get args
<?php

use Mutilprocessing\Async;

Async::getArgs($argv[1]);
```

### clean all task

```php
<?php

use Mutilprocessing\Async;

Async::discard();
```


## Documentation
  * ### Async
   * ### option shorthand
  * public static function create()
  * public static function start($scriptname, $args, $envs = [])
  * public function startFunc(callable $function, $args = [])
  * public static function discard()
  * public static function wait(callable $logHandler = null)
  * public static function getArgs($argv = null)
  * public static function getReturn($out)
  * ### FunctionParser
   * ### option shorthand
  * public static function genTmp(callable $function)



