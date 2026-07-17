<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Session\CancelSession\CancelSessionCommand;

interface CancelSessionUseCase
{
    public function __invoke(CancelSessionCommand $command): void;
}
