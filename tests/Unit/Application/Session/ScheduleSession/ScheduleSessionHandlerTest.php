<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Session\ScheduleSession;

use App\Application\Session\ScheduleSession\ScheduleSessionCommand;
use App\Application\Session\ScheduleSession\ScheduleSessionHandler;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;
use PHPUnit\Framework\TestCase;

final class ScheduleSessionHandlerTest extends TestCase
{
    public function test_it_saves_a_new_session(): void
    {
        $repository = $this->createMock(SessionRepository::class);

        $repository
            ->expects($this->once())
            ->method('save');

        $handler = new ScheduleSessionHandler($repository);

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

        $repository
            ->expects($this->once())
            ->method('save')
            ->willReturnCallback(
                function (Session $session) use (&$capturedSession): void {
                    $capturedSession = $session;
                }
            );

        $handler = new ScheduleSessionHandler($repository);

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

        $repository
            ->method('save')
            ->willThrowException(
                new \RuntimeException('Repository failure.')
            );

        $handler = new ScheduleSessionHandler($repository);

        $command = new ScheduleSessionCommand(
            patientId: '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            therapistId: '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            sessionDate: '2026-08-01 10:00:00',
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Repository failure.');

        $handler($command);
    }
}
