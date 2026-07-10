<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Session\CompleteSession;

use App\Application\Session\CompleteSession\CompleteSessionCommand;
use App\Application\Session\CompleteSession\CompleteSessionHandler;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Exceptions\SessionNotFoundException;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\SessionStatus;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class CompleteSessionHandlerTest extends TestCase {
    public function test_it_completes_a_session() : void {
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

        $handler = new CompleteSessionHandler($repository);

        $handler(
            new CompleteSessionCommand(
                $session->id()->value()
            )
        );

        $this->assertSame(
            SessionStatus::Completed,
            $session->status()
        );
    }

    public function test_it_throws_when_session_does_not_exist() : void {
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

        $handler = new CompleteSessionHandler($repository);

        $this->expectException(SessionNotFoundException::class);

        $handler(
            new CompleteSessionCommand(
                SessionId::generate()->value()
            )
        );
    }
}
