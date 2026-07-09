<?php
namespace App\Domain\Session\Repositories;

use App\Domain\Session\Entities\Session;
use App\Domain\Session\ValueObjects\SessionId;

interface SessionRepository {
    public function save(Session $session) : void;

    public function update(Session $session) : void;

    public function findById(SessionId $id) : Session;

    /**
     * @return list<Session>
     */
    public function findAll(): array;
}
