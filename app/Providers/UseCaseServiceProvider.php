<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Ports\In\ScheduleSessionUseCase;
use App\Application\Ports\In\ShowSessionUseCase;
use App\Application\Session\ScheduleSession\ScheduleSessionHandler;
use App\Application\Session\ShowSession\ShowSessionHandler;
use Illuminate\Support\ServiceProvider;

final class UseCaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ScheduleSessionUseCase::class,
            ScheduleSessionHandler::class,
        );

        $this->app->bind(
            ShowSessionUseCase::class,
            ShowSessionHandler::class,
        );
    }
}
