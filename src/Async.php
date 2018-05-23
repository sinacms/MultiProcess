<?php

namespace Mutilprocessing;

class Async
{
    protected static $instances = [];
    protected $pipes;
    protected $proccess;

    public static function create()
    {
        return self::$instances[] = new self();
    }

    public static function discard()
    {
        self::$instances = [];
    }

    public function run($scriptname, $args, $envs = [])
    {
        $argsStr = escapeshellarg(base64_encode(json_encode($args)));
        $this->proccess = proc_open(
            "php $scriptname '$argsStr' & ",
            array(
                0 => array('pipe', 'r'), //stdin (用fwrite写入数据给管道)
                1 => array('pipe', 'w'), //stdout(用stream_get_contents获取管道输出)
                2 => array('pipe', 'w'), //stderr(用stream_get_contents获取管道输出)
            ),
            $this->pipes,
            '.', //当前PHP进程的工作目录
            $envs //php.ini 配置 variables_order = "EGPCS" 其中E表示$_ENV,否则$_ENV输出为空
        );
        return $this;
    }


    public static function join(callable $logHandler = null)
    {
        foreach (self::$instances as $inst) {
            $pipes = $inst->pipes;
            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $status = proc_close($inst->proccess);
            $logHandler($status, $stdout, $stderr);
            $data[] = array(
                'stdout' => $stdout,
                'stderr' => $stderr,
                'status' => $status,
            );
        }
    }
}

