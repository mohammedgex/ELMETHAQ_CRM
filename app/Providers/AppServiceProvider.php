<?php

namespace App\Providers;

use App\Models\CompanySetting;
use App\Models\DocumentType as ModelsDocumentType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;


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
        // Composer 1: إعداد الشعارات (appLogoImg, appLogoText)
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

        // Composer 2: appLogo (يمكن دمجه لكن احتفظت به منفصلاً كما في كودك)
        View::composer('*', function ($view) {
            $setting = CompanySetting::first();

            $logo = $setting && $setting->logo
                ? asset('storage/' . $setting->logo)
                : asset('uploads/default.png');

            $view->with('appLogo', $logo);
        });

        // Composer 3: بناء قائمة AdminLTE بناءً على الصلاحيات (محسّن وآمن)
        View::composer('*', function ($view) {
            static $menuUpdated = false;
            if ($menuUpdated) return;

            $user = auth()->user();
            if (! $user) return;

            // --- أمان قبل التحميل: تحقق من وجود علاقة permissions في الموديل الحالي ---
            if (method_exists($user, 'permissions') && is_callable([$user, 'permissions'])) {
                if (! $user->relationLoaded('permissions')) {
                    $user->load('permissions');
                }
            }

            // تحويل أي قيمة null إلى مجموعة فارغة لتجنب استدعاء contains() على null
            $permissions = $user->permissions ?? collect();

            // دالة مساعدة مركزيّة للتحقق من الصلاحيات
            $hasPermission = function ($perm) use ($user, $permissions) {
                // اذا الموديل يملك خاصية role و قيمتها admin => نعطيه كل الصلاحيات
                if (isset($user->role) && Str::lower($user->role) === 'admin') {
                    return true;
                }

                // لو ليست هناك مجموعة صلاحيات أو فارغة => false
                if (! $permissions || $permissions->isEmpty()) {
                    return false;
                }

                return $permissions->contains('permission', $perm);
            };

            $existingMenu = [];

            // القائمة الرئيسية الثابتة التي ستُبنى بناءً على الصلاحيات
            $existingMenu[] = [
                'type' => 'fullscreen-widget',
                'topnav_right' => true,
            ];

            // لوحة التحكم
            if ($hasPermission('dashboard-access')) {
                $existingMenu[] = [
                    'text' => 'لوحة التحكم',
                    'icon' => 'fas fa-tachometer-alt',
                    'url' => 'admin/home'
                ];
            }

            // العملاء المحتملون
            if ($hasPermission('leads-customers-show')) {
                $existingMenu[] = [
                    'text' => 'العملاء المحتملون',
                    'url' => 'admin/leads-customers',
                    'icon' => 'fas fa-hourglass-half',
                ];
            }

            $pendingCount = ModelsDocumentType::where('order_status', 'panding')->count();

            // طلبات الملفات
            if ($hasPermission('requests-show')) {
                $existingMenu[] = [
                    'text'  => 'طلبات الملفات',
                    'url'   => 'admin/document-requests',
                    'icon'  => 'fas fa-file-alt',
                    'label' => $pendingCount,
                    'label_color' => 'warning',
                ];
            }

            // العملاء
            if ($hasPermission('customers-show')) {
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
                    'icon' => 'fas fa-passport'
                ],
                [
                    'permission' => 'embassy-create',
                    'text' => 'تعريف القنصلية',
                    'url' => 'admin/embassy-view',
                    'icon' => 'fas fa-landmark'
                ],
                [
                    'permission' => 'sponser-create',
                    'text' => 'تعريف الكفيل',
                    'url' => 'admin/sponsor-view',
                    'icon' => 'fas fa-user-shield'
                ],
                [
                    'permission' => 'taakeb-show',
                    'text' => 'طلبات التعقيب',
                    'url' => 'admin/taakebs',
                    'icon' => 'fas fa-file'
                ],
            ];

            foreach ($visaDefinitions as $item) {
                if ($hasPermission($item['permission'])) {
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
                    'icon' => 'fas fa-user-tie'
                ],
                [
                    'permission' => 'bag-create',
                    'text' => 'تعريف الحقائب',
                    'url' => 'admin/bags-view',
                    'icon' => 'fas fa-suitcase-rolling'
                ],
                [
                    'permission' => 'group-create',
                    'text' => 'تعريف المجموعات',
                    'url' => 'admin/customer-groups',
                    'icon' => 'fas fa-users'
                ],
                [
                    'permission' => 'file-create',
                    'text' => 'تعريف المستندات',
                    'url' => 'admin/document-type-view',
                    'icon' => 'fas fa-file-alt'
                ],
                [
                    'permission' => 'payment-create',
                    'text' => 'تعريف المعاملات المالية',
                    'url' => 'admin/payment-type-view',
                    'icon' => 'fas fa-hand-holding-usd'
                ],
                [
                    'permission' => 'message-create',
                    'text' => 'تعريف قوالب الرسائل',
                    'url' => 'admin/template',
                    'icon' => 'fas fa-envelope-open-text'
                ],
                [
                    'permission' => 'test-create',
                    'text' => 'الاختبارات',
                    'url' => 'admin/tests',
                    'icon' => 'fas fa-file-medical-alt'
                ],
                [
                    'permission' => 'job-create',
                    'text' => 'تعريف الوظائف',
                    'url' => 'admin/job-type-view',
                    'icon' => 'fas fa-briefcase'
                ],
            ];

            foreach ($customerDefinitions as $item) {
                if ($hasPermission($item['permission'])) {
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
            if ($hasPermission('tasks-access')) {
                $existingMenu[] = [
                    'text' => 'المهام',
                    'url' => 'admin/user-tasks',
                    'icon' => 'fas fa-tasks',
                ];
            }

            // قسم الإعدادات
            $existingMenu[] = ['header' => 'الاعدادات'];

            if ($hasPermission('users-manage')) {
                $existingMenu[] = [
                    'text' => 'المستخدم',
                    'url' => 'admin/users',
                    'icon' => 'fas fa-users-cog',
                ];
            }

            if ($hasPermission('company-settings')) {
                $existingMenu[] = [
                    'text' => 'اعدادات الشركة',
                    'url' => 'admin/company',
                    'icon' => 'fas fa-building',
                ];
            }

            if ($hasPermission('archived-customers')) {
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
