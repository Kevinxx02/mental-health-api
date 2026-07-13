<?php

declare(strict_types=1);

namespace App\Application\Session\ScheduleSession;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;

final readonly class ScheduleSessionHandler
{
    public function __construct(private SessionRepository $repository) {}

    public function __invoke(
        ScheduleSessionCommand $command
    ): ScheduleSessionResponse {
        $session = Session::schedule(
            PatientId::fromString($command->patientId),
            TherapistId::fromString($command->therapistId),
            SessionDate::fromDateTime(
                new DateTimeImmutable($command->sessionDate)
            ),
        );

        $this->repository->save($session);

        return new ScheduleSessionResponse(
            sessionId: $session->id()->value(),
        );
    }
}
