<?php

declare(strict_types=1);

namespace Tests\Feature\Session;

use App\Application\Ports\Out\SessionRepository;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ShowSessionFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_session(): void
    {
        /** @var SessionRepository $repository */
        $repository = app(SessionRepository::class);

        $session = Session::schedule(
            PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            SessionDate::fromDateTime(
                new \DateTimeImmutable('2026-08-01 10:00:00')
            )
        );

        $repository->save($session);

        $response = $this->getJson(
            "/api/sessions/{$session->id()->value()}"
        );

        $date = $session->sessionDate()->value()->format(DateTimeInterface::ATOM);

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $session->id()->value(),
                    'patient_id' => $session->patientId()->value(),
                    'therapist_id' => $session->therapistId()->value(),
                    'status' => $session->status()->value(),
                    'session_date' => $date,
                ],
            ]);
    }

    public function test_it_returns_404_when_session_does_not_exist(): void
    {
        $response = $this->getJson(
            '/api/sessions/0197eeb6-39e4-7e77-9e93-0cf7d8680f87'
        );

        $response->assertNotFound();
    }
}
