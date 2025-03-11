<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\EvalutionController;
use App\Http\Controllers\PaymentTitleController;
use App\Http\Controllers\SponserController;
use App\Models\Delegate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/workers', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/workers', function () {
    return view('workers'); // This loads resources/views/dashboard.blade.php
})->name('workers');

Route::get('/users', function () {
    return view('users'); // This loads resources/views/dashboard.blade.php
})->name('users');

Route::get('/users', function () {
    return view('users'); // This loads resources/views/dashboard.blade.php
})->name('users');






// عرض أنواع التأشيرات
Route::get('/visa-type-view', action: function () {
    return view(view: 'visa-type'); // This loads resources/views/dashboard.blade.php
})->name(name: 'visa-type.index');

// عرض مدة التأشيرات
Route::get('/visa-peroid-view', action: function () {
    return view(view: 'visa-peroid'); // This loads resources/views/dashboard.blade.php
})->name(name: 'visa-peroid.index');

// عرض الوظائف
Route::get(uri: '/job-type-view', action: function () {
    return view(view: 'job-type'); // This loads resources/views/dashboard.blade.php
})->name(name: 'job-type.index');

// عرض القنصلية
Route::get(uri: '/embassy-view', action: function () {
    return view(view: 'embassy'); // This loads resources/views/dashboard.blade.php
})->name(name: 'embassy.index');

// عرض الرسائل
Route::get(uri: '/bulk-sms-view', action: function () {
    return view(view: 'bulk-sms');
})->name(name: 'bulk-sms.index');

// عرض التقييمات
Route::get('/evaluation-view/{id?}', [EvalutionController::class, 'index'])->name('evaluation.index');
Route::post('/evaluation-view', [EvalutionController::class, 'create'])->name('evaluation.create');
Route::post('/evaluation-view/edit/{id}', [EvalutionController::class, 'edit'])->name('evaluation.edit');
Route::delete('/evaluation-view/{id}', [EvalutionController::class, 'delete'])->name('evaluation.delete');

//  عرض انواع المعاملات المالية
Route::get('/payment-type-view/{id?}', [PaymentTitleController::class, 'index'])->name('payment-type.index');
Route::post('/payment-type-view', [PaymentTitleController::class, 'create'])->name('payment-type.create');
Route::post('/payment-type-view/edit/{id}', [PaymentTitleController::class, 'edit'])->name('payment-type.edit');
Route::delete('/payment-type-view/{id}', [PaymentTitleController::class, 'delete'])->name('payment-type.delete');

// عرض انواع المستندات
Route::get('/document-type-view/{id?}', [DocumentTypeController::class, 'index'])->name('document-type.index');
Route::post('/document-type-view', [DocumentTypeController::class, 'create'])->name('document-type.create');
Route::post('/document-type-view/edit/{id}', [DocumentTypeController::class, 'edit'])->name('document-type.edit');
Route::delete('/document-type-view/{id}', [DocumentTypeController::class, 'delete'])->name('document-type.delete');


// عرض الكفلاء
Route::get('/sponsor-view/{id?}', [SponserController::class, 'index'])->name('sponsor.index');
Route::post('/sponsor-view', [SponserController::class, 'create'])->name('sponsor.create');
Route::post('/sponsor-view/edit/{id}', [SponserController::class, 'edit'])->name('sponsor.edit');
Route::delete('/sponsor-view/{id}', [SponserController::class, 'delete'])->name('sponsor.delete');

// عرض مجموعات
Route::get('/customer-groups/{id?}', [CustomerGroupController::class, 'index'])->name('customer-groups.index');
Route::post('/customer-groups', [CustomerGroupController::class, 'create'])->name('customer-groups.create');
Route::post('/customer-groups/edit/{id}', [CustomerGroupController::class, 'edit'])->name('customer-groups.edit');
Route::delete('/customer-groups/{id}', [CustomerGroupController::class, 'delete'])->name('customer-groups.delete');

// المناديب
Route::get('/Delegates-create/{id?}', [DelegateController::class, 'index'])->name('Delegates.create');
Route::post('/delegates',  [DelegateController::class, 'store'])->name('delegates.store');
Route::post('/delegates/edit/{id}',  [DelegateController::class, 'edit'])->name('delegates.edit');
Route::delete('/Delegates-delete/{id}', [DelegateController::class, 'delete'])->name('Delegates.delete');

// عرض العملاء
Route::get('/worker-create', [CustomerController::class, 'index'])->name('customer.indes');

//اضافة عملاء

Route::post('/customer-add', [CustomerController::class, 'create'])->name(name: 'customer.create');


Route::get('/export-delegates', [DelegateController::class, 'exportDelegates'])->name('export.delegates');
