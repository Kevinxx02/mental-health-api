<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Session\ShowSession;

use App\Application\Ports\Out\SessionRepository;
use App\Application\Session\ShowSession\ShowSessionHandler;
use App\Application\Session\ShowSession\ShowSessionQuery;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Exceptions\SessionNotFoundException;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ShowSessionHandlerTest extends TestCase
{
    public function test_it_returns_a_session(): void
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
            ->with(
                $this->callback(
                    fn (SessionId $id) => $id->equals($session->id())
                )
            )
            ->willReturn($session);

        $handler = new ShowSessionHandler($repository);

        $result = $handler(
            new ShowSessionQuery(
                $session->id()->value()
            )
        );

        $this->assertSame(
            $session,
            $result
        );
    }

    public function test_it_throws_when_session_does_not_exist(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $sessionId = SessionId::generate();

        $repository
            ->expects($this->once())
            ->method('findById')
            ->with(
                $this->callback(
                    fn (SessionId $id) => $id->equals($sessionId)
                )
            )
            ->willThrowException(
                SessionNotFoundException::fromId($sessionId)
            );

        $handler = new ShowSessionHandler($repository);

        $this->expectException(
            SessionNotFoundException::class
        );

        $this->expectExceptionMessage(
            sprintf(
                'Session "%s" was not found.',
                $sessionId->value()
            )
        );

        $handler(
            new ShowSessionQuery(
                $sessionId->value()
            )
        );
    }
}
