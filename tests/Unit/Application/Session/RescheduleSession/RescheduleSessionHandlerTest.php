<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Session\RescheduleSession;

use App\Application\Session\RescheduleSession\RescheduleSessionCommand;
use App\Application\Session\RescheduleSession\RescheduleSessionHandler;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Exceptions\InvalidSessionStateException;
use App\Domain\Session\Exceptions\SessionNotFoundException;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class RescheduleSessionHandlerTest extends TestCase
{
    public function test_it_reschedules_a_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $session = $this->createSession();

        $repository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($session);

        $repository
            ->expects($this->once())
            ->method('update')
            ->with($session);

        $handler = new RescheduleSessionHandler($repository);

        $handler(
            new RescheduleSessionCommand(
                $session->id()->value(),
                '2030-12-25 17:30'
            )
        );

        $this->assertTrue(
            $session->sessionDate()->equals(
                SessionDate::fromDateTime(
                    new DateTimeImmutable('2030-12-25 17:30')
                )
            )
        );
    }

    public function test_it_throws_when_session_does_not_exist(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $repository
            ->expects($this->once())
            ->method('findById')
            ->willThrowException(
                SessionNotFoundException::fromId(
                    SessionId::generate()
                )
            );

        $repository
            ->expects($this->never())
            ->method('update');

        $handler = new RescheduleSessionHandler($repository);

        $this->expectException(
            SessionNotFoundException::class
        );

        $handler(
            new RescheduleSessionCommand(
                SessionId::generate()->value(),
                '2030-12-25 17:30'
            )
        );
    }

    public function test_it_cannot_reschedule_a_completed_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $session = $this->createSession();

        $session->complete();

        $repository
            ->method('findById')
            ->willReturn($session);

        $repository
            ->expects($this->never())
            ->method('update');

        $handler = new RescheduleSessionHandler($repository);

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'A completed session cannot be rescheduled.'
        );

        $handler(
            new RescheduleSessionCommand(
                $session->id()->value(),
                '2030-12-25 17:30'
            )
        );
    }

    public function test_it_cannot_reschedule_a_cancelled_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $session = $this->createSession();

        $session->cancel();

        $repository
            ->method('findById')
            ->willReturn($session);

        $repository
            ->expects($this->never())
            ->method('update');

        $handler = new RescheduleSessionHandler($repository);

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'A cancelled session cannot be rescheduled.'
        );

        $handler(
            new RescheduleSessionCommand(
                $session->id()->value(),
                '2030-12-25 17:30'
            )
        );
    }

    private function createSession(): Session
    {
        return Session::schedule(
            PatientId::generate(),
            TherapistId::generate(),
            SessionDate::fromDateTime(
                new DateTimeImmutable('tomorrow 10:00')
            )
        );
    }
}
