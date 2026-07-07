<?php

declare(strict_types=1);

namespace App\Domain\Session\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use App\Domain\Shared\ValueObjects\UuidIdentifier;

final readonly class TherapistId extends UuidIdentifier {}
