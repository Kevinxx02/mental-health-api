<?php

declare(strict_types=1);

namespace App\Domain\Session\ValueObjects;

enum SessionStatus: string {
    case Scheduled = 'scheduled';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public static function default(): self
    {
        return self::Scheduled;
    }

    public function isScheduled(): bool
    {
        return $this === self::Scheduled;
    }

    public function isCompleted(): bool
    {
        return $this === self::Completed;
    }

    public function isCancelled(): bool
    {
        return $this === self::Cancelled;
    }
}
