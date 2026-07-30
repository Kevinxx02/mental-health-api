<?php

declare(strict_types=1);

namespace App\Application\Ports\Out;

use PhpAmqpLib\Channel\AMQPChannel;

interface RabbitConnection
{
    public function channel(): AMQPChannel;

    public function disconnect(): void;
}
