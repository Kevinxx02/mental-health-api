<?php

declare(strict_types=1);

namespace App\Application\Session\ListSessions;

use App\Application\Ports\In\ListSessionsUseCase;
use App\Application\Ports\Out\SessionRepository;
use App\Domain\Session\Entities\Session;

final readonly class ListSessionsHandler implements ListSessionsUseCase
{
    public function __construct(
        private SessionRepository $repository
    ) {}

    /**
     * @return array<int, Session>
     */
    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}
