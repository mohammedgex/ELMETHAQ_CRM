<?php

namespace App\Providers;

use App\Models\CompanySetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // if (env(key: 'APP_ENV') !== 'local') {
        //     URL::forceScheme(scheme: 'https');
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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

            // العملاء المحتملون
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'leads-customers-show')) {
                $existingMenu[] = [
                    'text' => 'العملاء المحتملون',
                    'url' => 'admin/leads-customers',
                    'icon' => 'fas fa-hourglass-half',
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
                ['permission' => 'visa-type-create', 'text' => 'تعريف التأشيرات', 'url' => 'admin/visa-type-view', 'icon' => 'fab fa-cc-visa'],
                ['permission' => 'embassy-create', 'text' => 'تعريف القنصلية', 'url' => 'admin/embassy-view', 'icon' => 'fas fa-landmark'],
                ['permission' => 'sponser-create', 'text' => 'تعريف الكفيل', 'url' => 'admin/sponsor-view', 'icon' => 'fas fa-user-tie'],
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
                ['permission' => 'delegate-create', 'text' => 'تعريف المناديب', 'url' => 'admin/Delegates-create', 'icon' => 'fas fa-user-tag'],
                ['permission' => 'bag-create', 'text' => 'تعريف الحقائب', 'url' => 'admin/bags-view', 'icon' => 'fas fa-user-tag'],
                ['permission' => 'group-create', 'text' => 'تعريف المجموعات', 'url' => 'admin/customer-groups', 'icon' => 'fas fa-layer-group'],
                ['permission' => 'file-create', 'text' => 'تعريف المستندات', 'url' => 'admin/document-type-view', 'icon' => 'fas fa-file-alt'],
                ['permission' => 'payment-create', 'text' => 'تعريف المعاملات المالية', 'url' => 'admin/payment-type-view', 'icon' => 'fas fa-money-check-alt'],
                ['permission' => 'message-create', 'text' => 'تعريف قوالب الرسائل', 'url' => 'admin/template', 'icon' => 'fas fa-user-tag'],
                ['permission' => 'test-create', 'text' => 'الاختبارات', 'url' => 'admin/tests', 'icon' => 'fas fa-vials'],
                ['permission' => 'job-create', 'text' => 'تعريف الوظائف', 'url' => 'admin/job-type-view', 'icon' => 'fas fa-briefcase'],
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

            // ارسال رسائل
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'bulk-sms-access')) {
                $existingMenu[] = [
                    'text' => 'ارسال رسائل',
                    'url' => 'admin/bulk-sms-view',
                    'icon' => 'fas fa-sms',
                ];
            }

            // المهام
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'tasks-access')) {
                $existingMenu[] = [
                    'text' => 'المهام',
                    'url' => 'admin/user-tasks',
                    'icon' => 'fas fa-tasks',
                ];
            }

            // قسم الإعدادات
            $existingMenu[] = ['header' => 'الاعدادات'];

            // المستخدم
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'users-manage')) {
                $existingMenu[] = [
                    'text' => 'المستخدم',
                    'url' => 'admin/users',
                    'icon' => 'fas fa-user-cog',
                ];
            }

            // اعدادات الشركة
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'company-settings')) {
                $existingMenu[] = [
                    'text' => 'اعدادات الشركة',
                    'url' => 'admin/company',
                    'icon' => 'fas fa-user-cog',
                ];
            }

            // تحميل القائمة النهائية
            Config::set('adminlte.menu', $existingMenu);
            $menuUpdated = true;
        });
    }
}
