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
})->name(name: 'customer-groups');

// عرض الكفلاء
Route::get('/sponsers', function () {
    return view(view: 'sponsers'); // This loads resources/views/dashboard.blade.php
})->name(name: 'sponsers');

// عرض المناديب
Route::get('/Delegates-create', [DelegateController::class,'index'])->name(name: 'Delegates-create');

//تخزين المناديب
Route::post('/delegates', action: [DelegateController::class, 'store'])->name('delegates.store');

// عرض العملاء
Route::get('/worker-create', [CustomerController::class, 'index'])->name('customer.indes');

//اضافة عملاء

Route::post('/customer-add',[CustomerController::class, 'create'])->name(name: 'customer.create');