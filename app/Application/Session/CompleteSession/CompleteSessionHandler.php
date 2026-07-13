<?php

declare(strict_types=1);

namespace App\Application\Session\CompleteSession;

use App\Domain\Session\Exceptions\SessionNotFoundException;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\SessionId;

final readonly class CompleteSessionHandler
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

        if ($session === null) {
            throw SessionNotFoundException::fromId(
                $sessionId
            );
        }

        $session->complete();

        $this->repository->update($session);
    }
}
