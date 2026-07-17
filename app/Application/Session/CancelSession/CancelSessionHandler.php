<?php

declare(strict_types=1);

namespace App\Application\Session\CancelSession;

use App\Application\Ports\In\CancelSessionUseCase;
use App\Application\Ports\Out\SessionRepository;
use App\Domain\Session\ValueObjects\SessionId;

final readonly class CancelSessionHandler implements CancelSessionUseCase
{
    public function __construct(
        private SessionRepository $repository
    ) {}

    public function __invoke(CancelSessionCommand $command): void
    {
        $sessionId = SessionId::fromString(
            $command->sessionId
        );

        $session = $this->repository->findById(
            $sessionId
        );

        $session->cancel();

        $this->repository->update($session);
    }
}
