<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use App\Application\Ports\Out\RabbitConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class AmqpRabbitConnection implements RabbitConnection
{
    private ?AMQPStreamConnection $connection = null;

    private ?AMQPChannel $channel = null;

    public function channel(): AMQPChannel
    {
        if ($this->channel instanceof AMQPChannel) {
            return $this->channel;
        }

        $this->connection = new AMQPStreamConnection(
            host: 'rabbitmq',
            port: 5672,
            user: 'guest',
            password: 'guest',
            vhost: '/'
        );

        $this->channel = $this->connection->channel();

        return $this->channel;
    }

    public function disconnect(): void
    {
        $this->channel?->close();
        $this->connection?->close();

        $this->channel = null;
        $this->connection = null;
    }
}
