<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::post('/sessions', [SessionController::class, 'store']);
