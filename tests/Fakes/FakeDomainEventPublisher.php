<?php

declare(strict_types=1);

namespace Tests\Fakes;

use App\Application\Ports\Out\DomainEventPublisher;
use App\Domain\Shared\Events\DomainEvent;

final class FakeDomainEventPublisher implements DomainEventPublisher
{
    /**
     * @var DomainEvent[]
     */
    public array $events = [];

    public function publish(DomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
