<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Ports\In\CancelSessionUseCase;
use App\Application\Ports\In\CompleteSessionUseCase;
use App\Application\Ports\In\ScheduleSessionUseCase;
use App\Application\Ports\In\ShowSessionUseCase;
use App\Application\Session\CancelSession\CancelSessionHandler;
use App\Application\Session\CompleteSession\CompleteSessionHandler;
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

        $this->app->bind(
            CancelSessionUseCase::class,
            CancelSessionHandler::class,
        );

        $this->app->bind(
            CompleteSessionUseCase::class,
            CompleteSessionHandler::class,
        );
    }
}
