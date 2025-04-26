<?php

use App\Http\Controllers\ApiAppController;
use App\Http\Controllers\FileTitleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/register', [ApiAppController::class, 'register']);
Route::post('/confirm-code', [ApiAppController::class, 'verifyOtp']);
Route::post('/complete-data', [ApiAppController::class, 'completeData'])->middleware('auth:sanctum');
Route::post('/login', [ApiAppController::class, 'login']);

Route::post('/send-file/{id}', [FileTitleController::class, 'sendFile']);
