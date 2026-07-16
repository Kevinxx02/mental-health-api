<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Session\ShowSession\ShowSessionQuery;
use App\Domain\Session\Entities\Session;

interface ShowSessionUseCase
{
    public function __invoke(ShowSessionQuery $query): Session;
}
