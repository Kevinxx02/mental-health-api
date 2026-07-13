<?php

declare(strict_types=1);

namespace App\Application\Session\ListSessions;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\Repositories\SessionRepository;

final readonly class ListSessionsHandler
{
    public function __construct(
        private SessionRepository $repository
    ) {}

    /**
     * @return list<Session>
     */
    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}
