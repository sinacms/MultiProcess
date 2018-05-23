<?php
//error_reporting(E_ERROR);
ini_set('display_errors', 0);
//asdf();
sleep(3);


//echo 'input1: '.stream_get_contents(STDIN).PHP_EOL;
//echo 'input: '.file_get_contents('php://input').PHP_EOL;
print_r([microtime(1), json_decode(base64_decode($argv[1]), 1)]);
//file_put_contents('dbg.log', $str, 8);
