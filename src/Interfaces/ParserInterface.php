<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.10.18
 * Time: 23:47
 */

namespace src\Interfaces;


interface ParserInterface
{
    public function parse(string $filePath) : array;
}