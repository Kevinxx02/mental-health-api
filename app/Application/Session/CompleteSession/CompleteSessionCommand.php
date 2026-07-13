<?php

declare(strict_types=1);

namespace App\Application\Session\CompleteSession;

final readonly class CompleteSessionCommand
{
    public function __construct(public string $sessionId) {}
}
