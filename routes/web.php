<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });


//handles not found routes
Route::fallback(function (Request $request) {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
});
