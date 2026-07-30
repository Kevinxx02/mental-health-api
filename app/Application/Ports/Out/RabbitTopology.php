<?php

declare(strict_types=1);

namespace App\Application\Ports\Out;

interface RabbitTopology
{
    public function initialize(): void;
}
