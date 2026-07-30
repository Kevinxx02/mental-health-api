<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Session\ScheduleSession;

use App\Application\Ports\Out\DomainEventPublisher;
use App\Application\Ports\Out\SessionRepository;
use App\Application\Session\ScheduleSession\ScheduleSessionCommand;
use App\Application\Session\ScheduleSession\ScheduleSessionHandler;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Events\SessionScheduled;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ScheduleSessionHandlerTest extends TestCase
{
    public function test_it_saves_a_new_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);
        $eventPublisher = $this->createMock(DomainEventPublisher::class);

        $repository
            ->expects($this->once())
            ->method('save');

        $handler = new ScheduleSessionHandler($repository, $eventPublisher);

        $command = new ScheduleSessionCommand(
            patientId: '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            therapistId: '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            sessionDate: '2026-08-01 10:00:00',
        );

        $handler($command);
    }

    public function test_it_creates_a_session_using_command_data(): void
    {
        $capturedSession = null;

        $repository = $this->createMock(SessionRepository::class);
        $eventPublisher = $this->createMock(DomainEventPublisher::class);

        $repository
            ->expects($this->once())
            ->method('save')
            ->willReturnCallback(
                function (Session $session) use (&$capturedSession): void {
                    $capturedSession = $session;
                }
            );

        $handler = new ScheduleSessionHandler($repository, $eventPublisher);

        $command = new ScheduleSessionCommand(
            patientId: '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            therapistId: '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            sessionDate: '2026-08-01 10:00:00',
        );

        $handler($command);

        $this->assertInstanceOf(
            Session::class,
            $capturedSession
        );

        $this->assertSame(
            $command->patientId,
            $capturedSession->patientId()->value()
        );

        $this->assertSame(
            $command->therapistId,
            $capturedSession->therapistId()->value()
        );

        $this->assertSame(
            $command->sessionDate,
            $capturedSession
                ->sessionDate()
                ->value()
                ->format('Y-m-d H:i:s')
        );
    }

    public function test_it_propagates_repository_exceptions(): void
    {
        $repository = $this->createMock(SessionRepository::class);
        $eventPublisher = $this->createMock(DomainEventPublisher::class);

        $repository
            ->method('save')
            ->willThrowException(
                new \RuntimeException('Repository failure.')
            );

        $handler = new ScheduleSessionHandler($repository, $eventPublisher);

        $command = new ScheduleSessionCommand(
            patientId: '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            therapistId: '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            sessionDate: '2026-08-01 10:00:00',
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Repository failure.');

        $handler($command);
    }

    public function test_it_publishes_notification(): void
    {
        $repository = $this->createMock(SessionRepository::class);
        $eventPublisher = $this->createMock(DomainEventPublisher::class);

        $eventPublisher
            ->expects($this->once())
            ->method('publish');

        $handler = new ScheduleSessionHandler($repository, $eventPublisher);

        $command = new ScheduleSessionCommand(
            patientId: '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            therapistId: '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            sessionDate: '2026-08-01 10:00:00',
        );

        $handler($command);
    }

    public function test_it_returns_the_expected_payload(): void
    {
        $event = new SessionScheduled(
            sessionId: SessionId::fromString('11111111-1111-1111-1111-111111111111'),
            patientId: PatientId::fromString('22222222-2222-2222-2222-222222222222'),
            therapistId: TherapistId::fromString('33333333-3333-3333-3333-333333333333'),
            sessionDate: SessionDate::fromDateTime(
                new DateTimeImmutable('2026-08-01 10:00:00')
            ),
        );

        $this->assertSame(
            [
                'sessionId' => '11111111-1111-1111-1111-111111111111',
                'patientId' => '22222222-2222-2222-2222-222222222222',
                'therapistId' => '33333333-3333-3333-3333-333333333333',
                'sessionDate' => '2026-08-01T10:00:00+00:00',
            ],
            $event->payload(),
        );
    }
}
