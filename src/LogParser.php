<?php

namespace src;

use src\Interfaces\FormatterInterface;
use src\Interfaces\LoggerInterface;
use src\Interfaces\ParserInterface;
use Exception;

class LogParser
{
    /**
     * @var ParserInterface
     */
    private $logParser;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogParser constructor.
     *
     * @param ParserInterface $logParser
     * @param FormatterInterface $formatter
     * @param LoggerInterface $logger
     */
    public function __construct(ParserInterface $logParser, FormatterInterface $formatter, LoggerInterface $logger)
    {
        $this->logParser = $logParser;
        $this->formatter = $formatter;
        $this->logger = $logger;
    }

    /**
     * Выводит спарсенное содержимое файла.
     *
     * @param string $filePath
     *
     * @return string
     *
     * @throws Exception в случае ошибки выполнения.
     */
    public function output(string $filePath): string
    {
        try {
            $outputData = $this->formatter->format($this->logParser->parse($filePath));
        } catch (Exception $e) {
            $this->logger->log($e->getMessage());

            return $e->getMessage();
        }

        return $outputData;
    }
}
