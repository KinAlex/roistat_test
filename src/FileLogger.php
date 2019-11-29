<?php

namespace src;

use src\Interfaces\LoggerInterface;

class FileLogger implements LoggerInterface
{
    /**
     * Путь к файлу.
     *
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * {@inheritDoc}
     */
    public function log(string $string): void
    {
        file_put_contents($this->filePath, date('Y:m:d H:i:s').' '.$string."\r\n",  FILE_APPEND|LOCK_EX);
    }
}
