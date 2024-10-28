<?php declare(strict_types=1);

namespace App\Components\Point;

class Point {
    private int $x;
    private int $y;
    public function __construct(int $x, int $y) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Set the point.
     *
     * @param int $x The x coordinate
     * @param int $y The y coordinate
     *
     * @throws \Exception If the point is negative
     *
     * @return void
     */
    public function setPoint(int $x, int $y) {
        if ($x < 0 || $y < 0) {
            throw new PointException('Point must be positive');
        }

        $this->x = $x;
        $this->y = $y;
    }


    /**
     * Get the current point.
     *
     * @return array The current point as an array where the first element is the x coordinate and the second element is the y coordinate.
     */
    public function getPoints(): array {
        return [$this->x, $this->y];
    }

    public function getX(): int {
        return $this->x;
    }

    public function getY(): int {
        return $this->y;
    }
}