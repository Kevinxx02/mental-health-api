<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id()->value(),
            'patient_id' => $this->patientId()->value(),
            'therapist_id' => $this->therapistId()->value(),
            'session_date' => $this->sessionDate()->value()->format(DATE_ATOM),
            'status' => $this->status()->value,
        ];
    }

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
}
