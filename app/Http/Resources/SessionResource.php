<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Application\Session\ShowSession\ShowSessionHandler;
use App\Application\Session\ShowSession\ShowSessionQuery;
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
}
