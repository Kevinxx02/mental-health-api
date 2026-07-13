<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Session\CancelSession\CancelSessionCommand;
use App\Application\Session\CancelSession\CancelSessionHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CancelSessionController extends Controller
{
    public function __construct(private readonly CancelSessionHandler $handler) {}

    public function cancel(
        string $id,
        CancelSessionHandler $handler
    ): JsonResponse {

        $handler(
            new CancelSessionCommand($id)
        );

        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
