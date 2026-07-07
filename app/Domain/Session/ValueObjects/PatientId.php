<?php

declare(strict_types=1);

namespace App\Domain\Session\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class PatientId
{
    private function __construct(private UuidInterface $value) {}

    public static function generate(): self {
        return new self(Uuid::uuid7());
    }

    public static function fromString(string $value): self {
        if (! Uuid::isValid($value)) {
            throw new InvalidArgumentException(
                'PatientId must be a valid UUID.'
            );
        }

        return new self(
            Uuid::fromString($value)
        );
    }

    public function value(): string {
        return $this->value->toString();
    }

    public function equals(self $other): bool {
        return $this->value->equals($other->value);
    }

    public function __toString(): string {
        return $this->value();
    }
}
