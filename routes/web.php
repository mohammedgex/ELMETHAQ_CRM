<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DelegateController;
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

// عرض مجموعات
Route::get('/customer-groups', function () {
    return view(view: 'groups'); // This loads resources/views/dashboard.blade.php
})->name(name: 'customer-groups.index');

// عرض الكفلاء
Route::get('/sponsor-view', function () {
    return view(view: 'sponsor'); // This loads resources/views/dashboard.blade.php
})->name(name: 'sponsor.index');

// عرض التقييمات
Route::get('/evaluation-view', action: function () {
    return view(view: 'evaluation'); // This loads resources/views/dashboard.blade.php
})->name(name: 'evaluation.index');

// عرض أنواع التأشيرات
Route::get('/visa-type-view', action: function () {
    return view(view: 'visa-type'); // This loads resources/views/dashboard.blade.php
})->name(name: 'visa-type.index');

// عرض مدة التأشيرات
Route::get('/visa-peroid-view', action: function () {
    return view(view: 'visa-peroid'); // This loads resources/views/dashboard.blade.php
})->name(name: 'visa-peroid.index');

// عرض انواع المستندات
Route::get('/document-type-view', action: function () {
    return view(view: 'document-type'); // This loads resources/views/dashboard.blade.php
})->name(name: 'document-type.index');

//  عرض انواع المعاملات المالية
Route::get(uri: '/payment-type-view', action: function () {
    return view(view: 'payment-type'); // This loads resources/views/dashboard.blade.php
})->name(name: 'payment-type.index');

// عرض الرسائل
Route::get(uri: '/bulk-sms-view', action: function () {
    return view(view: 'bulk-sms'); 
})->name(name: 'bulk-sms.index');

// المناديب
Route::get('/Delegates-create/{id?}', [DelegateController::class, 'index'])->name(name: 'Delegates.create');
Route::post('/delegates',  [DelegateController::class, 'store'])->name('delegates.store');
Route::post('/delegates/edit/{id}',  [DelegateController::class, 'edit'])->name('delegates.edit');
Route::delete('/Delegates-delete/{id}', [DelegateController::class, 'delete'])->name('Delegates.delete');

// عرض العملاء
Route::get('/worker-create', [CustomerController::class, 'index'])->name('customer.indes');

//اضافة عملاء

Route::post('/customer-add', [CustomerController::class, 'create'])->name(name: 'customer.create');
