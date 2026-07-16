<?php

declare(strict_types=1);

namespace Tests\Feature\Session;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ScheduleSessionFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_schedules_a_session(): void
    {
        $response = $this->postJson('/api/sessions', [
            'patient_id' => '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 10:00:00',
        ]);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'session_id',
            ]);

        $this->assertDatabaseCount('sessions', 1);

        $this->assertDatabaseHas('sessions', [
            'patient_id' => '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
        ]);
    }
}
