<?php

declare(strict_types=1);

namespace Tests\Feature\Session;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ListSessionFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_sessions(): void
    {
        /** @var SessionRepository $repository */
        $repository = app(SessionRepository::class);

        $session1 = Session::schedule(
            PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            SessionDate::fromDateTime(
                new \DateTimeImmutable('2026-08-01 10:00:00')
            )
        );

        $session2 = Session::schedule(
            PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f88'),
            TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            SessionDate::fromDateTime(
                new \DateTimeImmutable('2026-08-01 11:00:00')
            )
        );

        $repository->save($session1);
        $repository->save($session2);

        $response = $this->getJson('/api/sessions');

        $response
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.id', $session1->id()->value())
            ->assertJsonPath('data.1.id', $session2->id()->value());
    }

    public function test_it_returns_empty_list(): void
    {
        $this->getJson('/api/sessions')
            ->assertOk()
            ->assertExactJson([
                'data' => [],
            ]);
    }
}
