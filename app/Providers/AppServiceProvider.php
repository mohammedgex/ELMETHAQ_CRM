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

            $existingMenu = Config::get('adminlte.menu', []);

            // دالة مساعدة لإضافة submenu
            $addSubmenu = function (&$menu, $parentText, $submenuItem) {
                foreach ($menu as &$item) {
                    if (isset($item['text']) && $item['text'] === $parentText) {
                        $item['submenu'] = $item['submenu'] ?? [];
                        $item['submenu'][] = $submenuItem;
                        break;
                    }
                }
            };

            // العملاء
            if ($user->role === 'admin' || $user->permissions->contains('permission', 'customers-show')) {
                array_splice($existingMenu, 3, 0, [[
                    'text' => 'العملاء',
                    'url' => 'admin/customers',
                    'icon' => 'fas fa-eye',
                    'label_color' => 'success',
                ]]);
            }

            // تعريفات التأشيرة
            $visaDefinitions = [
                ['permission' => 'visa-type-create', 'text' => 'تعريف التأشيرات', 'url' => 'admin/visa-type-view', 'icon' => 'fab fa-cc-visa'],
                ['permission' => 'embassy-create', 'text' => 'تعريف القنصلية', 'url' => 'admin/embassy-view', 'icon' => 'fas fa-landmark'],
                ['permission' => 'sponser-create', 'text' => 'تعريف الكفيل', 'url' => 'admin/sponsor-view', 'icon' => 'fas fa-user-tie'],
            ];

            foreach ($visaDefinitions as $item) {
                if ($user->role === 'admin' || $user->permissions->contains('permission', $item['permission'])) {
                    $addSubmenu($existingMenu, 'تعريفات التأشيرة', [
                        'text' => $item['text'],
                        'url' => $item['url'],
                        'icon' => $item['icon'],
                    ]);
                }
            }

            // تعريفات العملاء
            $customerDefinitions = [
                ['permission' => 'delegate-create', 'text' => 'تعريف المناديب', 'url' => 'admin/Delegates-create', 'icon' => 'fas fa-user-tag'],
                ['permission' => 'bag-create', 'text' => 'تعريف الحقائب', 'url' => 'admin/bags-view', 'icon' => 'fas fa-user-tag'],
                ['permission' => 'group-create', 'text' => 'تعريف المجموعات', 'url' => 'admin/customer-groups', 'icon' => 'fas fa-layer-group'],
                ['permission' => 'file-create', 'text' => 'تعريف المستندات', 'url' => 'admin/document-type-view', 'icon' => 'fas fa-file-alt'],
                ['permission' => 'payment-create', 'text' => 'تعريف المعاملات المالية', 'url' => 'admin/payment-type-view', 'icon' => 'fas fa-money-check-alt'],
                ['permission' => 'message-create', 'text' => 'تعريف قوالب الرسائل', 'url' => 'admin/template', 'icon' => 'fas fa-user-tag'],
            ];

            foreach ($customerDefinitions as $item) {
                if ($user->role === 'admin' || $user->permissions->contains('permission', $item['permission'])) {
                    $addSubmenu($existingMenu, 'تعريفات العملاء', [
                        'text' => $item['text'],
                        'url' => $item['url'],
                        'icon' => $item['icon'],
                    ]);
                }
            }

            Config::set('adminlte.menu', $existingMenu);

            $menuUpdated = true; // تأكيد عدم التكرار في نفس الطلب
        });
    }
}
