<?php

declare(strict_types=1);

namespace App\Application\Session\ScheduleSession;

use App\Application\Ports\In\ScheduleSessionUseCase;
use App\Application\Ports\Out\DomainEventPublisher;
use App\Application\Ports\Out\SessionRepository;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Events\SessionScheduled;
use App\Domain\Session\ValueObjects\PatientId;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\TherapistId;
use DateTimeImmutable;

final readonly class ScheduleSessionHandler implements ScheduleSessionUseCase
{
    public function __construct(
        private SessionRepository $repository,
        private DomainEventPublisher $eventPublisher,
    ) {}

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

        $this->eventPublisher->publish(
            new SessionScheduled(
                sessionId: $session->id(),
                patientId: $session->patientId(),
                therapistId: $session->therapistId(),
                sessionDate: $session->sessionDate(),
            ),
        );

        return new ScheduleSessionResponse(
            sessionId: $session->id()->value(),
        );
    }
}
