<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\Session;
use App\Application\Session\ShowSession\ShowSessionQuery;
use App\Application\Session\ShowSession\ShowSessionHandler;

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
