<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Application\Session\ScheduleSession\ScheduleSessionCommand;
use App\Application\Ports\In\ScheduleSessionUseCase;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleSessionRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ScheduleSessionController extends Controller
{
    public function __construct(
        private readonly ScheduleSessionUseCase $useCase,
    ) {}

    public function store(
        ScheduleSessionRequest $request
    ): JsonResponse {
        $response = ($this->useCase)(
            new ScheduleSessionCommand(
                patientId: $request->string('patient_id')->toString(),
                therapistId: $request->string('therapist_id')->toString(),
                sessionDate: $request->string('session_date')->toString()
            )
        );

        return response()->json(
            [
                'session_id' => $response->sessionId,
            ],
            Response::HTTP_CREATED,
        );
    }
}
