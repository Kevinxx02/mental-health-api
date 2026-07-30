<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ;

use App\Application\Ports\Out\RabbitConnection;
use App\Application\Ports\Out\RabbitPublisher;
use App\Application\Ports\Out\RabbitTopology;
use PhpAmqpLib\Message\AMQPMessage;

final readonly class AmqpRabbitPublisher implements RabbitPublisher
{
    public function __construct(
        private RabbitConnection $connection,
        private RabbitTopology $topology,
    ) {}

    public function publish(
        string $payload,
        ?string $routingKey = null,
    ): void {
        $this->topology->initialize();

        $message = new AMQPMessage(
            $payload,
            [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ],
        );

        $this->connection
            ->channel()
            ->basic_publish(
                $message,
                'domain.events',
                'session.scheduled',
            );
    }
}
