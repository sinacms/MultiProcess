<?php
/**
 * Created by PhpStorm.
 * User: shixi_qingzhe
 * Date: 18/5/23
 * Time: 下午4:39
 */

namespace AsyncTest;

use Mutilprocessing\Async;

require_once __DIR__ . '/bootstrap.php';

class AsyncTest extends \PHPUnit_Framework_TestCase {
    public function testAsync()
    {
        Async::create()->start('task.php', ['run测试']);

        $outData = [];
        Async::wait(function($code, $out, $err) use(&$outData) {
            $outData = $out;
        });
        var_dump($outData);
    }
}