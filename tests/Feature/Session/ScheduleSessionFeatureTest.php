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

    public function test_patient_id_is_required(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 10:00:00',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'patient_id',
            ]);
    }

    public function test_session_date_is_required(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'session_date',
            ]);
    }

    public function test_therapist_id_is_required(): void
    {
        $response = $this->postJson('/api/sessions', [
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 10:00:00',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'therapist_id',
            ]);
    }

    public function test_outside_business_hours(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 21:30:00',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'A session must be scheduled during business hours (09:00-13:30 or 17:00-21:00).',
            ]);
    }

    public function test_afternoon_top_business_hours(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 21:00:00',
        ]);

        $response->assertStatus(201);
    }

    public function test_morning_bottom_business_hours(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 09:00:00',
        ]);

        $response->assertStatus(201);
    }

    public function test_afternoon_bottom_business_hours(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 17:00:00',
        ]);

        $response->assertStatus(201);
    }

    public function test_morning_top_business_hours(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => '2026-08-01 13:30:00',
        ]);

        $response->assertStatus(201);
    }
}
