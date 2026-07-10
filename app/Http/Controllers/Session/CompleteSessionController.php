<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Application\Session\CompleteSession\CompleteSessionCommand;
use App\Application\Session\CompleteSession\CompleteSessionHandler;

final class CompleteSessionController extends Controller {
    public function __construct(private readonly CompleteSessionHandler $handler) {}

    public function complete(
        string $id,
        CompleteSessionHandler $handler
    ) : JsonResponse {

        $handler(
            new CompleteSessionCommand($id)
        );

        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
