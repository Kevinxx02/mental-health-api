<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Session\ValueObjects;

use App\Domain\Session\ValueObjects\TherapistId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class TherapistIdTest extends TestCase
{
    public function test_it_generates_a_valid_uuid_v7(): void
    {
        $therapistId = TherapistId::generate();

        $this->assertTrue(
            Uuid::isValid($therapistId->value())
        );

        $this->assertSame(
            7,
            Uuid::fromString($therapistId->value())->getVersion()
        );
    }

    public function test_it_creates_a_therapist_id_from_a_valid_string(): void
    {
        $uuid = Uuid::uuid7()->toString();

        $therapistId = TherapistId::fromString($uuid);

        $this->assertSame(
            $uuid,
            $therapistId->value()
        );
    }

    public function test_it_throws_an_exception_when_the_uuid_is_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        TherapistId::fromString('invalid-uuid');
    }

    public function test_it_considers_two_equal_ids_as_equal(): void
    {
        $uuid = Uuid::uuid7()->toString();

        $first = TherapistId::fromString($uuid);
        $second = TherapistId::fromString($uuid);

        $this->assertTrue(
            $first->equals($second)
        );
    }

    public function test_it_considers_different_ids_as_different(): void
    {
        $first = TherapistId::generate();
        $second = TherapistId::generate();

        $this->assertFalse(
            $first->equals($second)
        );
    }

    public function test_it_can_be_cast_to_string(): void
    {
        $therapistId = TherapistId::generate();

        $this->assertSame(
            $therapistId->value(),
            (string) $therapistId
        );
    }

    public function test_it_equals_itself(): void
    {
        $therapistId = TherapistId::generate();

        $this->assertTrue(
            $therapistId->equals($therapistId)
        );
    }
}
