<?php

declare(strict_types=1);

namespace App\Domain\Session\Entities;

use App\Domain\Session\Exceptions\InvalidSessionStateException;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\SessionStatus;
use App\Domain\Session\ValueObjects\TherapistId;

final class Session {
    private function __construct(
        private readonly SessionId $id,
        private readonly PatientId $patientId,
        private readonly TherapistId $therapistId,
        private SessionDate $sessionDate,
        private SessionStatus $status,
    ) {}

    public static function schedule(
        SessionId $id,
        PatientId $patientId,
        TherapistId $therapistId,
        SessionDate $sessionDate,
    ): self {
        return new self(
            $id,
            $patientId,
            $therapistId,
            $sessionDate,
            SessionStatus::default(),
        );
    }

    public function complete(): void {
        if ($this->status->isCompleted()) {
            throw InvalidSessionStateException::alreadyCompleted();
        }

        if ($this->status->isCancelled()) {
            throw InvalidSessionStateException::cannotCompleteCancelledSession();
        }

        $this->status = SessionStatus::Completed;
    }

    public function cancel(): void {
        if ($this->status->isCancelled()) {
            throw InvalidSessionStateException::alreadyCancelled();
        }

        if ($this->status->isCompleted()) {
            throw InvalidSessionStateException::cannotCancelCompletedSession();
        }

        $this->status = SessionStatus::Cancelled;
    }

    public function reschedule(SessionDate $newDate): void {
        if ($this->status->isCompleted()) {
            throw InvalidSessionStateException::cannotRescheduleCompletedSession();
        }

        if ($this->status->isCancelled()) {
            throw InvalidSessionStateException::cannotRescheduleCancelledSession();
        }

        $this->sessionDate = $newDate;
    }

    public function id(): SessionId {
        return $this->id;
    }

    public function patientId(): PatientId {
        return $this->patientId;
    }

    public function therapistId(): TherapistId {
        return $this->therapistId;
    }

    public function sessionDate(): SessionDate {
        return $this->sessionDate;
    }

    public function status(): SessionStatus {
        return $this->status;
    }
}
