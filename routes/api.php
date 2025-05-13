<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function (Request $request) {
    return response()->json(['message' => 'success'], 200);
});

Route::prefix('patient')->middleware('auth-api')->group(function () {
    Route::get('/', [App\Http\Controllers\PatientController::class, 'index']);
    Route::post('/', [App\Http\Controllers\PatientController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\PatientController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\PatientController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\PatientController::class, 'destroy']);
});
