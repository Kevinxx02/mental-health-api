<?php

declare(strict_types=1);

namespace App\Domain\Session\Exceptions;

use DomainException;

final class InvalidSessionDateException extends DomainException {
    public static function pastDate(): self {
        return new self(
            'A session cannot be scheduled in the past.'
        );
    }

    public static function outsideBusinessHours(): self {
        return new self(
            'A session must be scheduled during business hours (09:00-13:30 or 17:00-21:00).'
        );
    }

    public static function invalidTimeSlot(): self {
        return new self(
            'A session must start on a 30-minute time slot.'
        );
    }
}
