<?php declare(strict_types=1);

namespace App\Components\Point;

class PointException extends \Exception {
    public function __construct(?string $message = null, ?int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(($message ? $message : 'Point must be positive'), $code, $previous);
    }
}