<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/5/23
 * Time: 下午4:45
 */

sleep(3);

print_r([microtime(1), json_decode(base64_decode($argv[1]), 1)]);