<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Session\ScheduleSession\ScheduleSessionCommand;
use App\Application\Session\ScheduleSession\ScheduleSessionHandler;
use App\Application\Session\CompleteSession\CompleteSessionCommand;
use App\Application\Session\CompleteSession\CompleteSessionHandler;
use App\Application\Session\CancelSession\CancelSessionCommand;
use App\Application\Session\CancelSession\CancelSessionHandler;
use App\Http\Requests\ScheduleSessionRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SessionController extends Controller
{
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

    public function reschedule(
        Request $request,
        string $id,
        RescheduleSessionHandler $handler,
    ) : JsonResponse {

        $handler(
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
