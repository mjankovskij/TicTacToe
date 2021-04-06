<?php

namespace App\Util;

class CPU
{
    public function getMove($board, $level, $attempt = 0)
    {
        $moveX = rand(0, $board->getSize());
        $moveY = rand(0, $board->getSize());

        if ($attempt < 20 && $level) {
            // CHECK IF IT IS POSSIBLE TO LOSE
            // Row
            foreach ($board->get() as $y => $rows) {
                $count = 0;
                foreach ($rows as $x) {
                    if ($x === 'X') $count++;
                    if ($count === $board->getSize() && count(array_filter($rows)) === $board->getSize()) $moveY = $y;
                }
            }

            // Column
            foreach ($board->get() as $x => $_) {
                $usedCount = 0;
                $count = 0;
                foreach ($board->get() as $y => $_) {
                    if ($board->getValue($x, $y) !== '') $usedCount++;
                    if ($board->getValue($x, $y) === 'X') $count++;
                }
                if ($count === $board->getSize() && $usedCount === $board->getSize()) $moveX = $x;
            }

            // Diagonal top left to bottom right
            $usedCount = 0;
            $count = 0;
            foreach ($board->get() as $xy => $_) {
                if ($board->getValue($xy, $xy) !== '') $usedCount++;
                if ($board->getValue($xy, $xy) === 'X') $count++;
            }
            if ($count === $board->getSize() && $usedCount === $board->getSize()) {
                foreach ($board->get() as $xy => $_) {
                    if ($board->getValue($xy, $xy) === '') {
                        $moveX = $xy;
                        $moveY = $xy;
                    }
                }
            }

            // Diagonal bottom left to top right
            $usedCount = 0;
            $count = 0;
            foreach ($board->get() as $xy => $_) {
                if ($board->getValue($xy, $board->getSize() - $xy) !== '') $usedCount++;
                if ($board->getValue($xy, $board->getSize() - $xy) === 'X') $count++;
            }
            if ($count === $board->getSize() && $usedCount === $board->getSize()) {
                foreach ($board->get() as $xy => $_) {
                    if ($board->getValue($board->getSize() - $xy, $xy) === '') {
                        $moveX = $board->getSize() - $xy;
                        $moveY = $xy;
                    }
                }
            }

            // CHECK IF IT IS POSSIBLE TO WIN
            // Row
            foreach ($board->get() as $y => $rows) {
                $count = 0;
                foreach ($rows as $x) {
                    if ($x === 'O') $count++;
                    if ($count === $board->getSize() && count(array_filter($rows)) === $board->getSize()) $moveY = $y;
                }
            }

            // Column
            foreach ($board->get() as $x => $_) {
                $usedCount = 0;
                $count = 0;
                foreach ($board->get() as $y => $_) {
                    if ($board->getValue($x, $y) !== '') $usedCount++;
                    if ($board->getValue($x, $y) === 'O') $count++;
                }
                if ($count === $board->getSize() && $usedCount === $board->getSize()) $moveX = $x;
            }

            // Diagonal top left to bottom right
            $usedCount = 0;
            $count = 0;
            foreach ($board->get() as $xy => $_) {
                if ($board->getValue($xy, $xy) !== '') $usedCount++;
                if ($board->getValue($xy, $xy) === 'O') $count++;
            }
            if ($count === $board->getSize() && $usedCount === $board->getSize()) {
                foreach ($board->get() as $xy => $_) {
                    if ($board->getValue($xy, $xy) === '') {
                        $moveX = $xy;
                        $moveY = $xy;
                    }
                }
            }

            // Diagonal bottom left to top right
            $usedCount = 0;
            $count = 0;
            foreach ($board->get() as $xy => $_) {
                if ($board->getValue($xy, $board->getSize() - $xy) !== '') $usedCount++;
                if ($board->getValue($xy, $board->getSize() - $xy) === 'O') $count++;
            }
            if ($count === $board->getSize() && $usedCount === $board->getSize()) {
                foreach ($board->get() as $xy => $_) {
                    if ($board->getValue($board->getSize() - $xy, $xy) === '') {
                        $moveX = $board->getSize() - $xy;
                        $moveY = $xy;
                    }
                }
            }

            if ($board->getValue(intval($board->getSize()/2), intval($board->getSize()/2)) === '') {
                $moveX = $moveY = intval($board->getSize()/2);
            }
        }



        if ($board->isMoveFree($moveX, $moveY)) {
            return [$moveX, $moveY];
        } else {
            return $this->getMove($board, $level, ++$attempt);
        }
    }
}
