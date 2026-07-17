<?php

declare(strict_types=1);

namespace App\Application\Session\CompleteSession;

use App\Application\Ports\In\CompleteSessionUseCase;
use App\Application\Ports\Out\SessionRepository;
use App\Domain\Session\ValueObjects\SessionId;

final readonly class CompleteSessionHandler implements CompleteSessionUseCase
{
    public function __construct(
        private SessionRepository $repository
    ) {}

    public function __invoke(CompleteSessionCommand $command): void
    {
        $sessionId = SessionId::fromString(
            $command->sessionId
        );

        $session = $this->repository->findById(
            $sessionId
        );

        $session->complete();

        $this->repository->update($session);
    }
}
