<?php

declare(strict_types=1);

namespace App\Domain\Session\ValueObjects;

use App\Domain\Session\Exceptions\InvalidSessionDateException;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class SessionDate {
    private function __construct(private DateTimeImmutable $value) {}

    public static function fromDateTime(DateTimeImmutable $date): self {
        self::ensureIsNotPast($date);
        self::ensureBusinessHours($date);
        self::ensureThirtyMinuteSlot($date);

        return new self($date);
    }

    public function value(): DateTimeImmutable {
        return $this->value;
    }

    public function equals(self $other): bool {
        return $this->value == $other->value;
    }

    public function __toString(): string {
        return $this->value->format(DateTimeInterface::ATOM);
    }

    private static function ensureIsNotPast(DateTimeImmutable $date): void {
        if ($date < new DateTimeImmutable()) {
            throw InvalidSessionDateException::pastDate();
        }
    }

    private static function ensureBusinessHours(DateTimeImmutable $date): void {
        $time = $date->format('H:i');

        $morning = $time >= '09:00' && $time <= '13:30';
        $afternoon = $time >= '17:00' && $time <= '21:00';

        if (! $morning && ! $afternoon) {
            throw InvalidSessionDateException::outsideBusinessHours();
        }
    }

    private static function ensureThirtyMinuteSlot(DateTimeImmutable $date): void {
        $minutes = (int) $date->format('i');

        if (! in_array($minutes, [0, 30], true)) {
            throw InvalidSessionDateException::invalidTimeSlot();
        }
    }
}
