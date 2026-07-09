<?php

declare(strict_types=1);

namespace App\Domain\Session\Exceptions;

use App\Domain\Session\ValueObjects\SessionId;
use DomainException;

final class SessionNotFoundException extends DomainException
{
    public static function fromId(SessionId $id): self
    {
        return new self(
            sprintf(
                'Session "%s" was not found.',
                $id->value()
            )
        );
    }
}
