<?php

declare(strict_types=1);

namespace Tests\Feature\Session;

use App\Application\Ports\Out\SessionRepository;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CompleteSessionFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_completes_a_session(): void
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

        $response = $this->patchJson(
            "/api/sessions/{$session->id()->value()}/complete"
        );

        $response->assertStatus(204);

        $this->assertDatabaseHas('sessions', [
            'id' => $session->id()->value(),
            'status' => 'completed',
        ]);
    }

    public function test_it_returns_404_when_session_does_not_exist(): void
    {
        $response = $this->patchJson(
            '/api/sessions/0197eeb6-39e4-7e77-9e93-0cf7d8680f87/complete'
        );

        $response->assertNotFound();
    }
}
