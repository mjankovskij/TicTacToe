<?php

namespace App\Util;

use App\Util\Validator\BoardValidator;
use Exception;
use Symfony\Component\HttpFoundation\Session\Session;

class Board
{
    private $boardSize = 3;
    private $board;
    private $validator;

    public function __construct()
    {
    $this->validator = new BoardValidator;
    }
    
    public function render()
    {
        $this->board = [];
        foreach (range(0, $this->boardSize - 1) as $row) {
            foreach (range(0, $this->boardSize - 1) as $_) {
                $this->board[$row][] = '';
            }
        }
        return $this->board;
    }

    public function set($board)
    {
        $this->validator->isValid($board);
        $this->board = $board;
    }

    public function getSize()
    {
        return $this->boardSize - 1;
    }

    public function get()
    {
        return $this->board;
    }

    public function setMove($x, $y, $char)
    {
        $this->validator->isMoveValid($this->board, $x, $y, $char);
        $this->board[$y][$x] = $char;
    }


    public function isMoveFree($x, $y)
    {
        if (empty($this->board[$y][$x])) {
            return true;
        }
        return false;
    }

    public function getValue($x, $y)
    {
        return $this->board[$y][$x];
    }
}
