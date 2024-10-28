<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Components\Chessboard;
use App\Components\ChessboardWaysFinder;
use App\Components\Point\Point;

$cheesboardwaysfinder = new ChessboardWaysFinder((new Chessboard(10))->getBoard());
$cheesboardwaysfinder->animateGettingWaysFromPoint(new Point(2,2), 0);