<?php

namespace App\Providers;

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
            $user = auth()->user();
            if ($user) {
                # code...
                if ($user && !$user->relationLoaded('permissions')) {
                    $user->load('permissions');
                }

                $existingMenu = Config::get('adminlte.menu', []);

                if ($user->permissions->contains('permission', 'customers-show') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'العملاء') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] = [
                                'text' => 'العملاء',
                                'url' => 'admin/customers',
                                'icon' => 'fas fa-eye',
                                'label' => 4,
                                'label_color' => 'success',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'create-customer') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'العملاء') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] = [
                                'text' => 'اضافة عميل',
                                'url' => 'admin/customer-create',
                                'icon' => 'fas fa-user-plus',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'visa-type-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات التأشيرة') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] = [
                                'text' => 'تعريف التأشيرات',
                                'url' => 'admin/visa-type-view',
                                'icon' => 'fab fa-cc-visa',
                                'label_color' => 'success',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'embassy-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات التأشيرة') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] =  [
                                'text' => 'تعريف القنصلية',
                                'url' => 'admin/embassy-view',
                                'icon' => 'fas fa-landmark',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'sponser-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات التأشيرة') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] =  [
                                'text' => 'تعريف الكفيل',
                                'url' => 'admin/sponsor-view',
                                'icon' => 'fas fa-user-tie',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'delegate-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات العملاء') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] =  [
                                'text' => 'تعريف المناديب',
                                'url' => 'admin/Delegates-create',
                                'icon' => 'fas fa-user-tag',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'bag-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات العملاء') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] = [
                                'text' => 'تعريف الحقائب',
                                'url' => 'admin/bags-view',
                                'icon' => 'fas fa-user-tag',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'group-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات العملاء') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] =  [
                                'text' => 'تعريف المجموعات',
                                'url' => 'admin/customer-groups',
                                'icon' => 'fas fa-layer-group',
                            ];
                            break;
                        }
                    }
                }

                if ($user && $user->permissions->contains('permission', 'file-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات العملاء') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] =  [
                                'text' => 'تعريف المستندات',
                                'url' => 'admin/document-type-view',
                                'icon' => 'fas fa-file-alt',
                            ];
                            break;
                        }
                    }
                }
                if ($user && $user->permissions->contains('permission', 'payment-create') || $user->role == "admin") {
                    foreach ($existingMenu as &$menuItem) {
                        if (isset($menuItem['text']) && $menuItem['text'] === 'تعريفات العملاء') {
                            if (!isset($menuItem['submenu'])) {
                                $menuItem['submenu'] = [];
                            }
                            $menuItem['submenu'][] = [
                                'text' => 'تعريف المعاملات المالية',
                                'url' => 'admin/payment-type-view',
                                'icon' => 'fas fa-money-check-alt',
                            ];
                            break;
                        }
                    }
                }

                Config::set('adminlte.menu', $existingMenu);
            }
        });
    }
}
