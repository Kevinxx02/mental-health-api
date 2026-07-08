<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentSessionRepository;
use Illuminate\Support\ServiceProvider;
use App\Domain\Session\Repositories\SessionRepository;

final class RepositoryServiceProvider extends ServiceProvider {
    public function register() : void {
        $this->app->bind(
            SessionRepository::class,
            EloquentSessionRepository::class
        );
    }
}
