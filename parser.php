#!/usr/bin/php

<?php

require_once 'autoload.php';

$inputFilePath = getopt('f:')['f'];
if ($inputFilePath) {
    //TODO use DIC
    $nginxLogParser = new src\NginxLogParser();
    $jsonFormatter = new src\JsonFormatter();
    //TODO use psr-3
    $logger = new src\FileLogger('log.txt');
    $parseOutput = (new src\LogParser($nginxLogParser, $jsonFormatter, $logger))->output($inputFilePath);
    echo $parseOutput;

    exit;
}

echo "Incorrect input log file.\n";
