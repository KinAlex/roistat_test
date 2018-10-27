<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.10.18
 * Time: 0:27
 */

namespace src;


use src\Interfaces\LoggerInterface;

class FileLogger implements LoggerInterface
{
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function log(string $string)
    {
        return file_put_contents($this->filePath, date('Y:m:d H:i:s').' '.$string."\r\n",  FILE_APPEND|LOCK_EX);
    }
}