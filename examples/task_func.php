<?php
/**
 * Created by PhpStorm.
 * User: shixi_qingzhe
 * Date: 18/5/25
 * Time: 上午10:29
 */

require_once __DIR__ . '/bootstrap.php';

$gogo = 111;

\Mutilprocessing\Async::create()->startFunc(function ($test1, $test2) {
    return $test1.PHP_EOL.$test2;
}, ['test1' => 'RNG', 'test2' => 'NB']);

var_dump($outData);