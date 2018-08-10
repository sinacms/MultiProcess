<?php

namespace Mutilprocessing;

require_once __DIR__ . '/FunctionParser.php';
require_once __DIR__ . '/Exception/FileNotFoundException.php';

use Mutilprocessing\Exception\FileNotFoundException;
use Mutilprocessing\FunctionParser;

class Async
{
    protected static $instances = [];

    protected $pipes;

    protected $proccess;

    protected $logHandler;

    /**
     * Create a Async object
     * @return Async
     */
    public static function create()
    {
        return self::$instances[] = new self();
    }

    /**
     * Clear all Async execution objects
     */
    public static function discard()
    {
        self::$instances = [];
    }

    /**
     * Asynchronous execution of a Script file
     * @param $scriptname <p>
     * The script name that you want to execute asynchronously requires the suffix name .php.
     * </p>
     * @param array $args <p>
     * Input you want to execute the required parameters in function
     * </p>
     * @param array $envs
     * @return $this
     */
    public function start($scriptname, $args = [], $envs = [])
    {
        if ($scriptname == 'callbackStub.php') {
            $cwd = __DIR__;
        } else {
            $cwd = '.';
            // judge if file exists
            if (!is_file($scriptname)) {
                throw new FileNotFoundException($scriptname." is not found");
            }
        }
        if ($args == []) {
            $argsStr = '';
        } else {
            $argsStr = escapeshellarg(base64_encode(json_encode($args)));
        }
        $this -> argStr = $argsStr;
        $this->proccess = proc_open(
            "php $scriptname '$argsStr' & ",
            array(
                0 => array('pipe', 'r'), //stdin (用fwrite写入数据给管道)
                1 => array('pipe', 'w'), //stdout(用stream_get_contents获取管道输出)
                2 => array('pipe', 'w'), //stderr(用stream_get_contents获取管道输出)
            ),
            $this->pipes,
            $cwd, //当前PHP进程的工作目录
            $envs //php.ini 配置 variables_order = "EGPCS" 其中E表示$_ENV,否则$_ENV输出为空
        );
        return $this;
    }

    /**
     * Asynchronous execution of a function
     * @link https://github.com/sinacms/MultiProcess
     * @param callable $function <p>
     * Input a callable function which you want to exec asynchronous
     * </p>
     * @param array $args <p>
     * Input you want to execute the required parameters in function
     * </p>
     */
    public function startFunc(callable $function, $args = [])
    {
        $funcBody = FunctionParser::genTmp($function);
        $args['body'] = $funcBody;
        $this -> start('callbackStub.php', $args);
    }

    /**
     * Waiting for all asynchronous execution processes to return to the result
     * @param callable|null $logHandler
     */
    public static function wait(callable $logHandler = null)
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

    /**
     * Get the incoming parameters
     * @param null $argv <p>
     * Be sure to import $argv[1] to get the parameters of script execution.
     * </p>
     * @return mixed if key is null or sth can found in params | null if no args input | false If there is no corresponding key here
     */
    public static function getArgs($argv = null, $key = null)
    {
        if ($argv == null) {
            return null;
        }
        $params = json_decode(base64_decode($argv), 1);
        if ($key == null) {
            return $params;
        }
        return isset($params[$key]) ? $params[$key] : false;

    }


    /**
     * Get output and return values
     * @param $return
     * @return array
     */
    public static function getReturn($return)
    {
        $returns = explode("&&&", $return);
        return [
            'echos' => $returns[0],
            'returns' => isset($returns[1]) ? base64_decode($returns[1]) : null
            ];
    }

    // todo Register callback function

    public function regCallback(callable $callback)
    {

    }

    // todo add multi async execution like add()->add()->start();


}

