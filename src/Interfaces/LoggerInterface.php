<?php

namespace src\Interfaces;

/**
 * Interface LoggerInterface
 */
interface LoggerInterface
{
    /**
     * Логирует информацию.
     *
     * @param string $string
     */
    public function log(string $string): void;
}
