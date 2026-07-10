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

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\RescheduleSessionRequest;


final class RescheduleSessionController extends Controller {
    public function __construct(private readonly RescheduleSessionHandler $handler) {}

    public function reschedule(
        RescheduleSessionRequest $request,
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
