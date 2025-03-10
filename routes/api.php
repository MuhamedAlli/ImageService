<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::prefix('images')->middleware('validate-token')->group(function () {
    Route::post('/upload', [ImageController::class, 'upload']);
    Route::get('/{user_id}', [ImageController::class, 'getByUserId']);
    Route::delete('/{user_id}', [ImageController::class, 'deleteByUserId']);
});

Route::get('external/images/{user_id}', [ImageController::class, 'getByUserId']);

//handles not found routes
Route::fallback(function (Request $request) {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
});
