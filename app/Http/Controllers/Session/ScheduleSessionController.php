<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ScheduleSessionRequest;
use Symfony\Component\HttpFoundation\Response;

use App\Application\Session\ScheduleSession\ScheduleSessionCommand;
use App\Application\Session\ScheduleSession\ScheduleSessionHandler;

final class ScheduleSessionController extends Controller {
    public function __construct(
        private readonly ScheduleSessionHandler $handler,
    ) {}

    public function store(
        ScheduleSessionRequest $request
    ) : JsonResponse {
        $response = ($this->handler)(
            new ScheduleSessionCommand(
                patientId: $request->string('patient_id')->toString(),
                therapistId: $request->string('therapist_id')->toString(),
                sessionDate: $request->string('session_date')->toString()
            )
        );

        return response()->json(
            [
                'session_id' => $response->sessionId
            ],
            Response::HTTP_CREATED,
        );
    }
}
