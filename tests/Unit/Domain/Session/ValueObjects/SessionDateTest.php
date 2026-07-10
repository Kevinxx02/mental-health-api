<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Session\ValueObjects;

use App\Domain\Session\Exceptions\InvalidSessionDateException;
use App\Domain\Session\ValueObjects\SessionDate;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class SessionDateTest extends TestCase {
    public function test_it_creates_a_valid_session_date(): void
    {
        $date = new DateTimeImmutable('tomorrow 09:00');

        $sessionDate = SessionDate::fromDateTime($date);

        $this->assertEquals($date, $sessionDate->value());
    }

    public function test_it_throws_when_date_is_in_the_past(): void
    {
        $this->expectException(InvalidSessionDateException::class);

        SessionDate::fromDateTime(
            new DateTimeImmutable('yesterday 09:00')
        );
    }

    public function test_it_throws_when_time_is_before_business_hours(): void
    {
        $this->expectException(InvalidSessionDateException::class);

        SessionDate::fromDateTime(
            new DateTimeImmutable('tomorrow 08:30')
        );
    }

    public function test_it_throws_when_time_is_after_business_hours(): void
    {
        $this->expectException(InvalidSessionDateException::class);

        SessionDate::fromDateTime(
            new DateTimeImmutable('tomorrow 21:30')
        );
    }

    public function test_it_throws_when_time_is_not_a_thirty_minute_slot(): void
    {
        $this->expectException(InvalidSessionDateException::class);

        SessionDate::fromDateTime(
            new DateTimeImmutable('tomorrow 09:15')
        );
    }

    public function test_it_compares_equal_dates(): void
    {
        $date = new DateTimeImmutable('tomorrow 10:00');

        $first = SessionDate::fromDateTime($date);
        $second = SessionDate::fromDateTime($date);

        $this->assertTrue(
            $first->equals($second)
        );
    }

    public function test_it_detects_different_dates(): void
    {
        $first = SessionDate::fromDateTime(
            new DateTimeImmutable('tomorrow 10:00')
        );

        $second = SessionDate::fromDateTime(
            new DateTimeImmutable('tomorrow 10:30')
        );

        $this->assertFalse(
            $first->equals($second)
        );
    }

    public function test_it_can_be_cast_to_string(): void
    {
        $date = new DateTimeImmutable('tomorrow 09:00');

        $sessionDate = SessionDate::fromDateTime($date);

        $this->assertSame(
            $date->format(\DateTimeInterface::ATOM),
            (string) $sessionDate
        );
    }
}
