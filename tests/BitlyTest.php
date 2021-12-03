<?php


class BitlyTest extends TestCase
{

    protected static string $originlink = 'https://www.codecademy.com/courses/introduction-to-javascript/lessons/loops/exercises/review-loops';

    protected static string $short = '';

    protected \App\Services\BitLy $bitly;

    protected \App\Repositories\SystemSettings $settings;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->bitly = $this->app->make(\App\Services\BitLy::class);
        $this->settings = $this->app->make(\App\Repositories\SystemSettings::class);
    }

    public function testSystemSettings()
    {
        $this->settings->initSettingHashTable();

        $this->assertEquals(true, $this->settings->isExists());
    }

    public function testShortProccess()
    {
        self::$short = $this->bitly->shortProcess(self::$originlink);

        $this->assertNotEmpty(self::$short);

        $this->assertIsNumeric(base_convert(self::$short, 34, 10));
    }

    public function testGetOriginLink()
    {

        $originalLink = $this->bitly->getOriginalLink(self::$short);

        $this->assertEquals(self::$originlink, $originalLink);

        \Illuminate\Support\Facades\Redis::connection()->client()->flushDB();
    }

}
