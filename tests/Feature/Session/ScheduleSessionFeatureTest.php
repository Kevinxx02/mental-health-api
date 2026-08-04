<?php

declare(strict_types=1);

namespace Tests\Feature\Session;

use App\Application\Ports\Out\DomainEventPublisher;
use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fakes\FakeDomainEventPublisher;
use Tests\TestCase;

final class ScheduleSessionFeatureTest extends TestCase
{
    use RefreshDatabase;

    private FakeDomainEventPublisher $publisher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publisher = new FakeDomainEventPublisher;

        $this->app->instance(
            DomainEventPublisher::class,
            $this->publisher,
        );
    }

    public function test_it_schedules_a_session(): void
    {
        $tomorrow = new DateTimeImmutable('tomorrow 10:00');

        $response = $this->postJson('/api/sessions', [
            'patient_id' => '0197eeb6-39e4-7e77-9e93-0cf7d8680f87',
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => $this->getTomorrowDate(),
            'notification_email' => 'kevinguevara02@gmail.com',
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
            'session_date' => $this->getTomorrowDate(),
            'notification_email' => 'kevinguevara02@gmail.com',
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
            'notification_email' => 'kevinguevara02@gmail.com',
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
            'session_date' => $this->getTomorrowDate(),
            'notification_email' => 'kevinguevara02@gmail.com',
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
            'session_date' => $this->getTomorrowDate('21:30'),
            'notification_email' => 'kevinguevara02@gmail.com',
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
            'session_date' => $this->getTomorrowDate('21:00'),
            'notification_email' => 'kevinguevara02@gmail.com',
        ]);

        $response->assertStatus(201);
    }

    public function test_morning_bottom_business_hours(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => $this->getTomorrowDate('09:00'),
            'notification_email' => 'kevinguevara02@gmail.com',
        ]);

        $response->assertStatus(201);
    }

    public function test_afternoon_bottom_business_hours(): void
    {
        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => $this->getTomorrowDate('17:00'),
            'notification_email' => 'kevinguevara02@gmail.com',
        ]);

        $response->assertStatus(201);
    }

    public function test_morning_top_business_hours(): void
    {
        $tomorrow = (new DateTimeImmutable('tomorrow 13:30'))->format('Y-m-d H:i');

        $response = $this->postJson('/api/sessions', [
            'therapist_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'patient_id' => '0197eeb6-4f53-77c1-9ec5-5b3b0f8af76f',
            'session_date' => $this->getTomorrowDate('13:30'),
            'notification_email' => 'kevinguevara02@gmail.com',
        ]);

        $response->assertStatus(201);
    }

    private function getTomorrowDate(string $time = '10:00')
    {
        return (new DateTimeImmutable("tomorrow $time"))->format('Y-m-d H:i');
    }
}
