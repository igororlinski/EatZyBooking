<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::middleware('web')->group(function () {
    Route::get('/restaurants', [ApiController::class, 'getRestaurants']);
    Route::put('/reservations/{id}', [ApiController::class, 'updateReservation']);
    Route::delete('/reservations/{id}', [ApiController::class, 'deleteReservation']);
    Route::delete('/reviews/{id}', [ApiController::class, 'deleteReview']);
    Route::delete('/photos/{id}', [ApiController::class, 'deletePhoto']);
});
