<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Ports\In\RescheduleSessionUseCase;
use App\Application\Session\RescheduleSession\RescheduleSessionCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\RescheduleSessionRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RescheduleSessionController extends Controller
{
    public function reschedule(
        RescheduleSessionRequest $request,
        string $id,
        RescheduleSessionUseCase $useCase,
    ): JsonResponse {

        $useCase(
            new RescheduleSessionCommand(
                sessionId: $id,
                sessionDate: $request->string('session_date')->toString()
            )
        );

        return response()->json(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
