<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Ports\In\CancelSessionUseCase;
use App\Application\Session\CancelSession\CancelSessionCommand;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CancelSessionController extends Controller
{
    public function cancel(
        string $id,
        CancelSessionUseCase $useCase
    ): JsonResponse {

        $useCase(
            new CancelSessionCommand($id)
        );

        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
