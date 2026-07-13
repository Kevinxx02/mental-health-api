<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Session\CompleteSession\CompleteSessionCommand;
use App\Application\Session\CompleteSession\CompleteSessionHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CompleteSessionController extends Controller
{
    public function __construct(private readonly CompleteSessionHandler $handler) {}

    public function complete(
        string $id,
        CompleteSessionHandler $handler
    ): JsonResponse {

        $handler(
            new CompleteSessionCommand($id)
        );

        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
