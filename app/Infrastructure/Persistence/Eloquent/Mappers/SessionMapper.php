<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\SessionStatus;
use App\Domain\Session\ValueObjects\TherapistId;
use App\Infrastructure\Persistence\Eloquent\Models\SessionModel;

final class SessionMapper
{
    public static function toDomain(
        SessionModel $model
    ): Session {
        return Session::restore(
            SessionId::fromString($model->id),
            PatientId::fromString($model->patient_id),
            TherapistId::fromString($model->therapist_id),
            SessionDate::fromDateTime($model->session_date),
            SessionStatus::from($model->status)
        );
    }
}
