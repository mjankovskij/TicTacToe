<?php

namespace App\Util;

use App\Util\Validator\BoardValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

class Game
{

    public function isGameEnded($board)
    {
        // // Horizontal row check.
        foreach ($board->get() as $y) {
            $lastValue = '';
            $sameCount = 0;
            foreach ($y as $x) {
                if ($x !== '' && $lastValue === $x) {
                    $sameCount++;
                } else {
                    $sameCount = 0;
                    $lastValue = $x;
                }
                if ($sameCount === $board->getSize()) {
                    if ($lastValue === 'X') {
                        return 'You won.';
                    } else {
                        return 'You lost.';
                    }
                }
            }
        }

        // // // Vertical row check.
        foreach ($board->get() as $x => $_) {
            $lastValue = '';
            $sameCount = 0;
            foreach ($board->get() as $y => $_) {
                if (!$board->isMoveFree($x, $y) && $lastValue === $board->getValue($x, $y)) {
                    $sameCount++;
                } else {
                    $sameCount = 0;
                    $lastValue = $board->getValue($x, $y);
                }
                if ($sameCount === $board->getSize()) {
                    if ($lastValue === 'X') {
                        return 'You won.';
                    } else {
                        return 'You lost.';
                    }
                }
            }
        }

        // // Diagonal top left to bottom right.
        $lastValue = '';
        $sameCount = 0;
        foreach ($board->get() as $xy => $_) {
            if (!$board->isMoveFree($xy, $xy) && $lastValue === $board->getValue($xy, $xy)) {
                $sameCount++;
            } else {
                $sameCount = 0;
                $lastValue = $board->getValue($xy, $xy);
            }
            if ($sameCount === $board->getSize()) {
                if ($lastValue === 'X') {
                    return 'You won.';
                } else {
                    return 'You lost.';
                }
            }
        }

        // // Diagonal bottom left to top right.
        $lastValue = '';
        $sameCount = 0;
        foreach ($board->get() as $xy => $_) {
            if (!$board->isMoveFree($board->getSize() - $xy,$xy) && $lastValue === $board->getValue($board->getSize() - $xy, $xy)) {
                $sameCount++;
            } else {
                $sameCount = 0;
                $lastValue = $board->getValue($board->getSize() - $xy, $xy);
            }
            if ($sameCount === $board->getSize()) {
                if ($lastValue === 'X') {
                    return 'You won.';
                } else {
                    return 'You lost.';
                }
            }
        }

        // // Draw.
        $totalCount = ($board->getSize() + 1) ** 2;
        foreach ($board->get() as $y) {
            foreach ($y as $x) {
                if ($x !== '') $totalCount--;
            }
        }
        if ($totalCount <= 1) return 'Draw.';

        return false;
    }
}
