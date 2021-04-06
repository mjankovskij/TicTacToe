<?php

namespace App\Tests\Util;

use App\Util\Board;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;

class TicTacToeTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        self::ensureKernelShutdown();
    }

    public function testGetMethod()
    {
        $this->client->request('GET', '/move');
        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    public function testMoveRoute()
    {
        $this->client = static::createClient();

        $board = new Board;
        $session = $this->client->getContainer()->get('session');
        $session->set('board', $board->render());
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);

        $this->client->request(
            'POST',
            '/move',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"xCoordinate":0, "yCoordinate":1}'
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
