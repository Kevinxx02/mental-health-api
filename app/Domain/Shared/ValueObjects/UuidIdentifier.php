<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract readonly class UuidIdentifier
{
    final protected function __construct(
        protected UuidInterface $value,
    ) {}

    public static function generate(): static
    {
        return new static(
            Uuid::uuid7()
        );
    }

    public static function fromString(string $value): static
    {
        try {
            return new static(
                Uuid::fromString($value)
            );
        } catch (\Throwable) {
            throw new InvalidArgumentException(
                'It must be a valid UUID.'
            );
        }
    }

    public function value(): string
    {
        return $this->value->toString();
    }

    public function equals(self $other): bool
    {
        return static::class === $other::class
            && $this->value->equals($other->value);
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
