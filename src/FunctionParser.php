<?php
/**
 * Created by PhpStorm.
 * User: shixi_qingzhe
 * Date: 18/5/25
 * Time: 上午10:52
 */

namespace Mutilprocessing;

class FunctionParser
{
    public static function genTmp(callable $function)
    {
        $reflect = new \ReflectionFunction($function);
        $filename = $reflect -> getFileName();
        $startLine = $reflect -> getStartLine();
        $endLine = $reflect -> getEndLine();
        $fileContent = file_get_contents($filename);
        $fileArr = explode(PHP_EOL, $fileContent);
        $codeBlock = [];
        for($i = $startLine - 1;$i <= $endLine;$i++) {
            $codeBlock[] = $fileArr[$i];
        }
        $headFound = false;
        $footFound = false;
        $headPtr = 0;
        $footPtr = 0;
        $codeBlockStr = implode('', $codeBlock);
        $i = 0;$j = strlen($codeBlockStr) - 1;
        while($i <= $j) {
            if ($headFound == true && $footFound = true) {
                break;
            }
            if ($codeBlockStr[$i] == "{") {
                $headPtr = $i;
                $headFound = true;
            }
            $i++;
            if ($codeBlockStr[$j] == "}") {
                $footPtr = $j;
                $footFound = true;
            }
            $j--;
        }
        $codeBlockStrReal = substr($codeBlockStr, $headPtr + 1, $footPtr - $headPtr - 1);
        return $codeBlockStrReal;
    }
}