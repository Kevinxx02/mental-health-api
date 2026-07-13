<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Session\ValueObjects;

use App\Domain\Session\ValueObjects\PatientId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class PatientIdTest extends TestCase
{
    public function test_it_generates_a_valid_uuid_v7(): void
    {
        $patientId = PatientId::generate();

        $this->assertTrue(
            Uuid::isValid($patientId->value())
        );

        $this->assertSame(
            7,
            Uuid::fromString($patientId->value())->getVersion()
        );
    }

    public function test_it_creates_a_patient_id_from_a_valid_string(): void
    {
        $uuid = Uuid::uuid7()->toString();

        $patientId = PatientId::fromString($uuid);

        $this->assertSame(
            $uuid,
            $patientId->value()
        );
    }

    public function test_it_throws_an_exception_when_the_uuid_is_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PatientId::fromString('invalid-uuid');
    }

    public function test_it_considers_two_equal_ids_as_equal(): void
    {
        $uuid = Uuid::uuid7()->toString();

        $first = PatientId::fromString($uuid);
        $second = PatientId::fromString($uuid);

        $this->assertTrue(
            $first->equals($second)
        );
    }

    public function test_it_considers_different_ids_as_different(): void
    {
        $first = PatientId::generate();
        $second = PatientId::generate();

        $this->assertFalse(
            $first->equals($second)
        );
    }

    public function test_it_can_be_cast_to_string(): void
    {
        $patientId = PatientId::generate();

        $this->assertSame(
            $patientId->value(),
            (string) $patientId
        );
    }

    public function test_it_equals_itself(): void
    {
        $patientId = PatientId::generate();

        $this->assertTrue(
            $patientId->equals($patientId)
        );
    }
}
