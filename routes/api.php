<?php

use App\Http\Controllers\ApiAppController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\FileTitleController;
use App\Http\Controllers\JopController;
use App\Http\Controllers\VisaProfessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/register', [ApiAppController::class, 'register']);
Route::post('/confirm-code', [ApiAppController::class, 'verifyOtp']);
Route::post('/complete-data', action: [ApiAppController::class, 'completeData'])->middleware('auth:sanctum');
Route::post('/login', [ApiAppController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user-data', action: [ApiAppController::class, 'getUserData']);

Route::get('/hospital/{id}', [CustomerController::class, 'hospitalBook'])->name("hospital.book");
Route::post('/assign-group', [CustomerGroupController::class, 'assignGroup'])->name("group.assign");
Route::post('/assign-delegate', [DelegateController::class, 'assignDelegate'])->name("delegate.assign");
Route::post('/assign-bag', [BagController::class, 'assignBag'])->name("bag.assign");
Route::post('/send-sms', [JopController::class, 'sendSms'])->name('send.sms');
Route::post('/savePDF', [JopController::class, 'savePDF'])->name('savePDF');
Route::post('/send-engaz', [CustomerController::class, 'engaz_request'])->name('engaz_request');
Route::post('/professions', [VisaProfessionsController::class, 'professionFromAtutomition'])->name('profession');
