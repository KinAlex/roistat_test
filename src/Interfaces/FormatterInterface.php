<?php

namespace src\Interfaces;

/**
 * Interface FormatterInterface
 *
 *
 */
interface FormatterInterface
{
    /**
     * Преобразует массив в определенную структуру.
     *
     * @param array $array
     *
     * @return string
     */
    public function format(array $array): string;
}
