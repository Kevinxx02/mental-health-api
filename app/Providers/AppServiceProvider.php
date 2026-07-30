<?php

namespace App\Providers;

use App\Application\Ports\Out\EventSerializer;
use App\Application\Ports\Out\RabbitConnection;
use App\Application\Ports\Out\RabbitPublisher;
use App\Application\Ports\Out\RabbitTopology;
use App\Infrastructure\RabbitMQ\AmqpRabbitConnection;
use App\Infrastructure\RabbitMQ\AmqpRabbitPublisher;
use App\Infrastructure\RabbitMQ\AmqpRabbitTopology;
use App\Infrastructure\Serialization\JsonEventSerializer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            EventSerializer::class,
            JsonEventSerializer::class,
        );
        $this->app->singleton(
            RabbitPublisher::class,
            AmqpRabbitPublisher::class,
        );
        $this->app->singleton(
            RabbitConnection::class,
            AmqpRabbitConnection::class,
        );
        $this->app->singleton(
            RabbitTopology::class,
            AmqpRabbitTopology::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
