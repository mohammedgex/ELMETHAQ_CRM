<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\ForeignController;
use App\Http\Controllers\EmbassyController;
use App\Http\Controllers\ExtractsController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\FlightBookingController;
use App\Http\Controllers\HotelBookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WorkerController;

Route::get('/', function () {
  return view('home');
})->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/visas', [VisaController::class, 'index'])->name('visas');
Route::get('/passport', [PassportController::class, 'index'])->name('passport');
Route::post('/passport', [PassportController::class, 'store'])->name('passport.store');

Route::get('/foreign', [ForeignController::class, 'index'])->name('foreign');
Route::post('/foreign', [ForeignController::class, 'store'])->name('foreign.store');

Route::get('/embassy', [EmbassyController::class, 'index'])->name('embassy');
Route::post('/embassy', [EmbassyController::class, 'store'])->name('embassy.store');

Route::get('/extracts', [ExtractsController::class, 'index'])->name('extracts');
Route::post('/extracts', [ExtractsController::class, 'store'])->name('extracts.store');

Route::get('/translation', [TranslationController::class, 'index'])->name('translation');
Route::post('/translation', [TranslationController::class, 'store'])->name('translation.store');

Route::get('/visa', [VisaController::class, 'index'])->name('visa');
Route::post('/visa', [VisaController::class, 'store'])->name('visa.store');

Route::get('/flight-booking', [FlightBookingController::class, 'showForm'])->name('flight.booking');
Route::post('/flight-booking', [FlightBookingController::class, 'submitForm'])->name('flight.booking.submit');

Route::get('/hotel-booking', [HotelBookingController::class, 'showForm'])->name('hotel.booking');
Route::post('/hotel-booking', [HotelBookingController::class, 'submitForm'])->name('hotel.booking.submit');

// مسارات مخصصة لمنصة إلحاق العمالة المصرية بالخارج
Route::get('/jobs', [\App\Http\Controllers\JobController::class, 'index'])->name('jobs');
Route::view('/register', 'register')->name('register');
Route::view('/companies', 'companies')->name('companies');
Route::view('/countries', 'countries')->name('countries');
Route::view('/tips', 'tips')->name('tips');

// داشبورد الأدمن
Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])
  ->name('admin.dashboard');

// صفحة تسجيل دخول الأدمن
Route::get('/admin/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.login.submit');

// تسجيل خروج الأدمن
Route::post('/admin/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

// صفحة إضافة فرصة عمل جديدة للإدمن
Route::get('/admin/jobs', [\App\Http\Controllers\JobController::class, 'create'])->name('admin.jobs');

// استقبال طلبات التقديم على الوظائف
Route::post('/jobs/apply', [\App\Http\Controllers\JobController::class, 'apply'])->name('jobs.apply');

// لوحة تحكم فرص العمل للإدمن
Route::get('/admin/jobs/list', [\App\Http\Controllers\JobController::class, 'list'])->name('admin.jobs.list');
Route::post('/admin/jobs/store', [\App\Http\Controllers\JobController::class, 'store'])->name('admin.jobs.store');

// صفحة تفاصيل الوظيفة
Route::get('/jobs/{id}', [\App\Http\Controllers\JobController::class, 'show'])->name('jobs.show');

// صفحة حذف وظيفة للإدمن
Route::post('/admin/jobs/delete/{id}', [\App\Http\Controllers\JobController::class, 'delete'])->name('admin.jobs.delete');

// صفحة تعديل الوظيفة
Route::get('/admin/jobs/edit/{id}', [\App\Http\Controllers\JobController::class, 'edit'])->name('admin.jobs.edit');
Route::post('/admin/jobs/update/{id}', [\App\Http\Controllers\JobController::class, 'update'])->name('admin.jobs.update');

Route::post('/register/apply', [\App\Http\Controllers\RegisterController::class, 'apply'])->name('register.apply');

Route::get('/admin/registrations', [\App\Http\Controllers\RegisterController::class, 'list'])->name('admin.registrations');

Route::post('/companies/apply', [\App\Http\Controllers\CompanyController::class, 'apply'])->name('companies.apply');

Route::get('/admin/companies-requests', [App\Http\Controllers\CompanyController::class, 'list'])->name('admin.companies.requests');
Route::post('/admin/companies-requests/{index}/status', [App\Http\Controllers\CompanyController::class, 'updateStatus'])->name('admin.companies.requests.status');

Route::middleware(['admin'])->group(function () {
  Route::get('/admin/contacts', [App\Http\Controllers\AdminController::class, 'contacts'])->name('admin.contacts');
});

Route::view('/privacy', 'privacy')->name('privacy');

Route::view('/delete-account', 'delete-account')->name('delete.account');
Route::post('/register-apply', [WorkerController::class, 'store'])->name('register.apply');
