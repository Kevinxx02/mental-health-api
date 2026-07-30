<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use App\Application\Ports\Out\DomainEventPublisher;
use App\Application\Ports\Out\EventSerializer;
use App\Application\Ports\Out\RabbitPublisher;
use App\Domain\Shared\Events\DomainEvent;

final readonly class RabbitDomainEventPublisher implements DomainEventPublisher
{
    public function __construct(
        private EventSerializer $serializer,
        private RabbitPublisher $publisher,
    ) {}

    public function publish(DomainEvent $event): void
    {
        $payload = $this->serializer->serialize($event);

        $this->publisher->publish(
            $payload,
            $event->eventName(),
        );
    }
}
