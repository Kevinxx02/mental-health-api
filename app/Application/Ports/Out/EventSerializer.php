<?php

declare(strict_types=1);

namespace App\Application\Ports\Out;

use App\Domain\Shared\Events\DomainEvent;

interface EventSerializer
{
    public function serialize(
        DomainEvent $event,
    ): string;
}
