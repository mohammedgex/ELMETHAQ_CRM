<?php

use App\Http\Controllers\ApiAppController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\FileTitleController;
use App\Http\Controllers\JopController;
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
Route::get('/hospital/{id}', [CustomerController::class, 'hospitalBook'])->name("hospital.book");
Route::post('/assign-group', [CustomerGroupController::class, 'assignGroup'])->name("group.assign");
Route::post('/assign-delegate', [DelegateController::class, 'assignDelegate'])->name("delegate.assign");
Route::post('/assign-bag', [BagController::class, 'assignBag'])->name("bag.assign");
