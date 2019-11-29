<?php

namespace src\Interfaces;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * Парсит файл.
     *
     * @param string $filePath
     *
     * @return array
     */
    public function parse(string $filePath) : array;
}
