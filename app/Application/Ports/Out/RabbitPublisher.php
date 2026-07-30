<?php

declare(strict_types=1);

namespace App\Application\Ports\Out;

interface RabbitPublisher
{
    public function publish(
        string $payload,
        ?string $routingKey = null,
    ): void;
}
