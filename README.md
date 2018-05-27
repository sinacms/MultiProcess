# PHP Mutilprocessing

    This is high performance PHP Mutilprocessing Task Manager written in PHP.
	

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

Async::join(function($code, $out, $err) use(&$outData) {
//    var_dump($code, $out, $err);
    $outData = $out;
});

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
  * public static function run($scriptname, $args, $envs = [])
  * public static function discard()
  * public static function join(callable $logHandler = null)



