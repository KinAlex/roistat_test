<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.10.18
 * Time: 0:09
 */

namespace src;


use src\Interfaces\FormatterInterface;

class JsonFormatter implements FormatterInterface
{
    public function format(array $array)
    {
        return json_encode($array, JSON_PRETTY_PRINT);
    }
}