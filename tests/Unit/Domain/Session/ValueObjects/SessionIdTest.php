<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Session\ValueObjects;

use App\Domain\Session\ValueObjects\SessionId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class SessionIdTest extends TestCase
{
    public function test_it_generates_a_valid_uuid_v7(): void
    {
        $sessionId = SessionId::generate();

        $this->assertTrue(
            Uuid::isValid($sessionId->value())
        );

        $this->assertSame(
            7,
            Uuid::fromString($sessionId->value())->getVersion()
        );
    }

    public function test_it_creates_a_session_id_from_a_valid_string(): void
    {
        $uuid = Uuid::uuid7()->toString();

        $sessionId = SessionId::fromString($uuid);

        $this->assertSame(
            $uuid,
            $sessionId->value()
        );
    }

    public function test_it_throws_an_exception_when_the_uuid_is_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        SessionId::fromString('invalid-uuid');
    }

    public function test_it_considers_two_equal_ids_as_equal(): void
    {
        $uuid = Uuid::uuid7()->toString();

        $first = SessionId::fromString($uuid);
        $second = SessionId::fromString($uuid);

        $this->assertTrue(
            $first->equals($second)
        );
    }

    public function test_it_considers_different_ids_as_different(): void
    {
        $first = SessionId::generate();
        $second = SessionId::generate();

        $this->assertFalse(
            $first->equals($second)
        );
    }

    public function test_it_can_be_cast_to_string(): void
    {
        $sessionId = SessionId::generate();

        $this->assertSame(
            $sessionId->value(),
            (string) $sessionId
        );
    }

    public function test_it_equals_itself(): void
    {
        $sessionId = SessionId::generate();

        $this->assertTrue(
            $sessionId->equals($sessionId)
        );
    }
}
