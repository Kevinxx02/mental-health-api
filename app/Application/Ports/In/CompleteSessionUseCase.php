<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Session\CompleteSession\CompleteSessionCommand;

interface CompleteSessionUseCase
{
    public function __invoke(CompleteSessionCommand $command): void;
}
