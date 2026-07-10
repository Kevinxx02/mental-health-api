<?php

declare(strict_types=1);

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Application\Session\RescheduleSession\RescheduleSessionCommand;
use App\Application\Session\RescheduleSession\RescheduleSessionHandler;

use App\Application\Session\ListSessions\ListSessionsHandler;
use App\Http\Resources\SessionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use App\Application\Session\ScheduleSession\ScheduleSessionHandler;
use App\Http\Requests\ScheduleSessionRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RescheduleSessionController extends Controller {
    public function __construct(private readonly RescheduleSessionHandler $handler) {}

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
