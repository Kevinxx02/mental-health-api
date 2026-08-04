<?php

declare(strict_types=1);

namespace App\Infrastructure\Serialization;

use App\Application\Ports\Out\EventSerializer;
use App\Domain\Shared\Events\DomainEvent;
use DateTimeInterface;
use JsonException;
use Ramsey\Uuid\Uuid;

final class JsonEventSerializer implements EventSerializer
{
    /**
     * @throws JsonException
     */
    public function serialize(DomainEvent $event): string
    {
        return json_encode(
            [
                'eventId' => Uuid::uuid7()->toString(),
                'eventType' => $event->eventName(),
                'occurredOn' => $event
                    ->occurredOn()
                    ->format(DateTimeInterface::ATOM),
                'notificationEmail' => $event->notificationEmail(),
                'payload' => $event->payload(),
            ],
            JSON_THROW_ON_ERROR,
        );
    }
}
