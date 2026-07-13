<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Session\ListSessions\ListSessionsHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ListSessionsController extends Controller
{
    public function __construct(private readonly ListSessionsHandler $handler) {}

    public function index(): AnonymousResourceCollection
    {
        return SessionResource::collection(
            ($this->handler)()
        );
    }
}
