<?php


namespace App\Console\Commands;


use App\Repositories\SystemSettings;
use Illuminate\Console\Command;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Redis;
use Predis\Client;

class SetSettings extends Command
{
    protected $signature = 'set-setting';

    protected $description = 'setting system params for application';

    public function handle(RedisManager $redis)
    {
        $this->setSettings($redis);
    }

    public function setSettings(RedisManager $client)
    {
        $systemSetting = new SystemSettings($client);
        $systemSetting->initSettingHashTable();
    }
}
