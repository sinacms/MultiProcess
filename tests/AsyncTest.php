<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/5/23
 * Time: 下午4:39
 */

namespace AsyncTest;

use Mutilprocessing\Async;

require_once __DIR__ . '/bootstrap.php';

class AsyncTest extends \PHPUnit_Framework_TestCase {
    public function testAsync()
    {
        Async::create()->run('task.php', ['run测试']);

        $outData = [];
        Async::join(function($code, $out, $err) use(&$outData) {
            $outData = $out;
        });
        var_dump($outData);
    }
}