<?php

declare(strict_types=1);

namespace App\Domain\Session\Events;

use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\TherapistId;
use App\Domain\Shared\Events\DomainEvent;
use DateTimeImmutable;

final readonly class SessionScheduled implements DomainEvent
{
    public function __construct(
        private SessionId $sessionId,
        private PatientId $patientId,
        private TherapistId $therapistId,
        private SessionDate $sessionDate,
        private DateTimeImmutable $occurredOn = new DateTimeImmutable,
    ) {}

    public function eventName(): string
    {
        return 'session.scheduled';
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    /**
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        return [
            'sessionId' => (string) $this->sessionId,
            'patientId' => (string) $this->patientId,
            'therapistId' => (string) $this->therapistId,
            'sessionDate' => (string) $this->sessionDate,
        ];
    }
}
