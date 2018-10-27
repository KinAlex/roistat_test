<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24.10.18
 * Time: 23:44
 */

namespace src;


use src\Interfaces\FormatterInterface;
use src\Interfaces\LoggerInterface;
use src\Interfaces\ParserInterface;

class LogParser
{
    private $logParser;
    private $formatter;
    private $logger;

    /**
     * LogParser constructor.
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

    public function output(string $filePath)
    {
        try {
            $outputData = $this->formatter->format($this->logParser->parse($filePath));
        } catch (\Exception $e) {
            $this->logger->log($e->getMessage());
            return ['error' => $e->getMessage()];
        }

        return $outputData;
    }
}