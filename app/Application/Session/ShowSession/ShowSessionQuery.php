<?php

declare(strict_types=1);

namespace App\Application\Session\ShowSession;

final readonly class ShowSessionQuery
{
    public function __construct(
        public string $sessionId
    ) {}
}
