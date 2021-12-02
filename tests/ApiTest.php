<?php


class ApiTest extends TestCase
{
    protected static $originalLink = 'https://www.codecademy.com/courses/introduction-to-javascript/lessons/loops/exercises/review-loops';

    protected static $short = '';

    public function testSuccessDataShort()
    {
        $response = $this->post('/api/shortlink', ['url' => self::$originalLink], []);
        $response->assertResponseStatus(200);
        $content = \json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('short',$content);
        self::$short = $content['short'];
    }

    public function testValidGetOrigin()
    {
        $response = $this->get(self::$short);
        $response->assertResponseStatus(302);
        $this->response->assertHeader('Location', self::$originalLink);
    }

    public function testEmptyDataShort()
    {
        $response = $this->post('/api/shortlink', [], []);
        $response->assertResponseStatus(422);
    }

    public function testEmptyHeadersShort()
    {
        $response = $this->post('/api/shortlink', ['url' => self::$originalLink], []);
        $response->assertResponseStatus(200);
    }

    public function testInvalidDataShort()
    {
        $response = $this->post('/api/shortlink', ['url' => 'fsdfsdfsdfsdfdsfgx'], []);
        $response->assertResponseStatus(422);
    }

    public function testInvalidGetOrigin()
    {
        $response = $this->get('/' . 'sdf234321asdcsds');
        $response->assertResponseStatus(404);
    }

}