<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Session\ListSessions;

use App\Application\Ports\Out\SessionRepository;
use App\Application\Session\ListSessions\ListSessionsHandler;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ListSessionsHandlerTest extends TestCase
{
    public function test_it_returns_all_sessions(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $sessions = [
            $this->createSession(),
            $this->createSession(),
            $this->createSession(),
        ];

        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($sessions);

        $handler = new ListSessionsHandler($repository);

        $result = $handler();

        $this->assertSame(
            $sessions,
            $result
        );
    }

    public function test_it_returns_an_empty_array_when_there_are_no_sessions(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $handler = new ListSessionsHandler($repository);

        $this->assertSame(
            [],
            $handler()
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
