<?php

declare(strict_types=1);

namespace App\Application\Session\ShowSession;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;
use App\Application\Session\ShowSession\ShowSessionQuery;
use App\Domain\Session\ValueObjects\SessionId;

final readonly class ShowSessionHandler {
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
