<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\RabbitMQ;

use App\Application\Ports\Out\EventSerializer;
use App\Application\Ports\Out\RabbitPublisher;
use App\Domain\Session\Events\SessionScheduled;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\TherapistId;
use App\Infrastructure\RabbitMQ\RabbitDomainEventPublisher;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class RabbitDomainEventPublisherTest extends TestCase
{
    public function test_it_serializes_and_publishes_the_event(): void
    {
        $serializer = $this->createMock(EventSerializer::class);
        $publisher = $this->createMock(RabbitPublisher::class);

        $event = new SessionScheduled(
            sessionId: SessionId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            patientId: PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            therapistId: TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            sessionDate: SessionDate::fromDateTime(
                $this->getTomorrowDate()
            ),
            notificationEmail: 'kevinguevara02@gmail.com',
        );

        $serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($event)
            ->willReturn('serialized-event');

        $publisher
            ->expects($this->once())
            ->method('publish')
            ->with(
                'serialized-event',
                'session.scheduled',
            );

        $rabbitPublisher = new RabbitDomainEventPublisher(
            $serializer,
            $publisher,
        );

        $rabbitPublisher->publish($event);
    }

    private function getTomorrowDate(string $time = '10:00', bool $asText = false)
    {
        $date = new DateTimeImmutable("tomorrow $time");

        return ($asText) ? $date->format('Y-m-d H:i') : $date;
    }
}
