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
    return "return 777";
};

$func2 = function ($test1, $test2)
{
    echo $test1.$test2;

    if (false) {
        echo "6666";
    } else {
        echo "as65d4";
    }

    return "return 666";


};

$func1 = function ($test1, $test2)
{
    echo $test1.$test2;

    echo "return 888";
};

\Mutilprocessing\Async::create()->startFunc($func2, ['test1' => 'SKT', 'test2' => ' RW']);
\Mutilprocessing\Async::create()->startFunc($func, ['test1' => 'SKT', 'test2' => ' RW']);

$outData = [];
\Mutilprocessing\Async::wait(function ($code, $out, $err) use (&$outData) {
    if (strlen($err) != 0) {
        print_r($err);
    }
    array_push($outData, \Mutilprocessing\Async::getReturn($out));
});

var_dump($outData);