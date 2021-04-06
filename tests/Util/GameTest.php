<?php

namespace App\Tests\Util;

use App\Util\Board;
use App\Util\Game;
use Exception;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testGame()
    {
        $game = new Game;
        $board = new Board;
        $board->render();

        $board->set([['X','X','X'],['','',''],['','','']]);
        $this->assertEquals('You won.', $game->isGameEnded($board));
        $board->set([['O','O','O'],['','',''],['','','']]);
        $this->assertEquals('You lost.', $game->isGameEnded($board));
        $board->set([['O','',''],['','O',''],['','','O']]);
        $this->assertEquals('You lost.', $game->isGameEnded($board));
        $board->set([['','X',''],['','X',''],['','X','']]);
        $this->assertEquals('You won.', $game->isGameEnded($board));
        $board->set([['O','X','O'],['X','O','X'],['','O','X']]);
        $this->assertEquals('Draw.', $game->isGameEnded($board));
        $board->set([['','',''],['','',''],['','','']]);
        $this->assertEquals(false, $game->isGameEnded($board));

        $this->expectException(Exception::class);
        $board->set([['',''],['',''],['','']]);
        $this->assertEquals(false, $game->isGameEnded($board));
        $board->set([[]]);
        $this->assertEquals(false, $game->isGameEnded($board));
        $board->set([['O','X','O'],['X','O','X'],['','O','X','X']]);
        $this->assertEquals(false, $game->isGameEnded($board));
    }

}
