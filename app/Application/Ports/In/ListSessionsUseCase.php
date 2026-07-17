<?php

declare(strict_types=1);

namespace App\Application\Ports\In;

use App\Domain\Session\Entities\Session;

interface ListSessionsUseCase
{
    /**
     * @return array<int, Session>
     */
    public function __invoke(): array;
}
