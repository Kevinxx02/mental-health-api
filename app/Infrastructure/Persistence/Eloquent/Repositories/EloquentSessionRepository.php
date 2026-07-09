<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use App\Domain\Session\ValueObjects\SessionStatus;
use App\Domain\Session\ValueObjects\TherapistId;
use App\Domain\Session\Exceptions\SessionNotFoundException;
use App\Infrastructure\Persistence\Eloquent\Models\SessionModel;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

final readonly class EloquentSessionRepository
    implements SessionRepository {

    public function __construct(private SessionModel $model) {}

    public function save(Session $session) : void {

        $model = $this->model->newInstance();

        $model->id = $session->id()->value();
        $model->patient_id = $session->patientId()->value();
        $model->therapist_id = $session->therapistId()->value();
        $model->session_date = $session->sessionDate()->value();
        $model->status = $session->status()->value;

        $model->save();
    }

    public function findById(SessionId $id) : Session {
        $model = $this->model
            ->newQuery()
            ->find($id->value());

        if ($model === null) {
            throw SessionNotFoundException::fromId($id);
        }

        return Session::restore(
            SessionId::fromString($model->id),
            PatientId::fromString($model->patient_id),
            TherapistId::fromString($model->therapist_id),
            SessionDate::fromDateTime(
                new \DateTimeImmutable(
                    $model->session_date->format('Y-m-d H:i:s')
                )
            ),
            SessionStatus::from($model->status),
        );
    }
}
