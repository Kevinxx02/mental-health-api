<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Session\ShowSession\ShowSessionHandler;
use App\Application\Session\ShowSession\ShowSessionQuery;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResource;

final class ShowSessionController extends Controller {
    public function __construct(
        private readonly ShowSessionHandler $handler,
    ) {}

    public function show(
        string $id
    ): SessionResource {

        return new SessionResource(
            ($this->handler)(
                new ShowSessionQuery($id)
            )
        );
    }
}
