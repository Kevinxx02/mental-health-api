<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Application\Session\CancelSession\CancelSessionCommand;
use App\Application\Session\CancelSession\CancelSessionHandler;

final class CancelSessionController extends Controller {
    public function __construct(private readonly CancelSessionHandler $handler) {}

    public function cancel(
        string $id,
        CancelSessionHandler $handler
    ) : JsonResponse {

        $handler(
            new CancelSessionCommand($id)
        );

        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
