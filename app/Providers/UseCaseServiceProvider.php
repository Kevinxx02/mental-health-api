<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Ports\In\ScheduleSessionUseCase;
use App\Application\Session\ScheduleSession\ScheduleSessionHandler;
use Illuminate\Support\ServiceProvider;

final class UseCaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ScheduleSessionUseCase::class,
            ScheduleSessionHandler::class,
        );
    }
}
