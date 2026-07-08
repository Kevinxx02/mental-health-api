<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Session\Entities;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\Exceptions\InvalidSessionStateException;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\SessionStatus;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class SessionTest extends TestCase {
    public function test_it_schedules_a_new_session(): void {
        $session = $this->createSession();

        $this->assertInstanceOf(
            SessionId::class,
            $session->id()
        );

        $this->assertInstanceOf(
            PatientId::class,
            $session->patientId()
        );

        $this->assertInstanceOf(
            TherapistId::class,
            $session->therapistId()
        );

        $this->assertInstanceOf(
            SessionDate::class,
            $session->sessionDate()
        );

        $this->assertSame(
            SessionStatus::Scheduled,
            $session->status()
        );
    }

    public function test_it_completes_a_scheduled_session(): void {
        $session = $this->createSession();

        $session->complete();

        $this->assertSame(
            SessionStatus::Completed,
            $session->status()
        );
    }

    public function test_it_cannot_complete_an_already_completed_session(): void {
        $session = $this->createSession();

        $session->complete();

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'The session has already been completed.'
        );

        $session->complete();
    }

    public function test_it_cannot_complete_a_cancelled_session(): void {
        $session = $this->createSession();

        $session->cancel();

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'A cancelled session cannot be completed.'
        );

        $session->complete();
    }

    public function test_it_cancels_a_scheduled_session(): void {
        $session = $this->createSession();

        $session->cancel();

        $this->assertSame(
            SessionStatus::Cancelled,
            $session->status()
        );
    }

    public function test_it_cannot_cancel_an_already_cancelled_session(): void {
        $session = $this->createSession();

        $session->cancel();

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'The session has already been cancelled.'
        );

        $session->cancel();
    }

    public function test_it_cannot_cancel_a_completed_session(): void {
        $session = $this->createSession();

        $session->complete();

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'A completed session cannot be cancelled.'
        );

        $session->cancel();
    }

    public function test_it_reschedules_a_scheduled_session(): void {
        $session = $this->createSession();

        $newDate = SessionDate::fromDateTime(
            new DateTimeImmutable('tomorrow 10:00')
        );

        $session->reschedule($newDate);

        $this->assertTrue(
            $session->sessionDate()->equals($newDate)
        );
    }

    public function test_it_cannot_reschedule_a_completed_session(): void {
        $session = $this->createSession();

        $session->complete();

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'A completed session cannot be rescheduled.'
        );

        $session->reschedule(
            SessionDate::fromDateTime(
                new DateTimeImmutable('tomorrow 10:00')
            )
        );
    }

    public function test_it_cannot_reschedule_a_cancelled_session(): void {
        $session = $this->createSession();

        $session->cancel();

        $this->expectException(
            InvalidSessionStateException::class
        );

        $this->expectExceptionMessage(
            'A cancelled session cannot be rescheduled.'
        );

        $session->reschedule(
            SessionDate::fromDateTime(
                new DateTimeImmutable('tomorrow 10:00')
            )
        );
    }

    private function createSession(): Session {
        return Session::schedule(
            PatientId::generate(),
            TherapistId::generate(),
            SessionDate::fromDateTime(
                new DateTimeImmutable('tomorrow 09:00')
            )
        );
    }
}
