<?php

declare(strict_types=1);

namespace App\Application\Session\RescheduleSession;

final readonly class RescheduleSessionCommand
{
    public function __construct(
        public string $sessionId,
        public string $sessionDate
    ) {}
}
