<?php

declare(strict_types=1);

namespace Tests\Feature\Session;

use App\Application\Ports\Out\SessionRepository;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RescheduleSessionFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reschedules_a_session(): void
    {
        /** @var SessionRepository $repository */
        $repository = app(SessionRepository::class);

        $session = Session::schedule(
            PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            SessionDate::fromDateTime(
                $this->getTomorrowDate()
            )
        );

        $repository->save($session);

        $response = $this->patchJson(
            "/api/sessions/{$session->id()->value()}/reschedule",
            [
                'session_date' => $this->getTomorrowDate('18:00', true),
            ]
        );

        $response->assertStatus(204);

        $this->assertDatabaseHas('sessions', [
            'id' => $session->id()->value(),
            'session_date' => $this->getTomorrowDate('18:00'),
        ]);
    }

    public function test_it_returns_404_when_session_does_not_exist(): void
    {
        $this->patchJson(
            '/api/sessions/0197eeb6-39e4-7e77-9e93-0cf7d8680f87/reschedule',
            [
                'session_date' => $this->getTomorrowDate('18:00', true),
            ]
        )->assertNotFound();
    }

    public function test_it_returns_422_for_invalid_business_hours(): void
    {
        /** @var SessionRepository $repository */
        $repository = app(SessionRepository::class);

        $session = Session::schedule(
            PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            SessionDate::fromDateTime(
                $this->getTomorrowDate()
            )
        );

        $repository->save($session);

        $this->patchJson(
            "/api/sessions/{$session->id()->value()}/reschedule",
            [
                'session_date' => $this->getTomorrowDate('22:00', true),
            ]
        )
            ->assertStatus(422)
            ->assertJsonPath(
                'message',
                'A session must be scheduled during business hours (09:00-13:30 or 17:00-21:00).'
            );
    }

    public function test_session_date_is_required(): void
    {
        /** @var SessionRepository $repository */
        $repository = app(SessionRepository::class);

        $session = Session::schedule(
            PatientId::fromString('0197eeb6-39e4-7e77-9e93-0cf7d8680f87'),
            TherapistId::fromString('0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f'),
            SessionDate::fromDateTime(
                $this->getTomorrowDate()
            )
        );

        $repository->save($session);

        $response = $this->patchJson("/api/sessions/{$session->id()->value()}/reschedule", [
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'session_date',
            ]);
    }

    private function getTomorrowDate(string $time = '10:00', bool $asText = false)
    {
        $date = new DateTimeImmutable("tomorrow $time");

        return ($asText) ? $date->format('Y-m-d H:i') : $date;
    }
}
