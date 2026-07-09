<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::post('/sessions', [SessionController::class, 'store']);

Route::patch(
    '/sessions/{id}/complete',
    [SessionController::class, 'complete']
);

Route::patch(
    '/sessions/{id}/cancel',
    [SessionController::class, 'cancel']
);

Route::patch(
    '/sessions/{id}/reschedule',
    [SessionController::class, 'reschedule']
);
