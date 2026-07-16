<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Application\Session\ScheduleSession\ScheduleSessionCommand;
use App\Application\Session\ScheduleSession\ScheduleSessionResponse;

interface ScheduleSessionUseCase
{
    public function __invoke(
        ScheduleSessionCommand $command
    ): ScheduleSessionResponse;
}
