<?php declare(strict_types=1);

namespace App\Components;

use App\Components\Point\PointException;

class Chessboard {
    private int $boardSize;
    private array $board = [];
    public function __construct(int $boardSize)
    {
        if ($boardSize < 0) {
            throw new PointException('Board size must be positive');
        }

        $this->board = array_fill(0, $boardSize, array_fill(0, $boardSize, "."));
        $this->boardSize = $boardSize;
    }

    public function getBoard(): array {
        return $this->board;
    }

    public function getBoardSize(): int {
        return $this->boardSize;
    }
}