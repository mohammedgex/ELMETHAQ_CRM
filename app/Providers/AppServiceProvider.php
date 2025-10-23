<?php

namespace App\Providers;

use App\Models\CompanySetting;
use App\Models\DocumentType as ModelsDocumentType;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // if (env(key: 'APP_ENV') === 'local') {
        //     URL::forceScheme(scheme: 'https');
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::bootstrap-4');
        Paginator::defaultSimpleView('pagination::simple-bootstrap-4');

        View::composer('*', function ($view) {
            $setting = CompanySetting::first();

            $logoImg = $setting && $setting->logo
                ? asset('storage/' . $setting->logo)
                : asset('logo.ico');

            $logoText = $setting && $setting->name
                ? $setting->name
                : 'اسم النظام';

            $view->with([
                'appLogoImg' => $logoImg,
                'appLogoText' => $logoText,
            ]);
        });
        View::composer('*', function ($view) {
            $setting = CompanySetting::first();

            $logo = $setting && $setting->logo
                ? asset('storage/' . $setting->logo)
                : asset('uploads/default.png');

            $view->with('appLogo', $logo);
        });

        View::composer('*', function ($view) {
            static $menuUpdated = false;
            if ($menuUpdated) return;

            $user = auth()->user();
            if (!$user) return;

            if (!$user->relationLoaded('permissions')) {
                $user->load('permissions');
            }

            $existingMenu = [];

            // القائمة الرئيسية الثابتة التي ستُبنى بناءً على الصلاحيات
            $existingMenu[] = [
                'type' => 'fullscreen-widget',
                'topnav_right' => true,
            ];

            // لوحة التحكم
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'dashboard-access')) {
                $existingMenu[] = [
                    'text' => 'لوحة التحكم',
                    'icon' => 'fas fa-tachometer-alt',
                    'url' => 'admin/home'
                ];
            }
            if ($user && ($user->role === 'admin' || $user->permissions->contains('permission', 'deep-search-access'))) {
                $existingMenu[] = [
                    'text' => 'البحث المتقدم',
                    'icon' => 'fas fa-search',
                    'url'  => 'admin/deep-search',
                ];
            }


            // العملاء المحتملون
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'leads-customers-show')) {
                $existingMenu[] = [
                    'text' => 'العملاء المحتملون',
                    'url' => 'admin/leads-customers',
                    'icon' => 'fas fa-hourglass-half',
                ];
            }
            // العملاء المحتملون
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'loginFail-access')) {
                $existingMenu[] = [
                    'text' => 'محاولات دخول فاشلة',
                    'url' => 'admin/login-fail',
                    'icon' => 'fas fa-user-secret',
                ];
            }
            $pendingCount = ModelsDocumentType::where('order_status', 'panding')->count();

            // العملاء المحتملون
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'requests-show')) {
                $existingMenu[] = [
                    'text'  => 'طلبات الملفات',
                    'url'   => 'admin/document-requests', // غيره حسب مسار صفحة الطلبات
                    'icon'  => 'fas fa-file-alt',
                    'label' => $pendingCount,
                    'label_color' => 'warning', // success, danger, info, primary...
                ];
            }

            // العملاء
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'customers-show')) {
                $existingMenu[] = [
                    'text' => 'العملاء',
                    'url' => 'admin/customers',
                    'icon' => 'fas fa-users',
                ];
            }

            // تعريفات التأشيرة (submenu)
            $visaMenu = [
                'text' => 'تعريفات التأشيرة',
                'icon' => 'fas fa-passport',
                'submenu' => [],
            ];

            $visaDefinitions = [
                [
                    'permission' => 'visa-type-create',
                    'text' => 'تعريف التأشيرات',
                    'url' => 'admin/visa-type-view',
                    'icon' => 'fas fa-passport' // أفضل من "fab fa-cc-visa" لأنها تعبر عن تأشيرة أو جواز سفر
                ],
                [
                    'permission' => 'embassy-create',
                    'text' => 'تعريف القنصلية',
                    'url' => 'admin/embassy-view',
                    'icon' => 'fas fa-landmark' // مبنى رسمي بعلم (رمز دبلوماسي أكثر تعبيرًا)
                ],
                [
                    'permission' => 'sponser-create',
                    'text' => 'تعريف الكفيل',
                    'url' => 'admin/sponsor-view',
                    'icon' => 'fas fa-user-shield' // كفيل = جهة مسؤولة أو داعمة
                ],
                [
                    'permission' => 'taakeb-show',
                    'text' => 'طلبات التعقيب',
                    'url' => 'admin/taakebs',
                    'icon' => 'fas fa-file' // كفيل = جهة مسؤولة أو داعمة
                ],
            ];

            foreach ($visaDefinitions as $item) {
                if ($user->role === 'admin' || $user->permissions->contains('permission', $item['permission'])) {
                    $visaMenu['submenu'][] = [
                        'text' => $item['text'],
                        'url' => $item['url'],
                        'icon' => $item['icon'],
                    ];
                }
            }

            if (!empty($visaMenu['submenu'])) {
                $existingMenu[] = $visaMenu;
            }

            // تعريفات العملاء (submenu)
            $customerMenu = [
                'text' => 'تعريفات العملاء',
                'icon' => 'fas fa-cogs',
                'submenu' => [],
            ];

            $customerDefinitions = [
                [
                    'permission' => 'delegate-create',
                    'text' => 'تعريف المناديب',
                    'url' => 'admin/Delegates-create',
                    'icon' => 'fas fa-user-tie' // مندوب = رجل أعمال
                ],
                [
                    'permission' => 'bag-create',
                    'text' => 'تعريف الحقائب',
                    'url' => 'admin/bags-view',
                    'icon' => 'fas fa-suitcase-rolling' // حقيبة سفر/عمل
                ],
                [
                    'permission' => 'group-create',
                    'text' => 'تعريف المجموعات',
                    'url' => 'admin/customer-groups',
                    'icon' => 'fas fa-users' // مجموعة أشخاص
                ],
                [
                    'permission' => 'file-create',
                    'text' => 'تعريف المستندات',
                    'url' => 'admin/document-type-view',
                    'icon' => 'fas fa-file-alt' // مستند نصي
                ],
                [
                    'permission' => 'payment-create',
                    'text' => 'تعريف المعاملات المالية',
                    'url' => 'admin/payment-type-view',
                    'icon' => 'fas fa-hand-holding-usd' // رمز مالي
                ],
                [
                    'permission' => 'message-create',
                    'text' => 'تعريف قوالب الرسائل',
                    'url' => 'admin/template',
                    'icon' => 'fas fa-envelope-open-text' // رسالة نصية مفتوحة
                ],
                [
                    'permission' => 'test-create',
                    'text' => 'الاختبارات',
                    'url' => 'admin/tests',
                    'icon' => 'fas fa-file-medical-alt' // اختبار/استبيان
                ],
                [
                    'permission' => 'job-create',
                    'text' => 'تعريف الوظائف',
                    'url' => 'admin/job-type-view',
                    'icon' => 'fas fa-briefcase' // حقيبة عمل
                ],
                [
                    'permission' => 'job-question-create',
                    'text' => 'تعريف اسئلة الوظائف',
                    'url' => 'admin/job-questions/store',
                    'icon' => 'fas fa-question-circle' // حقيبة عمل
                ],
            ];

            foreach ($customerDefinitions as $item) {
                if ($user->role === 'admin' || $user->permissions->contains('permission', $item['permission'])) {
                    $customerMenu['submenu'][] = [
                        'text' => $item['text'],
                        'url' => $item['url'],
                        'icon' => $item['icon'],
                    ];
                }
            }

            if (!empty($customerMenu['submenu'])) {
                $existingMenu[] = $customerMenu;
            }

            // قسم إضافي
            $existingMenu[] = ['header' => 'اضافي'];

            // المهام
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'tasks-access')) {
                $taskCount = $user->receivedTasks()->where('status', 'new')->count();
                $existingMenu[] = [
                    'text'  => 'المهام',
                    'url'   => 'admin/user-tasks',
                    'icon'  => 'fas fa-tasks',
                    'label' => $taskCount > 0 ? $taskCount : '',
                    'label_color' => 'warning', // warning = أصفر
                ];
            }


            // قسم الإعدادات
            $existingMenu[] = ['header' => 'الاعدادات'];

            // المستخدم
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'users-manage')) {
                $existingMenu[] = [
                    'text' => 'المستخدم',
                    'url' => 'admin/users',
                    'icon' => 'fas fa-users-cog',
                ];
            }

            // اعدادات الشركة
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'company-settings')) {
                $existingMenu[] = [
                    'text' => 'اعدادات الشركة',
                    'url' => 'admin/company',
                    'icon' => 'fas fa-building',
                ];
            }
            // اعدادات الشركة
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'archived-customers')) {
                $existingMenu[] = [
                    'text' => 'ارشيف العملاء',
                    'url' => 'admin/customers/archived',
                    'icon' => 'fas fa-archive',
                ];
            }

            // تحميل القائمة النهائية
            Config::set('adminlte.menu', $existingMenu);
            $menuUpdated = true;
        });
    }
}
