<?php


namespace App\Services;

use App\Libs\ShortCreator;
use App\Repositories\SystemSettings;
use Illuminate\Redis\RedisManager;
use Predis\Client;

class BitLy
{
    protected SystemSettings $systemSettings;

    protected Client $client;

    protected const TABLE_BITES_POLICY = 3;

    public function __construct(SystemSettings $systemSettings, RedisManager $manager)
    {
        $this->systemSettings = $systemSettings;
        $this->client = $manager->client();
    }

    public function shortProcess(string $originalLink): string
    {

        $short = $this->create();

        $table = $this->systemSettings->getTableName();

        $prefix = $this->prefixLinkCreator($table);

        $this->insertShortIntoTable($table, $short, $originalLink);

        $shortLink = $this->createShortLink($short, $prefix);

        return $shortLink;
    }

    public function getOriginalLink(string $short): ?string
    {
        [$table, $shortLink] = ShortCreator::parseLink($short, self::TABLE_BITES_POLICY);

        return $this->client->hget($table, $shortLink);
    }

    protected function microTimeCreate()
    {
        return str_replace('.', '', (string) microtime(true) - (float) $this->systemSettings->getStartTime());
    }

    /**
     * @param string $short
     * @return string
     */
    protected function createShortLink($short, $prefix): string
    {
        return env('APP_URL') . '/' . $prefix . $short;
    }

    protected function insertShortIntoTable($table, $short, $originalLink)
    {
        $maxShorts = $this->systemSettings->getMaxShortsInTable();

        if ($this->client->hlen($table) < $maxShorts) {
            $this->client->hset($table, $short, $originalLink);
        } else {
            $this->systemSettings->changeCurrentTable();
            $this->insertShortIntoTable($table, $short, $originalLink);
        }

    }

    protected function create(): string
    {
        return base_convert($this->microTimeCreate(), 10, 35);
    }

    protected function prefixLinkCreator(string $table): string
    {
        while (strlen($table)  < self::TABLE_BITES_POLICY) {
            $table = "0" . $table;
        }
        return $table;
    }
}
