<?php

use App\Http\Controllers\BagController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\EmbassyController;
use App\Http\Controllers\EvalutionController;
use App\Http\Controllers\GoogleTranslateController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LeadsCustomersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PaymentTitleController;
use App\Http\Controllers\SponserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisaProfessionsController;
use App\Http\Controllers\VisaTypeController;
use App\Http\Controllers\FileTitleController;
use App\Http\Controllers\JopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

// Route::get('/workers', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/workers', function () {
    return view('workers'); // This loads resources/views/dashboard.blade.php
})->name('workers');


Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth'] // أو أي Middleware آخر تريده
], function () {
    Route::get('/bulk-sms-view', action: function () {
        return view('bulk-sms');
    })->name('bulk-sms.index');
    

    Route::get('/', function () {
        return redirect('admin/home');
    });
    Route::get('/send-api/{id}', [JopController::class, 'net'])->name('net');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/leads-customers', [LeadsCustomersController::class, 'index'])->name('leads-customers.index');
    Route::post('/leads-customers', [LeadsCustomersController::class, 'create'])->name('leads-customers.create');
    Route::get('/leads-show/{id}', [LeadsCustomersController::class, 'show'])->name('leads-customers.show');
    Route::get('/leads-edit/{id}', [LeadsCustomersController::class, 'update'])->name('leads-customers.update');
    Route::post('/leads-edit/{id}', [LeadsCustomersController::class, 'edit'])->name('leads-customers.edit');
    Route::delete('/leads-delete/{id}', [LeadsCustomersController::class, 'delete'])->name('leads-customers.delete');


    Route::get('/users', [UserController::class, 'index'])->name('users');

    // عرض المهام
    Route::get('/user-tasks', [TaskController::class, 'index'])->name('user-tasks.index');
    Route::get('/user-tasks/done/{id}', [TaskController::class, 'done'])->name('user-tasks.done');
    Route::post('/user-tasks', [TaskController::class, 'create'])->name('user-tasks.create');

    // عرض أنواع التأشيرات
    Route::get('/visa-type-view/{id?}', [VisaTypeController::class, 'index'])->name('visa-type.index');
    Route::post('/visa-type-view', [VisaTypeController::class, 'create'])->name('visa-type.create');
    Route::post('/visa-type-view/edit/{id}', [VisaTypeController::class, 'edit'])->name('visa-type.edit');
    Route::delete('/visa-type-view/{id}', [VisaTypeController::class, 'delete'])->name('visa-type.delete');

    // عرض مدة التأشيرات
    Route::get('/visa-professions/{visa_id}/{id?}', [VisaProfessionsController::class, 'index'])->name('visa-profession.index');
    Route::post('/visa-professions/{visa_id}', [VisaProfessionsController::class, 'create'])->name('visa-profession.create');
    Route::post('/visa-professions/edit/{id}', [VisaProfessionsController::class, 'edit'])->name('visa-profession.edit');
    Route::delete('/visa-professions/{id}', [VisaProfessionsController::class, 'delete'])->name('visa-profession.delete');

    // عرض الوظائف
    Route::get('/job-type-view/{id?}', [JobController::class, 'index'])->name('job-type.index');
    Route::post('/job-type-view', [JobController::class, 'create'])->name('job-type.create');
    Route::post('/job-type-view/edit/{id}', [JobController::class, 'edit'])->name('job-type.edit');
    Route::delete('/job-type-view/{id}', [JobController::class, 'delete'])->name('job-type.delete');

    // عرض القنصلية
    Route::get('/embassy-view/{id?}', [EmbassyController::class, 'index'])->name('embassy.index');
    Route::post('/embassy-view', [EmbassyController::class, 'create'])->name('embassy.create');
    Route::post('/embassy-view/edit/{id}', [EmbassyController::class, 'edit'])->name('embassy.edit');
    Route::delete('/embassy-view/{id}', [EmbassyController::class, 'delete'])->name('embassy.delete');

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
    Route::get('/send-file/accept/{id}', [FileTitleController::class, 'accept'])->name('document-type.accept');
    Route::get('/send-file/reject/{id}', [FileTitleController::class, 'reject'])->name('document-type.reject');


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
    Route::get('/customers',  [CustomerController::class, 'index'])->name('customer.indes');
    Route::get('/customer-create/{id?}', [CustomerController::class, 'add'])->name('customer.add');
    Route::post('/customer-basicDetails', [CustomerController::class, 'basicDetails'])->name('customer.basicDetails');
    Route::post('/customer-editBasicDetails/{id}', [CustomerController::class, 'editBasicDetails'])->name('customer.editBasicDetails');
    Route::post('/customer-mrz/{id}', [CustomerController::class, 'mrz'])->name('customer.mrz');
    Route::post('/customer-attachments/{id}', [CustomerController::class, 'attachments'])->name('customer.attachments');

    Route::get('/show-attachments/{id}', [FileTitleController::class, 'showedit'])->name('attachments.show');
    Route::post('/edit-attachments/{id}', [FileTitleController::class, 'updateAttachment'])->name('attachments.edit');
    Route::get('/to-attachments/{id}', [FileTitleController::class, 'toAttach'])->name('attachments.toAttach');

    Route::get('/delete-attachments/{id}', [FileTitleController::class, 'delete'])->name('attachments.delete');
    Route::post('/customer-payments/{id}', [CustomerController::class, 'payments'])->name('customer.payments');
    Route::post('/customer-history/{id}', [CustomerController::class, 'history'])->name('customer.history');
    Route::get('/customer-show/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::post('/customer-search', [CustomerController::class, 'search'])->name('customer.search');
    Route::post('/consulate-search', [CustomerController::class, 'searchConsulate'])->name('consulate.search');
    Route::post('/customer-multi_Search', [CustomerController::class, 'multi_Search'])->name('customer.multi_search');
    Route::get('/lead-to-customer/{id}', [LeadsCustomersController::class, 'leadToCustomer'])->name('customer.leadToCustomer');
    Route::get('/customer-consulate', [CustomerController::class, 'consulate'])->name('customer.consulate');
    Route::post('/customer-consulate/fillter', [GoogleTranslateController::class, 'filterConsulate'])->name('consulate.filter');
    Route::post('/customers/filter', [CustomerController::class, 'filter'])->name('customers.filter');
    Route::get('/customers/block/{id}', [BlackListController::class, 'block'])->name('customers.block');
    Route::get('/customers/unblock/{id}', [BlackListController::class, 'unBlock'])->name('customers.unblock');


    Route::get('/customers/group/{group_id}', [CustomerController::class, 'customerGroup'])->name('group.customer');
    Route::post('/group/{group_id}', [CustomerController::class, 'addToGroup'])->name('group.addToGroup');

    // عرض الحقائب
    Route::get('/bags-view/{id?}', [BagController::class, 'index'])->name('bags.index');
    Route::post('/bags-view', [BagController::class, 'create'])->name('bags.create');
    Route::post('/bags-view/edit/{id}', [BagController::class, 'edit'])->name('bags.edit');
    Route::delete('/bags-view/{id}', [BagController::class, 'delete'])->name('bags.delete');
    Route::get('/bags-view/customers/{bag_id}', [BagController::class, 'bagCustomers'])->name('bags.customers');



    Route::delete('/history-delete/{id}', [HistoryController::class, 'delete'])->name('history.delete');

    Route::delete('/payment-delete/{id}', [PaymentsController::class, 'delete'])->name('payment.delete');

    Route::get('/export-delegates-xlsx/{id}', [DelegateController::class, 'exportDelegates'])->name('export.delegates.xlsx');

    Route::get('/export-delegates-pdf/{id}', [DelegateController::class, 'downloadPdf'])->name('export.delegates.pdf');

    Route::get('/export-customers-xlsx', [CustomerController::class, 'exportCustomers'])->name('export.customers.xlsx');

    Route::get('/clients/{client}/attachments/print', [CustomerController::class, 'printAttachments'])->name('clients.print.attachments');
    Route::get('/clients/{client}/payments/print', [CustomerController::class, 'printPayments'])->name('clients.print.payments');


    Route::get('/clients/{client}/attachments/print', [CustomerController::class, 'printAttachments'])->name('clients.print.attachments');
    Route::get('/clients/{client}/payments/print', [CustomerController::class, 'printPayments'])->name('clients.print.payments');

    
});
