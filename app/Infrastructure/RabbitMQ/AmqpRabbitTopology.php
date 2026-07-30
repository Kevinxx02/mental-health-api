<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use App\Application\Ports\Out\RabbitConnection;
use App\Application\Ports\Out\RabbitTopology;
use PhpAmqpLib\Channel\AMQPChannel;

final readonly class AmqpRabbitTopology implements RabbitTopology
{
    public function __construct(
        private RabbitConnection $connection,
    ) {}

    public function initialize(): void
    {
        $this->declareExchange(
            $this->connection->channel(),
        );
    }

    public function declareExchange(
        AMQPChannel $channel,
    ): void {
        $channel->exchange_declare(
            exchange: 'domain.events',
            type: 'topic', // o direct, según el diseño final
            passive: false,
            durable: true,
            auto_delete: false,
        );
    }
}
