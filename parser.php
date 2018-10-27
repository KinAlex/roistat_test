#!/usr/bin/php

<?php
require_once 'autoload.php';

if ($argc > 1 && is_file($argv[1])) {
    //TODO add DIC in future
    $nginxLogParser = new src\NginxLogParser();
    $jsonFormatter = new src\JsonFormatter();
    $logger = new src\FileLogger('log.txt');
    $parseOutput = (new src\LogParser($nginxLogParser, $jsonFormatter, $logger))->output($argv[1]);
    echo $parseOutput;
    exit;
}

echo 'Incorrect input log file.';
?>