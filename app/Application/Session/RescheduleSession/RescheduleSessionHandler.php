<?php

declare(strict_types=1);

namespace App\Application\Session\RescheduleSession;

use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\SessionDate;
use App\Domain\Session\ValueObjects\SessionId;
use DateTimeImmutable;

final readonly class RescheduleSessionHandler
{
    public function __construct(
        private SessionRepository $repository
    ) {}

    public function __invoke(RescheduleSessionCommand $command): void
    {
        $session = $this->repository->findById(
            SessionId::fromString($command->sessionId)
        );

        $session->reschedule(
            SessionDate::fromDateTime(
                new DateTimeImmutable($command->sessionDate)
            )
        );

        $this->repository->update($session);
    }
}
