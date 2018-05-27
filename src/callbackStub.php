<?php
/**
 * a Stub for execute a simple function
 * Created by PhpStorm.
 * User: shixi_qingzhe
 * Date: 18/5/25
 * Time: 下午4:41
 */


$fn = function($code, $args){
    extract($args, EXTR_SKIP);
    return  eval($code);
};
$args_decode = json_decode(base64_decode($argv[1]), 1);

$fn($args_decode['body'], $args_decode);