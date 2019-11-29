<?php

namespace src;

use src\Interfaces\FormatterInterface;

/**
 * Class JsonFormatter
 */
class JsonFormatter implements FormatterInterface
{
    /**
     * {@inheritDoc}
     */
    public function format(array $array): string
    {
        return json_encode($array, JSON_PRETTY_PRINT);
    }
}
