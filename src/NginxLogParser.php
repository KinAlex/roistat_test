<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.10.18
 * Time: 0:40
 */

namespace src;


use http\Exception\InvalidArgumentException;
use src\Interfaces\ParserInterface;

class NginxLogParser implements ParserInterface
{
    private CONST REG_EXP = '/(.*) - - \[(.*)\] "(.{1,8}) (.*) (.*)" (\d{3}) (\d+) "(.*)" "(.*)"/';
    private $bots = [
        'Google' => 'Googlebot',
        'Bing' => 'Bingbot',
        'Yahoo' => 'Slurp',
        'DuckDuckGo' => 'DuckDuckBot',
        'Baiduspider' => 'Baiduspider',
        'Yandex' => 'Yandex',
        'Sogou' => 'Sogou',
        'Exabot' => 'Exabot',
        'Facebook' => 'facebookexternalhit',
        'Alexa' => 'ia_archiver',
    ];

    public function parse(string $filePath) : array
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException('Incorrect file path.');
        }

        $views = 0;
        $traffic = 0;
        $crawlers = [];
        $urls = [];
        $statusCodes = [];
        foreach ($this->getRows($filePath) as $row) {
            preg_match(self::REG_EXP, $row, $matches);
            $ip = $matches[1];
            $date = $matches[2];
            $requestType = $matches[3];
            $url = $matches[4];
            $protocol = $matches[5];
            $status = $matches[6];
            $bytesSent = $matches[7];
            $referer = $matches[8];
            $userAgent = $matches[9];

            $urls[$url] = 1;

            $statusCodes[$status] = isset($statusCodes[$status]) ? $statusCodes[$status] += 1 : $statusCodes[$status] = 1;

            foreach ($this->bots as $botName => $botUserAgent) {
                if (stripos($userAgent, $botUserAgent) !== false) {
                    $crawlers[$botName] = isset($crawlers[$botName]) ? $crawlers[$botName] += 1 : $crawlers[$botName] = 1;
                }
            }

            //TODO check if bcmath needed
            $traffic += $bytesSent;

            $views++;
        }

        return [
            'views' => $views,
            'urls' => count($urls),
            'crawlers' => $crawlers,
            'traffic' => $traffic,
            'statusCodes' => $statusCodes,
        ];
    }

    private function getRows($filePath)
    {
        $f = fopen($filePath, 'r');
        try {
            while ($line = fgets($f)) {
                yield $line;
            }
        } finally {
            fclose($f);
        }
    }

    public function setBots(array $botsArray)
    {
        $this->bots = $botsArray;
    }
}