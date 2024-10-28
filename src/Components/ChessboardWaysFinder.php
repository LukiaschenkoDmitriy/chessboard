<?php declare(strict_types=1);

namespace App\Components;

use App\Components\Point\Point;
use App\Components\Point\PointException;
use Exception;

class ChessboardWaysFinder {
    private array $board;
    private int $boardSize;
    private int $allIteration = 0;
    private array $availableMoves = [
        [-1, -1], // left-top
        [-1, 0],  // top
        [-1, 1],  // right-top
        [0, -1],  // left
        [0, 1],   // right
        [1, -1],  // left-bottom
        [1, 0],   // bottom
        [1, 1],   // right-bottom
    ];
    public function __construct(array $board) {
        $this->board = $board;
        $this->boardSize = count($board);
    }

    public function getAllWaysFromPoint(Point $point, array $history = [], int $iteration = 0, ?callable $callback = null, int $sleep = 500000): array {
        if ($iteration == 0) {
            $this->allIteration = 0;
            $history = [];
        }

        foreach ($this->availableMoves as $key => $move) {
            $this->clearBoard();

            try { $newPoint = new Point($point->getX() + $move[0], $point->getY() + $move[1]); } 
            catch (PointException $e) { continue; }

            if (in_array($newPoint->getPoints(), $history) || ($this->moveIsValid($newPoint))) {
                continue;
            };

            $history[$iteration] = $newPoint->getPoints();

            if ($callback) {
                $callback($history, $sleep);
                $this->allIteration++;
            }

            $this->getAllWaysFromPoint($newPoint, $history, $iteration + 1, $callback, $sleep);
        }

        return $history;
    }

    function animateGettingWaysFromPoint(Point $point, int $sleep = 500000) {
        $this->getAllWaysFromPoint($point, callback: function(array $history, int $sleep) {
            try {
                system('clear');
            } catch (Exception $e) {
                try {
                    system('cls');
                } catch (Exception $e) { }
            }
            
            $movesBoard = $this->convertMovesToBoard($history);
            $output = $this->printBoard($movesBoard);
            echo($output);
            echo("Steps: {$this->allIteration}\n");
            usleep($sleep);
        }, sleep: $sleep);
    }

    function convertMovesToBoard(array $moves): array {
        foreach ($moves as $index => $move) {
            $x = $move[0];
            $y = $move[1];
            $this->board[$x][$y] = $index;
        }
        
        return $this->board;
    }

    public function moveIsValid(Point $point): bool {
        return ($point->getX() < 0 || $point->getX() >= $this->boardSize || $point->getY() < 0 || $point->getY() >= $this->boardSize);
    }

    public function clearBoard() {
        $this->board = array_fill(0, $this->boardSize, array_fill(0, $this->boardSize, '.'));
    }

    public function printBoard(array $board): string {
        $result = "";
        
        $columnWidths = [];
        foreach ($board as $row) {
            foreach ($row as $cell) {
                $columnWidths[] = strlen((string)$cell);
            }
        }
        $maxColumnWidths = array_map('max', array_map(null, ...array_chunk($columnWidths, count($board[0]))));
    
        foreach ($board as $row) {
            $result .= "+";
            foreach ($maxColumnWidths as $width) {
                $result .= str_repeat("-", $width + 2) . "+";
            }
            $result .= "\n|";
            foreach ($row as $index => $cell) {
                $result .= " " . str_pad(($cell === '.' ? ' ' : (string)$cell), $maxColumnWidths[$index]) . " |";
            }
            $result .= "\n";
        }

        $result .= "+";
        foreach ($maxColumnWidths as $width) {
            $result .= str_repeat("-", $width + 2) . "+";
        }
        $result .= "\n";
    
        return $result;
    }
    
}