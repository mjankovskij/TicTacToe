<?php

namespace App\Util\Validator;

use App\Util\Board;
use Exception;

class BoardValidator
{
    public function isValid($board)
    {
        if (empty($board)) {
            throw new Exception('Board cannot be empty.');
        }
        foreach ($board as $row) {
            if (count($row) !== count($board)) {
                throw new Exception('The board measurements are incorrect.');
            }
        }
        if (count($board) < 3) {
            throw new Exception('The board is too small.');
        }
        return true;
    }

    public function isMoveValid($board, $x, $y, $char)
    {
        if (!is_int($x) || !is_int($y)) {
            throw new Exception('Coordinates must be integers.');
        }
        if($char!=='X' && $char !=='O'){
            throw new Exception('Only X and O players are available.');
        }
        $boardSize = (new Board)->getSize();

        if ($x < 0
            || $x > $boardSize
            || $y < 0
            || $y > $boardSize ||
            $board[$y][$x] !== ''
        ) {
            throw new Exception('Invalid field selected.');
        }
        return true;
    }
}
