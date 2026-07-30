<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Serialization;

use App\Domain\Session\Events\SessionScheduled;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\TherapistId;
use App\Infrastructure\Serialization\JsonEventSerializer;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class JsonEventSerializerTest extends TestCase
{
    public function test_it_serializes_a_domain_event(): void
    {
        $serializer = new JsonEventSerializer;

        $event = new SessionScheduled(
            sessionId: SessionId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            patientId: PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            therapistId: TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            sessionDate: SessionDate::fromDateTime(
                new \DateTimeImmutable('2026-08-01 10:00:00')
            ),
        );

        $json = $serializer->serialize($event);

        $this->assertJson($json);

        $data = json_decode($json, true, flags: JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('eventId', $data);

        $this->assertSame(
            'session.scheduled',
            $data['eventType'],
        );

        $this->assertSame(
            $event->occurredOn()->format(\DateTimeInterface::ATOM),
            $data['occurredOn'],
        );
        $this->assertCount(4, $data['payload']);
        $this->assertSame(
            [
                'sessionId' => '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
                'patientId' => '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
                'therapistId' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
                'sessionDate' => '2026-08-01T10:00:00+00:00',
            ],
            $data['payload'],
        );

        $this->assertTrue(
            Uuid::isValid($data['eventId']),
        );
    }
}
