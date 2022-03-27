<?php

use App\Http\Controllers\Api\TeamController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/teams', TeamController::class);

Route::get('/', function() {
    return response()->json(['message' => 'success']);
});
