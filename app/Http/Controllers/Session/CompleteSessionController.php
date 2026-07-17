<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Ports\In\CompleteSessionUseCase;
use App\Application\Session\CompleteSession\CompleteSessionCommand;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CompleteSessionController extends Controller
{
    public function complete(
        string $id,
        CompleteSessionUseCase $useCase
    ): JsonResponse {

        $useCase(
            new CompleteSessionCommand($id)
        );

        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
