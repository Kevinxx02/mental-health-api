<?php

use App\Http\Controllers\Session\CancelSessionController;
use App\Http\Controllers\Session\CompleteSessionController;
use App\Http\Controllers\Session\ListSessionsController;
use App\Http\Controllers\Session\RescheduleSessionController;
use App\Http\Controllers\Session\ScheduleSessionController;
use App\Http\Controllers\Session\ShowSessionController;
use Illuminate\Support\Facades\Route;

Route::post(
    '/sessions',
    [ScheduleSessionController::class, 'store']
);

Route::patch(
    '/sessions/{id}/complete',
    [CompleteSessionController::class, 'complete']
);

Route::patch(
    '/sessions/{id}/cancel',
    [CancelSessionController::class, 'cancel']
);

Route::patch(
    '/sessions/{id}/reschedule',
    [RescheduleSessionController::class, 'reschedule']
);

Route::get(
    '/sessions',
    [ListSessionsController::class, 'index']
);

Route::get(
    '/sessions/{id}',
    [ShowSessionController::class, 'show']
);
