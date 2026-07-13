<?php

declare(strict_types=1);

namespace App\Application\Session\CancelSession;

final readonly class CancelSessionCommand
{
    public function __construct(public string $sessionId) {}
}
