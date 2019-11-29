<?php

namespace src;

use src\Interfaces\ParserInterface;
use Generator;

/**
 * Class NginxLogParser
 */
class NginxLogParser implements ParserInterface
{
    /**
     * Регулярное выражение, по которому разбивается лог.
     *
     * @var string
     */
    private $regExp= '/(.*) - - \[(.*)\] "(.{1,8}) (.*) (.*)" (\d{3}) (\d+) "(.*)" "(.*)"/';

    /**
     * Список ботов.
     *
     * @var array
     */
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

    /**
     * Парсит файл лога.
     *
     * @param string $filePath
     *
     * @return array
     */
    public function parse(string $filePath) : array
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException('Incorrect file path.');
        }

        $views = 0;
        $traffic = 0;
        $crawlers = [];
        $urls = [];
        $statusCodes = [];
        foreach ($this->getRows($filePath) as $row) {
            preg_match($this->regExp, $row, $matches);
            $url = $matches[4];
            $status = $matches[6];
            $bytesSent = $matches[7];
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

    /**
     * Получаем генератор.
     *
     * @param $filePath
     *
     * @return Generator
     */
    private function getRows($filePath): Generator
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

    /**
     * @param array $botsArray
     */
    public function setBots(array $botsArray): void
    {
        $this->bots = $botsArray;
    }
}
