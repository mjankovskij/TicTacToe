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
                if ($board->get()[$y][$x] !== '' && $lastValue === $board->get()[$y][$x]) {
                    $sameCount++;
                } else {
                    $sameCount = 0;
                    $lastValue = $board->get()[$y][$x];
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
            if ($board->get()[$xy][$xy] !== '' && $lastValue === $board->get()[$xy][$xy]) {
                $sameCount++;
            } else {
                $sameCount = 0;
                $lastValue = $board->get()[$xy][$xy];
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
            if ($board->get()[$xy][$board->getSize() - $xy] !== '' && $lastValue === $board->get()[$xy][$board->getSize() - $xy]) {
                $sameCount++;
            } else {
                $sameCount = 0;
                $lastValue = $board->get()[$xy][$board->getSize() - $xy];
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
