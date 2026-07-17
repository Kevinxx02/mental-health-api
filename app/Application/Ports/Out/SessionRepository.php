<?php

namespace App\Application\Ports\Out;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\ValueObjects\SessionId;

interface SessionRepository
{
    public function save(Session $session): void;

    public function update(Session $session): void;

    public function findById(SessionId $id): Session;

    /**
     * @return array<int, Session>
     */
    public function findAll(): array;
}
