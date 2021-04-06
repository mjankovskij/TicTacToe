<?php

namespace App\Tests\Util;

use App\Util\Board;
use App\Util\CPU;
use Exception;
use PHPUnit\Framework\TestCase;

class CPUTest extends TestCase
{
    public function testCPU()
    {
        $cpu = new CPU;
        $board = new Board;
        $board->render();

        $board->set([['X','',''],['','',''],['','','']]);
        $this->assertEquals([1,1], $cpu->getMove($board, 1));
        $board->set([['','X',''],['','X',''],['','','']]);
        $this->assertEquals([1,2], $cpu->getMove($board, 1));
        $board->set([['','',''],['','X',''],['','X','']]);
        $this->assertEquals([1,0], $cpu->getMove($board, 1));
    }

}
