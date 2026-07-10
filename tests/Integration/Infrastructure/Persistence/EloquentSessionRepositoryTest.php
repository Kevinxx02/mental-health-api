<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use App\Domain\Session\Exceptions\SessionNotFoundException;
use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentSessionRepositoryTest extends TestCase {
    use RefreshDatabase;

    private SessionRepository $repository;

    protected function setUp() : void {
        parent::setUp();

        $this->repository = app(SessionRepository::class);
    }

    public function test_it_saves_a_session() : void {
        $session = Session::schedule(
            PatientId::generate(),
            TherapistId::generate(),
            SessionDate::fromDateTime(
                new DateTimeImmutable('2026-08-01 10:00')
            )
        );

        $this->repository->save($session);

        $this->assertDatabaseHas('sessions', [
            'id' => $session->id()->value(),
            'patient_id' => $session->patientId()->value(),
            'therapist_id' => $session->therapistId()->value(),
            'status' => $session->status()->value,
        ]);
    }

    public function test_it_finds_a_session_by_id() : void {

        $session = Session::schedule(
            PatientId::generate(),
            TherapistId::generate(),
            SessionDate::fromDateTime(
                new DateTimeImmutable('2026-08-01 10:00')
            )
        );

        $this->repository->save($session);

        $found = $this->repository->findById($session->id());

        $this->assertNotNull($found);

        $this->assertTrue(
            $found->id()->equals($session->id())
        );

        $this->assertTrue(
            $found->patientId()->equals($session->patientId())
        );

        $this->assertTrue(
            $found->therapistId()->equals($session->therapistId())
        );

        $this->assertTrue(
            $found->sessionDate()->equals($session->sessionDate())
        );

        $this->assertSame(
            $session->status(),
            $found->status()
        );
    }

    public function test_it_returns_null_when_session_does_not_exist() : void {
        $sessionId = SessionId::generate();

        $this->expectException(SessionNotFoundException::class);

        $this->expectExceptionMessage(
            sprintf(
                'Session "%s" was not found.',
                $sessionId->value()
            )
        );

        $this->repository->findById($sessionId);
    }
}
