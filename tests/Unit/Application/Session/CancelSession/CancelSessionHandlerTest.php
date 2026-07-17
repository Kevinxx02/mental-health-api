<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Session\CancelSession;

use App\Application\Ports\Out\SessionRepository;
use App\Application\Session\CancelSession\CancelSessionCommand;
use App\Application\Session\CancelSession\CancelSessionHandler;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Exceptions\InvalidSessionStateException;
use App\Domain\Session\Exceptions\SessionNotFoundException;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\SessionStatus;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class CancelSessionHandlerTest extends TestCase
{
    public function test_it_cancels_a_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $session = Session::schedule(
            PatientId::generate(),
            TherapistId::generate(),
            SessionDate::fromDateTime(
                new DateTimeImmutable('tomorrow 10:00')
            )
        );

        $repository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($session);

        $repository
            ->expects($this->once())
            ->method('update')
            ->with($session);

        $handler = new CancelSessionHandler($repository);

        $handler(
            new CancelSessionCommand(
                $session->id()->value()
            )
        );

        $this->assertSame(
            SessionStatus::Cancelled,
            $session->status()
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
            ->method('save');

        $handler = new CancelSessionHandler($repository);

        $this->expectException(
            SessionNotFoundException::class
        );

        $handler(
            new CancelSessionCommand(
                SessionId::generate()->value()
            )
        );
    }

    public function test_it_cannot_cancel_a_completed_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $session = Session::schedule(
            PatientId::generate(),
            TherapistId::generate(),
            SessionDate::fromDateTime(
                new DateTimeImmutable('tomorrow 10:00')
            )
        );

        $session->complete();

        $repository
            ->method('findById')
            ->willReturn($session);

        $repository
            ->expects($this->never())
            ->method('update');

        $handler = new CancelSessionHandler($repository);

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'A completed session cannot be cancelled.'
        );

        $handler(
            new CancelSessionCommand(
                $session->id()->value()
            )
        );
    }

    public function test_it_cannot_cancel_an_already_cancelled_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $session = Session::schedule(
            PatientId::generate(),
            TherapistId::generate(),
            SessionDate::fromDateTime(
                new DateTimeImmutable('tomorrow 10:00')
            )
        );

        $session->cancel();

        $repository
            ->method('findById')
            ->willReturn($session);

        $repository
            ->expects($this->never())
            ->method('update');

        $handler = new CancelSessionHandler($repository);

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'The session has already been cancelled.'
        );

        $handler(
            new CancelSessionCommand(
                $session->id()->value()
            )
        );
    }
}
