<?php


namespace App\Repositories;


use Illuminate\Redis\RedisManager;
use Predis\Client;

class SystemSettings
{
    /**
     * @var Client
     */
    protected Client $client;

    protected const HASH_TABLE_NAME = 'settings';

    protected const TIME_START = 0;
    protected const CURRENT_TABLE = 1;
    protected const COUNT_TABLE = 2;
    protected const MAX_SHORTS_IN_TABLE = 3;

    /**
     * SystemSettings constructor.
     * @param RedisManager $manager
     */
    public function __construct(RedisManager $manager)
    {
        $this->client = $manager->client();
    }

    public function getStartTime()
    {
        return $this->client->hget(self::HASH_TABLE_NAME, self::TIME_START);
    }

    public function getTableName()
    {
        return $this->client->hget(self::HASH_TABLE_NAME, self::CURRENT_TABLE);
    }

    public function getCountTableName()
    {
        return $this->client->hget(self::HASH_TABLE_NAME, self::COUNT_TABLE);
    }

    public function getMaxShortsInTable()
    {
        return $this->client->hget(self::HASH_TABLE_NAME, self::MAX_SHORTS_IN_TABLE);
    }

    public function initSettingHashTable()
    {
        if (!$this->client->exists(self::HASH_TABLE_NAME)) {
            $this->client->transaction(function ($client) {
                $client->hset(self::HASH_TABLE_NAME, self::TIME_START, microtime(true));
                $client->hset(self::HASH_TABLE_NAME, self::CURRENT_TABLE, "1");
                $client->hset(self::HASH_TABLE_NAME, self::COUNT_TABLE, 1);
                $client->hset(self::HASH_TABLE_NAME, self::MAX_SHORTS_IN_TABLE, 100000);
            });
        }
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return $this->client->exists(self::HASH_TABLE_NAME);
    }

    public function changeCurrentTable()
    {
        $table = $this->client->hget(self::HASH_TABLE_NAME, self::CURRENT_TABLE);

        $this->client->hset(self::HASH_TABLE_NAME, self::CURRENT_TABLE, $this->incTableName($table));

        $this->incCountTable();
    }

    protected function incCountTable()
    {
        $this->client->hincrby(self::HASH_TABLE_NAME, self::COUNT_TABLE, 1);
    }

    protected function incTableName($table): string
    {
        $tableName = (int) base_convert($table, 36, 10);
        return base_convert(++$tableName, 10, 36);
    }
}
