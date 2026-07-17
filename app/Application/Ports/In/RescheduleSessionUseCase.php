<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Session\RescheduleSession\RescheduleSessionCommand;

interface RescheduleSessionUseCase
{
    public function __invoke(RescheduleSessionCommand $command): void;
}
