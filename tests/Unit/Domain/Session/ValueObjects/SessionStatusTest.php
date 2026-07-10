<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Session\ValueObjects;

use App\Domain\Session\ValueObjects\SessionStatus;
use PHPUnit\Framework\TestCase;

final class SessionStatusTest extends TestCase {
    public function test_default_status_is_scheduled(): void {
        $this->assertSame(
            SessionStatus::Scheduled,
            SessionStatus::default()
        );
    }

    public function test_it_knows_when_it_is_scheduled(): void {
        $this->assertTrue(
            SessionStatus::Scheduled->isScheduled()
        );

        $this->assertFalse(
            SessionStatus::Completed->isScheduled()
        );
    }

    public function test_it_knows_when_it_is_completed(): void {
        $this->assertTrue(
            SessionStatus::Completed->isCompleted()
        );

        $this->assertFalse(
            SessionStatus::Cancelled->isCompleted()
        );
    }

    public function test_it_knows_when_it_is_cancelled(): void {
        $this->assertTrue(
            SessionStatus::Cancelled->isCancelled()
        );

        $this->assertFalse(
            SessionStatus::Scheduled->isCancelled()
        );
    }
}
