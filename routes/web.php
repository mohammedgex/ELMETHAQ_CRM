<?php

use App\Http\Controllers\ApiAppController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\EmbassyController;
use App\Http\Controllers\EvalutionController;
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
use App\Http\Controllers\GmailPubSubController;
use App\Http\Controllers\GoogleTranslateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JopController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/sync-gmail', [JopController::class, 'sync'])->name('sync');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth'] // أو أي Middleware آخر تريده
], function () {
    Route::get('/', function () {
        return redirect('admin/home');
    });
    Route::get('/user/create', [UserController::class, "show"])->name("user.index")->middleware("check.permission:users-manage");
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware("check.permission:users-manage");

    Route::get('/user/permissions/{id}', [PermissionsController::class, 'permissions'])->name('user.permissions')->middleware("check.permission:users-manage");
    Route::post('/user/permissions/{userId}', [PermissionsController::class, 'edit'])->name('permissions.edit')->middleware("check.permission:users-manage");

    Route::get('/company', [CompanySettingController::class, 'index'])->name('company.index')->middleware("check.permission:company-settings");
    Route::post('/company/update', [CompanySettingController::class, 'update'])->name('company.update')->middleware("check.permission:company-settings");

    Route::get('/send-api/{id}', [JopController::class, 'net'])->name('net');

    Route::get('/vissa/{id}', [ReportsController::class, 'print_visaEntriy'])->name('print_visaEntriy');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware("check.permission:dashboard-access");
    Route::get('/leads-customers', [LeadsCustomersController::class, 'index'])->name('leads-customers.index')->middleware("check.permission:leads-customers-show");
    Route::post('/leads-customers', [LeadsCustomersController::class, 'create'])->name('leads-customers.create')->middleware("check.permission:leads-customers-show");
    Route::get('/leads-show/{id}', [LeadsCustomersController::class, 'show'])->name('leads-customers.show')->middleware("check.permission:leads-customers-show");
    Route::get('/leads-edit/{id}', [LeadsCustomersController::class, 'update'])->name('leads-customers.update')->middleware("check.permission:leads-customers-show");
    Route::post('/leads-edit/{id}', [LeadsCustomersController::class, 'edit'])->name('leads-customers.edit')->middleware("check.permission:leads-customers-show");
    Route::delete('/leads-delete/{id}', [LeadsCustomersController::class, 'delete'])->name('leads-customers.delete')->middleware("check.permission:leads-customers-show");
    Route::get('/leads-search', [LeadsCustomersController::class, 'search'])->name('leads-customers.search');

    Route::get('/users', [UserController::class, 'index'])->name('users')->middleware("check.permission:users-manage");

    // عرض المهام
    Route::get('/user-tasks', [TaskController::class, 'index'])->name('user-tasks.index')->middleware("check.permission:tasks-access");
    Route::get('/user-tasks/done/{id}', [TaskController::class, 'done'])->name('user-tasks.done')->middleware("check.permission:tasks-access");
    Route::post('/user-tasks', [TaskController::class, 'create'])->name('user-tasks.create')->middleware("check.permission:tasks-access");

    // عرض أنواع التأشيرات
    Route::get('/visa-type-view/{id?}', [VisaTypeController::class, 'index'])->name('visa-type.index')->middleware("check.permission:visa-type-create");
    Route::post('/visa-type-view', [VisaTypeController::class, 'create'])->name('visa-type.create')->middleware("check.permission:visa-type-create");
    Route::post('/visa-type-view/edit/{id}', [VisaTypeController::class, 'edit'])->name('visa-type.edit')->middleware("check.permission:visa-type-create");
    Route::delete('/visa-type-view/{id}', [VisaTypeController::class, 'delete'])->name('visa-type.delete')->middleware("check.permission:visa-type-create");

    // عرض مدة التأشيرات
    Route::get('/visa-professions/{visa_id}/{id?}', [VisaProfessionsController::class, 'index'])->name('visa-profession.index')->middleware("check.permission:visa-type-create");
    Route::post('/visa-professions/{visa_id}', [VisaProfessionsController::class, 'create'])->name('visa-profession.create')->middleware("check.permission:visa-type-create");
    Route::post('/visa-professions/edit/{id}', [VisaProfessionsController::class, 'edit'])->name('visa-profession.edit')->middleware("check.permission:visa-type-create");
    Route::delete('/visa-professions/{id}', [VisaProfessionsController::class, 'delete'])->name('visa-profession.delete')->middleware("check.permission:visa-type-create");

    // عرض الوظائف
    Route::get('/job-type-view/{id?}', [JobController::class, 'index'])->name('job-type.index')->middleware("check.permission:job-create");
    Route::post('/job-type-view', [JobController::class, 'create'])->name('job-type.create')->middleware("check.permission:job-create");
    Route::post('/job-type-view/edit/{id}', [JobController::class, 'edit'])->name('job-type.edit')->middleware("check.permission:job-create");
    Route::delete('/job-type-view/{id}', [JobController::class, 'delete'])->name('job-type.delete')->middleware("check.permission:job-create");

    // عرض القنصلية
    Route::get('/embassy-view/{id?}', [EmbassyController::class, 'index'])->name('embassy.index')->middleware("check.permission:embassy-create");
    Route::post('/embassy-view', [EmbassyController::class, 'create'])->name('embassy.create')->middleware("check.permission:embassy-create");
    Route::post('/embassy-view/edit/{id}', [EmbassyController::class, 'edit'])->name('embassy.edit')->middleware("check.permission:embassy-create");
    Route::delete('/embassy-view/{id}', [EmbassyController::class, 'delete'])->name('embassy.delete')->middleware("check.permission:embassy-create");

    // عرض التقييمات
    Route::get('/evaluation-view/{id?}', [EvalutionController::class, 'index'])->name('evaluation.index');
    Route::post('/evaluation-view', [EvalutionController::class, 'create'])->name('evaluation.create');
    Route::post('/evaluation-view/edit/{id}', [EvalutionController::class, 'edit'])->name('evaluation.edit');
    Route::delete('/evaluation-view/{id}', [EvalutionController::class, 'delete'])->name('evaluation.delete');

    //  عرض انواع المعاملات المالية
    Route::get('/payment-type-view/{id?}', [PaymentTitleController::class, 'index'])->name('payment-type.index')->middleware("check.permission:payment-create");
    Route::post('/payment-type-view', [PaymentTitleController::class, 'create'])->name('payment-type.create')->middleware("check.permission:payment-create");
    Route::post('/payment-type-view/edit/{id}', [PaymentTitleController::class, 'edit'])->name('payment-type.edit')->middleware("check.permission:payment-create");
    Route::delete('/payment-type-view/{id}', [PaymentTitleController::class, 'delete'])->name('payment-type.delete')->middleware("check.permission:payment-create");

    // عرض انواع المستندات
    Route::get('/document-type-view/{id?}', [DocumentTypeController::class, 'index'])->name('document-type.index')->middleware("check.permission:file-create");
    Route::post('/document-type-view', [DocumentTypeController::class, 'create'])->name('document-type.create')->middleware("check.permission:file-create");
    Route::post('/document-type-view/edit/{id}', [DocumentTypeController::class, 'edit'])->name('document-type.edit')->middleware("check.permission:file-create");
    Route::delete('/document-type-view/{id}', [DocumentTypeController::class, 'delete'])->name('document-type.delete')->middleware("check.permission:file-create");
    Route::get('/send-file/accept/{id}', [FileTitleController::class, 'accept'])->name('document-type.accept');
    Route::get('/send-file/reject/{id}', [FileTitleController::class, 'reject'])->name('document-type.reject');


    // عرض الكفلاء
    Route::get('/sponsor-view/{id?}', [SponserController::class, 'index'])->name('sponsor.index')->middleware("check.permission:sponser-create");
    Route::post('/sponsor-view', [SponserController::class, 'create'])->name('sponsor.create')->middleware("check.permission:sponser-create");
    Route::post('/sponsor-view/edit/{id}', [SponserController::class, 'edit'])->name('sponsor.edit')->middleware("check.permission:sponser-create");
    Route::delete('/sponsor-view/{id}', [SponserController::class, 'delete'])->name('sponsor.delete')->middleware("check.permission:sponser-create");

    // عرض مجموعات
    Route::get('/customer-groups/{id?}', [CustomerGroupController::class, 'index'])->name('customer-groups.index')->middleware("check.permission:group-create");
    Route::post('/customer-groups', [CustomerGroupController::class, 'create'])->name('customer-groups.create')->middleware("check.permission:group-create");
    Route::post('/customer-groups/edit/{id}', [CustomerGroupController::class, 'edit'])->name('customer-groups.edit')->middleware("check.permission:group-create");;
    Route::delete('/customer-groups/{id}', [CustomerGroupController::class, 'delete'])->name('customer-groups.delete')->middleware("check.permission:group-create");;
    Route::get('/groups/{group}/customers/{customer}/remove', [CustomerGroupController::class, 'removeFromGroup'])->name('groups.removeCustomer');


    // المناديب
    Route::get('/Delegates-create/{id?}', [DelegateController::class, 'index'])->name('Delegates.create')->middleware("check.permission:delegate-create");
    Route::post('/delegates',  [DelegateController::class, 'store'])->name('delegates.store')->middleware("check.permission:delegate-create");
    Route::post('/delegates/edit/{id}',  [DelegateController::class, 'edit'])->name('delegates.edit')->middleware("check.permission:delegate-create");
    Route::delete('/Delegates-delete/{id}', [DelegateController::class, 'delete'])->name('Delegates.delete')->middleware("check.permission:delegate-create");

    // عرض العملاء
    Route::get('/customers',  [CustomerController::class, 'index'])->name('customer.indes')->middleware("check.permission:customers-show");
    Route::get('/customer-create/{id?}', [CustomerController::class, 'add'])->name('customer.add')->middleware("check.permission:create-customer");
    Route::post('/customer-basicDetails', [CustomerController::class, 'basicDetails'])->name('customer.basicDetails')->middleware("check.permission:create-customer");
    Route::post('/customer-editBasicDetails/{id}', [CustomerController::class, 'editBasicDetails'])->name('customer.editBasicDetails')->middleware("check.permission:create-customer");
    Route::post('/customer-mrz/{id}', [CustomerController::class, 'mrz'])->name('customer.mrz')->middleware("check.permission:create-customer");
    Route::post('/customer-attachments/{id}', [CustomerController::class, 'attachments'])->name('customer.attachments')->middleware("check.permission:create-customer");
    Route::prefix('customers')->group(function () {
        Route::post('{id}/archive', [CustomerController::class, 'archive'])->name('customers.archive');
        Route::post('{id}/unarchive', [CustomerController::class, 'unarchive'])->name('customers.unarchive');
    });
    Route::get('customers/archived', [CustomerController::class, 'archived'])->name('customers.archived')->middleware("check.permission:archived-customers");


    Route::get('/check-medical-status/{token}', [ApiAppController::class, 'checkMedicalStatus'])->name('check.medical.status');

    Route::get('/show-attachments/{id}', [FileTitleController::class, 'showedit'])->name('attachments.show');
    Route::post('/edit-attachments/{id}', [FileTitleController::class, 'updateAttachment'])->name('attachments.edit');
    Route::get('/to-attachments/{id}', [FileTitleController::class, 'toAttach'])->name('attachments.toAttach');

    Route::get('/delete-attachments/{id}', [FileTitleController::class, 'delete'])->name('attachments.delete');
    Route::post('/customer-payments/{id}', [CustomerController::class, 'payments'])->name('customer.payments');
    Route::post('/customer-history/{id}', [CustomerController::class, 'history'])->name('customer.history');
    Route::get('/customer-show/{id}', [CustomerController::class, 'show'])->name('customer.show')->middleware("check.permission:show-customer");
    Route::post('/customer-search', [CustomerController::class, 'search'])->name('customer.search');
    Route::post('/consulate-search', [CustomerController::class, 'searchConsulate'])->name('consulate.search');
    Route::post('/customer-multi_Search', [CustomerController::class, 'multi_Search'])->name('customer.multi_search');
    Route::post('/lead-to-customer', [LeadsCustomersController::class, 'leadToCustomer'])->name('customer.leadToCustomer');
    Route::get('/customer-consulate', [CustomerController::class, 'consulate'])->name('customer.consulate');
    Route::post('/customer-consulate/fillter', [CustomerController::class, 'filterConsulate'])->name('consulate.filter');
    Route::post('/bag-and-group/fillter', [CustomerController::class, 'filterGroupAndBag'])->name('filterGroupAndBag');
    // Route::post('/customers/filter', [CustomerController::class, 'filter'])->name('customers.filter');
    Route::get('/customers/block/{id}', [BlackListController::class, 'block'])->name('customers.block');
    Route::get('/customers/unblock/{id}', [BlackListController::class, 'unBlock'])->name('customers.unblock');


    Route::get('/template', [TemplateController::class, 'index'])->name('template.index')->middleware("check.permission:message-create");
    Route::post('/template', [TemplateController::class, 'create'])->name('template.create')->middleware("check.permission:message-create");
    Route::delete('/template/{id}', [TemplateController::class, 'delete'])->name('template.delete')->middleware("check.permission:message-create");


    Route::get('/customers/group/{group_id}', [CustomerController::class, 'customerGroup'])->name('group.customer')->middleware("check.permission:show-group-customers");
    Route::post('/group/{group_id}', [CustomerController::class, 'addToGroup'])->name('group.addToGroup');

    // عرض الحقائب
    Route::get('/bags-view/{id?}', [BagController::class, 'index'])->name('bags.index')->middleware("check.permission:bag-create");
    Route::post('/bags-view', [BagController::class, 'create'])->name('bags.create')->middleware("check.permission:bag-create");
    Route::post('/bags-view/edit/{id}', [BagController::class, 'edit'])->name('bags.edit')->middleware("check.permission:bag-create");
    Route::delete('/bags-view/{id}', [BagController::class, 'delete'])->name('bags.delete')->middleware("check.permission:bag-create");
    Route::get('/bags-view/customers/{bag_id}', [BagController::class, 'bagCustomers'])->name('bags.customers')->middleware("check.permission:bag-create");


    Route::delete('/history-delete/{id}', [HistoryController::class, 'delete'])->name('history.delete');

    Route::delete('/payment-delete/{id}', [PaymentsController::class, 'delete'])->name('payment.delete');

    Route::get('/export-delegates-xlsx/{id}', [DelegateController::class, 'exportDelegates'])->name('export.delegates.xlsx');

    Route::get('/export-delegates-pdf/{id}', [DelegateController::class, 'downloadPdf'])->name('export.delegates.pdf');

    Route::get('/export-customers-xlsx', [CustomerController::class, 'exportCustomers'])->name('export.customers.xlsx');

    Route::get('/clients/{client}/attachments/print', [CustomerController::class, 'printAttachments'])->name('clients.print.attachments');
    Route::get('/clients/{client}/payments/print', [CustomerController::class, 'printPayments'])->name('clients.print.payments');


    Route::get('/clients/{client}/attachments/print', [CustomerController::class, 'printAttachments'])->name('clients.print.attachments');
    Route::get('/clients/{client}/payments/print', [CustomerController::class, 'printPayments'])->name('clients.print.payments');

    Route::prefix('tests')->name('test.')->group(function () {
        // صفحة عرض الاختبارات + نموذج الإضافة أو التعديل
        Route::get('/{id?}', [TestController::class, 'index'])->name('index')->middleware("check.permission:test-create");
        // إضافة اختبار جديد
        Route::post('/create', [TestController::class, 'store'])->name('create')->middleware("check.permission:test-create");
        // حذف اختبار
        Route::delete('/delete/{id}', [TestController::class, 'destroy'])->name('delete')->middleware("check.permission:test-create");
        Route::get('/{test_id}/leads/', [TestController::class, 'customerTest'])->name('leads')->middleware("check.permission:test-create");
    });

    // تنفيذ الإضافة
    Route::post('/tests/add-customer', [TestController::class, 'addCustomers'])->name('tests.addCustomer');
    Route::delete('/tests/{test}/remove-lead/{lead}', [TestController::class, 'removeLead'])->name('tests.removeLead');
    Route::get('/tests/{test}/show-evaluations/{lead}', [TestController::class, 'show_evaluation'])->name('tests.showEvaluation');
    Route::post('/evaluations/create', [TestController::class, 'createEvaluation'])->name('evaluations.create');
    Route::post('/evaluations/{id}', [TestController::class, 'storeEvaluation'])->name('evaluations.store');
    Route::get('/groups-visa/{visaid}', [HomeController::class, 'groupVisa'])->name('groups.visa')->middleware("check.permission:visa-type-create");

    Route::get('/taakebs', [CompanyController::class, 'index'])->name('taakebs.index');
    Route::put('/taakebs/{id}/approve', [CompanyController::class, 'approve'])->name('taakebs.approve');
    Route::put('/taakebs/{id}/reject', [CompanyController::class, 'reject'])->name('taakebs.reject');
    Route::get('/document-requests', [FileTitleController::class, 'index'])->name('document-requests.index');
    Route::get('/nomination_card/{id}', [ReportsController::class, "nomination_card"])->name('reports.nomination_card');
    Route::get('/reports/show/{id}', [ReportsController::class, 'showReportes'])->name('reports.show');
    Route::get('/e_number_barcode/{id}', [ReportsController::class, 'E_number_barcode'])->name('reports.e_number_barcode');
    Route::get('/visa-number-barcode/{id}', [ReportsController::class, 'visaNumberBarcode'])->name('reports.visaNumberBarcode');
    Route::get('/transaction_statement_cairo/{id}', [ReportsController::class, 'transaction_statement_cairo'])->name('reports.transaction_statement_cairo');
    Route::get('/transaction_statement_suez/{id}', [ReportsController::class, 'transaction_statement_suez'])->name('reports.transaction_statement_suez');
    Route::get('/reset-password-lead/{id}', [LeadsCustomersController::class, 'resetPassword'])->name('reset.password.lead');
    Route::get('/chart/potential', [HomeController::class, 'potentialChartData'])
        ->name('chart.potential');
    Route::get('/chart/visa-customers', [HomeController::class, 'visaCustomersChartData']);
    Route::get('/chart/test-evaluations/{testId}', [HomeController::class, 'testEvaluationStats'])->name("test-evaluations");

    // صفحة الفلتر
    Route::get('/customers/filter', [CustomerController::class, 'fillterdeep'])->name('customers.filter');
    Route::get('/visas-by-filters', [CustomerController::class, 'getVisas'])->name('admin.visas.byFilters');
    Route::get('/groups/by-visas', [CustomerController::class, 'getGroupsByVisas'])->name('admin.groups.byVisas');
    Route::post('/customers/filter/data', [CustomerController::class, 'filterCustomers'])->name('customers.filter.data');
    Route::get('/login-fail', [LeadsCustomersController::class, 'loginFail'])->name('leads-customers.loginFail')->middleware("check.permission:loginFail-access");
});
Route::get('/google/auth', [GoogleTranslateController::class, 'redirectToGoogle']);
Route::get('/google/oauth2callback', [GoogleTranslateController::class, 'handleCallback']);
Route::get('/send-test-email', [GoogleTranslateController::class, 'sendTestEmail']);
Route::get('/google/callback', [GmailPubSubController::class, 'handleCallback']);
