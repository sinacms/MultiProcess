<?php
/**
 * Created by PhpStorm.
 * User: shixi_qingzhe
 * Date: 18/5/29
 * Time: 下午5:23
 */

namespace AsyncTest;

use Mutilprocessing\Async;

require_once __DIR__ . '/bootstrap.php';

class AsyncCallbackTest extends \PHPUnit_Framework_TestCase
{



    public function testAsyncCallback()
    {
        Async::create() -> startFunc(function ($test1, $test2)
        {
            echo $test1.$test2;

            if ($test2) {
                echo "this is if";
            }

            for ($i = 1;$i < 10;$i++) {
                echo $i;
            }

        }, ['test1' => 'test1', 'test2' => 'test2']);

        Async::wait(function ($code, $out, $err) use (&$outData) {
//            var_dump([$code, $out, $err]);
            $outData = $out;
        });
        $this -> assertNotNull('outData');

    }
}