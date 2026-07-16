<?php

declare(strict_types=1);

namespace App\Application\Session\ShowSession;

use App\Application\Ports\In\ShowSessionUseCase;
use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;
use App\Domain\Session\ValueObjects\SessionId;

final readonly class ShowSessionHandler implements ShowSessionUseCase
{
    public function __construct(
        private SessionRepository $repository
    ) {}

    public function __invoke(
        ShowSessionQuery $query
    ): Session {

        $sessionId = SessionId::fromString(
            $query->sessionId
        );

        return $this->repository->findById($sessionId);
    }
}
