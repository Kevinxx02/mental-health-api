<?php

declare(strict_types=1);

namespace App\Domain\Session\Exceptions;

use DomainException;

final class InvalidSessionStateException extends DomainException {
    public static function alreadyCompleted(): self {
        return new self(
            'The session has already been completed.'
        );
    }

    public static function alreadyCancelled(): self {
        return new self(
            'The session has already been cancelled.'
        );
    }

    public static function cannotCompleteCancelledSession(): self {
        return new self(
            'A cancelled session cannot be completed.'
        );
    }

    public static function cannotCancelCompletedSession(): self {
        return new self(
            'A completed session cannot be cancelled.'
        );
    }

    public static function cannotRescheduleCompletedSession(): self {
        return new self(
            'A completed session cannot be rescheduled.'
        );
    }

    public static function cannotRescheduleCancelledSession(): self {
        return new self(
            'A cancelled session cannot be rescheduled.'
        );
    }
}
