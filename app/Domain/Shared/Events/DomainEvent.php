<?php

declare(strict_types=1);

namespace App\Domain\Shared\Events;

interface DomainEvent
{
    public function eventName(): string;

    public function occurredOn(): \DateTimeImmutable;

    /**
     * @return array<string, mixed>
     */
    public function payload(): array;
}
