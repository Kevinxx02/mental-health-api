<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Application\Session\ShowSession\ShowSessionHandler;
use App\Application\Session\ShowSession\ShowSessionQuery;
use App\Domain\Session\Entities\Session;
use Illuminate\Http\Resources\Json\JsonResource;

final class SessionResource extends JsonResource
{
    public function show(
        string $id,
        ShowSessionHandler $handler
    ): SessionResource {

        return new SessionResource(
            $handler(
                new ShowSessionQuery($id)
            )
        );
    }

    /**
     * @return array{
     *     id: string,
     *     patient_id: string,
     *     therapist_id: string,
     *     status: string,
     *     session_date: string
     * }
     */
    public function toArray($request): array
    {
        /** @var Session $session */
        $session = $this->resource;

        return [
            'id' => $session->id()->value(),
            'patient_id' => $session->patientId()->value(),
            'therapist_id' => $session->therapistId()->value(),
            'status' => $session->status()->value(),
            'session_date' => (string) $session->sessionDate(),
        ];
    }
}
