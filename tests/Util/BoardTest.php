<?php

namespace App\Tests\Util;

use App\Util\Board;
use Exception;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    private $board;

    public function setUp(): void
    {
        $this->board = new Board;
        $this->board->render();
    }

    public function testBoard()
    {
        $this->assertEquals('array', gettype($this->board->render()));
        $this->assertEquals('array', gettype($this->board->get()));
        $this->assertEquals('integer', gettype($this->board->getSize()));

        $this->assertNotEquals([], $this->board->render());
        $this->assertNotEquals([], $this->board->get());
        $this->assertNotEquals('a', $this->board->getSize());
        $this->assertNotEquals('<?', $this->board->getSize());
        $this->assertNotEquals(0, $this->board->getSize());
        $this->assertNotEquals(1, $this->board->getSize());
    }

    public function testFieldExceptions()
    {
        $this->expectException(Exception::class);
        $this->board->setMove(1, 1, 'O');
        $this->assertEquals(null, $this->board->setMove(1, 1, 'X'));
        $this->assertEquals(null, $this->board->setMove(0, 1, 'A'));
        $this->assertEquals(null, $this->board->setMove(0, 1, 'A'));
        $this->assertEquals(null, $this->board->setMove(0, 1, []));
        $this->assertEquals(null, $this->board->setMove(0, 1, 123));
        $this->assertEquals(null, $this->board->setMove(123));
        $this->assertEquals(null, $this->board->setMove(5, 10, 'O'));
    }
}
