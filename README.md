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
composer require sinacms/mutilprocessing
```   

## Usage

### distribute tasks and async execute

```php
<?php

use Mutilprocessing\Async;

Mutilprocessing\Async::create()->run('task.php', ['runTest'.$i]);
```

### sync wait for all process end


```php
<?php

use Mutilprocessing\Async;

Mutilprocessing\Async::join(function($code, $out, $err) use(&$outData) {
//    var_dump($code, $out, $err);
    $outData = $out;
});

```

### clean all task

```php
<?php

use Mutilprocessing\Async;

Mutilprocessing\Async::discard();
```


## Documentation
  * ### Async
   * ### option shorthand
  * public static function create()
  * public static function run($scriptname, $args, $envs = [])
  * public static function discard()
  * public static function join(callable $logHandler = null)



