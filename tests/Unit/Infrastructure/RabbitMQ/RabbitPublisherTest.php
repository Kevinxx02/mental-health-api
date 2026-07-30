<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\RabbitMQ;

use App\Application\Ports\Out\RabbitConnection;
use App\Application\Ports\Out\RabbitTopology;
use App\Infrastructure\RabbitMQ\AmqpRabbitPublisher;
use App\Infrastructure\RabbitMQ\AmqpRabbitTopology;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;

final class RabbitPublisherTest extends TestCase
{
    public function test_it_initializes_topology_before_publishing(): void
    {
        $channel = $this->createMock(AMQPChannel::class);

        $connection = $this->createMock(RabbitConnection::class);

        $connection
            ->expects($this->once())
            ->method('channel')
            ->willReturn($channel);

        $topology = $this->createMock(RabbitTopology::class);

        $topology
            ->expects($this->once())
            ->method('initialize');

        $channel
            ->expects($this->once())
            ->method('basic_publish');

        $publisher = new AmqpRabbitPublisher(
            $connection,
            $topology,
        );

        $publisher->publish(
            '{}',
            'session.scheduled',
        );
    }

    public function test_it_publishes_json_message(): void
    {
        $channel = $this->createMock(AMQPChannel::class);

        $connection = $this->createMock(RabbitConnection::class);

        $connection
            ->method('channel')
            ->willReturn($channel);

        $topology = $this->createMock(RabbitTopology::class);

        $topology
            ->expects($this->once())
            ->method('initialize');

        $channel
            ->expects($this->once())
            ->method('basic_publish')
            ->with(
                $this->callback(function (AMQPMessage $message) {
                    return
                        $message->getBody() === '{}' &&
                        $message->get_properties()['content_type'] === 'application/json' &&
                        $message->get_properties()['delivery_mode']
                            === AMQPMessage::DELIVERY_MODE_PERSISTENT;
                }),
                'domain.events',
                'session.scheduled',
            );

        $publisher = new AmqpRabbitPublisher(
            $connection,
            $topology,
        );

        $publisher->publish(
            '{}',
            'session.scheduled',
        );
    }

    public function test_it_declares_exchange(): void
    {
        $channel = $this->createMock(AMQPChannel::class);

        $channel
            ->expects($this->once())
            ->method('exchange_declare')
            ->with(
                'domain.events',
                'topic',
                false,
                true,
                false,
            );

        $connection = $this->createMock(RabbitConnection::class);

        $topology = new AmqpRabbitTopology(
            $connection,
        );

        $topology->declareExchange($channel);
    }
}
