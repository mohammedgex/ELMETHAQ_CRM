<?php

use App\Http\Controllers\ApiAppController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\GmailPubSubController;
use App\Http\Controllers\JobAnswerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JopController;
use App\Http\Controllers\LeadsCustomersController;
use App\Http\Controllers\VisaProfessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/register', [ApiAppController::class, 'register']);
Route::post('/confirm-code', [ApiAppController::class, 'verifyOtp']);
Route::post('/complete-data', [ApiAppController::class, 'completeData'])->middleware('auth:sanctum');
Route::post('/photo-national-card', [ApiAppController::class, 'photo_national_card'])->middleware('auth:sanctum');
Route::post('/photo-license', [ApiAppController::class, 'photo_license'])->middleware('auth:sanctum');
Route::post('/login', [ApiAppController::class, 'login']);
Route::post('/visa/{id}', [ApiAppController::class, 'visa']);
Route::middleware('auth:sanctum')->get('/user-data',  [ApiAppController::class, 'getUserData']);
Route::middleware('auth:sanctum')->post('/send-file/{id}',  [ApiAppController::class, 'send_file']);
Route::get('/jobs', [JobController::class, 'apiIndex']);
Route::post('/save-any-fcm-token', [ApiAppController::class, 'saveAnyFcmToken']);
Route::post('/send-otp/{phone}', [ApiAppController::class, 'sendOtp']);

Route::get('/hospital/{id}', [CustomerController::class, 'hospitalBook'])->name("hospital.book");
Route::post('/assign-group', [CustomerGroupController::class, 'assignGroup'])->name("group.assign");
Route::post('/assign-delegate', [DelegateController::class, 'assignDelegate'])->name("delegate.assign");
Route::post('/assign-bag', [BagController::class, 'assignBag'])->name("bag.assign");
Route::post('/send-sms', [JopController::class, 'sendSms'])->name('send.sms');
Route::post('/send-sms-lead', [LeadsCustomersController::class, 'sendSmsLead'])->name('send.sms.lead');
Route::post('/savePDF', [JopController::class, 'savePDF'])->name('savePDF');
Route::post('/send-engaz', [CustomerController::class, 'engaz_request'])->name('engaz_request');
Route::post('/professions', [VisaProfessionsController::class, 'professionFromAtutomition'])->name('profession');
Route::post('/check-medical-status', [ApiAppController::class, 'checkMedicalStatus']);
Route::post('/token/check-medical', [ApiAppController::class, 'TokenCheckMedical']);
Route::post('/store-medical-result', [ApiAppController::class, 'store']);

Route::post('/forgot-password', [ApiAppController::class, 'forgetPasswordPhone']);
Route::post('/reset-password-code', [ApiAppController::class, 'verifyPasswordOtp']);
Route::middleware('auth:sanctum')->post('/reset-password', [ApiAppController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->post('/change-password', [ApiAppController::class, 'changePassword']);

Route::post('/company/register', [CompanyController::class, 'register']);
Route::post('/company/login', [CompanyController::class, 'login']);
Route::middleware('auth:sanctum')->get('/company/data', [CompanyController::class, 'getCompanyData']);
Route::post('/taakebs', [CompanyController::class, 'addTaakeb'])->middleware('auth:sanctum');
Route::get('/taakebs', [CompanyController::class, 'getTaakebs'])->middleware('auth:sanctum');
Route::get('/taakeb/{id}', [CompanyController::class, 'getTaakeb'])->middleware('auth:sanctum');
Route::get('/customers-booking-panding', [ApiAppController::class, 'get_customers_booking_sedical_status']);

Route::post('/pubsub/gmail', [GmailPubSubController::class, 'handle']);
Route::post('/job-answers', [JobAnswerController::class, 'store'])->middleware('auth:sanctum');
Route::get('/job/questions/{id}', [JobAnswerController::class, 'getQuestions'])->name('job.questions');
Route::get('/job/questions-answers/{id}', [JobAnswerController::class, 'getQuestionsWithoutAnswers'])->middleware('auth:sanctum');
