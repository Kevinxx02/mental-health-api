<?php

declare(strict_types=1);

namespace App\Application\Session\ScheduleSession;

final readonly class ScheduleSessionResponse
{
    public function __construct(public string $sessionId) {}
}
