<?php

declare(strict_types=1);

namespace App\Application\Session\ScheduleSession;

final readonly class ScheduleSessionCommand {
    public function __construct(
        public string $patientId,
        public string $therapistId,
        public string $sessionDate
    ) {}
}
