<?php
/**
 * Created by PhpStorm.
 * User: shixi_qingzhe
 * Date: 18/5/25
 * Time: 下午4:16
 */

require_once __DIR__ .'/bootstrap.php';

$func = function ($test1, $test2)
{
    echo $test1.$test2;
    echo PHP_EOL."666";
    echo PHP_EOL."777";
    echo PHP_EOL."888";
    echo PHP_EOL."999";
    if ($test2) {
        echo "this is if";
    }

    for ($i = 1;$i < 10;$i++) {
        echo $i;
    }
    echo PHP_EOL."999";
    echo PHP_EOL."999";
    echo PHP_EOL."999";

};

\Mutilprocessing\Async::create()->startFunc(function () {
    echo "hello";
}, ['test1' => 'KZ', 'test2' => ' RNG']);

\Mutilprocessing\Async::create()->startFunc($func, ['test1' => 'KZ', 'test2' => ' RNG']);


\Mutilprocessing\Async::wait(function ($code, $out, $err) use (&$outData) {
    var_dump($out);
});
