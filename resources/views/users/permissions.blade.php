@extends('adminlte::page')

@section('title', 'تحديد الصلاحيات')

@section('content')
    <div class="container-fluid pt-4">
        <div class="row mb-4 px-2">
            <div class="col-12 d-flex justify-content-between align-items-center modern-header-card p-3 shadow-sm">
                <div>
                    <h4 class="mb-0 font-weight-bold header-title">إدارة صلاحيات الوصول</h4>
                    <p class="mb-0 small user-subtitle">المستخدم: <strong>{{ $user->name }}</strong> ({{ $user->email }})
                    </p>
                </div>
                <a href="{{ route('users') }}" class="btn btn-back-modern rounded-pill px-4">
                    <i class="fas fa-undo-alt ml-1"></i> رجوع
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('permissions.edit', $user->id) }}">
            @csrf
            <div class="row">
                @php
                    $permissions = [
                        'dashboard-access' => ['label' => 'لوحة التحكم', 'icon' => 'fa-chart-pie'],
                        'leads-customers-show' => ['label' => 'العملاء المحتملون', 'icon' => 'fa-user-tag'],
                        'customers-show' => ['label' => 'عرض العملاء', 'icon' => 'fa-users'],
                        'create-customer' => ['label' => 'إضافة عميل', 'icon' => 'fa-user-plus'],
                        'show-customer' => ['label' => 'عرض العميل', 'icon' => 'fa-id-card'],
                        'visa-type-create' => ['label' => 'تعريف التأشيرة', 'icon' => 'fa-passport'],
                        'embassy-create' => ['label' => 'تعريف القنصلية', 'icon' => 'fa-building'],
                        'sponser-create' => ['label' => 'تعريف الكفيل', 'icon' => 'fa-handshake'],
                        'delegate-create' => ['label' => 'تعريف المناديب', 'icon' => 'fa-walking'],
                        'message-create' => ['label' => 'قوالب الرسائل', 'icon' => 'fa-comment-alt'],
                        'bag-create' => ['label' => 'تعريف الحقائب', 'icon' => 'fa-suitcase'],
                        'group-create' => ['label' => 'تعريف المجموعات', 'icon' => 'fa-layer-group'],
                        'file-create' => ['label' => 'تعريف المستندات', 'icon' => 'fa-file-medical'],
                        'test-create' => ['label' => 'الاختبارات', 'icon' => 'fa-vials'],
                        'job-create' => ['label' => 'تعريف الوظائف', 'icon' => 'fa-briefcase'],
                        'bulk-sms-access' => ['label' => 'إرسال رسائل', 'icon' => 'fa-paper-plane'],
                        'tasks-access' => ['label' => 'المهام', 'icon' => 'fa-tasks'],
                        'users-manage' => ['label' => 'المستخدمين', 'icon' => 'fa-user-shield'],
                        'company-settings' => ['label' => 'إعدادات الشركة', 'icon' => 'fa-cog'],
                        'archived-customers' => ['label' => 'أرشيف العملاء', 'icon' => 'fa-archive'],
                        'taakeb-show' => ['label' => 'طلبات التعقيب', 'icon' => 'fa-stamp'],
                        'requests-show' => ['label' => 'طلبات الملفات', 'icon' => 'fa-folder-open'],
                        'loginFail-access' => ['label' => 'فشل الدخول', 'icon' => 'fa-exclamation-triangle'],
                        'show-group-customers' => ['label' => 'عملاء المجموعات', 'icon' => 'fa-users-cog'],
                        'show-leads' => ['label' => 'عرض المحتملين', 'icon' => 'fa-eye'],
                        'job-question-create' => ['label' => 'أسئلة الوظائف', 'icon' => 'fa-question-circle'],
                        'deep-search-access' => ['label' => 'البحث المتقدم', 'icon' => 'fa-search-plus'],
                        'delegates-settings' => ['label' => 'إعدادات المناديب', 'icon' => 'fa-user-cog'],
                        'financial-matters' => ['label' => 'الأمور المالية', 'icon' => 'fa-money-bill-wave'],
                    ];
                @endphp

                @foreach ($permissions as $value => $data)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="permission-card shadow-sm border-0 h-100 transition-3d">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="icon-box-modern mr-3 ml-3">
                                    <i class="fas {{ $data['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1 text-right">
                                    <h6 class="mb-0 font-weight-bold permission-title">{{ $data['label'] }}</h6>
                                    <span class="text-xs text-muted">ID: {{ $value }}</span>
                                </div>
                                <div class="custom-checkbox-wrapper ml-2">
                                    <input type="checkbox" id="perm_{{ $loop->index }}" name="permissions[]"
                                        value="{{ $value }}" class="custom-checkbox-input"
                                        @if (in_array($value, $userPermissions)) checked @endif>
                                    <label for="perm_{{ $loop->index }}" class="custom-checkbox-label"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="sticky-footer text-center mt-5 pb-5">
                <button type="submit" class="btn btn-save-modern shadow-lg px-5 py-3 rounded-pill">
                    <i class="fas fa-shield-check ml-2"></i> اعتماد الصلاحيات الجديدة
                </button>
            </div>
        </form>
    </div>
@stop

@section('css')
    <style>
        /* باليتة الألوان المودرن */
        :root {
            --primary-navy: #1a237e;
            --accent-blue: #3f51b5;
            --light-bg: #f5f7fb;
            --card-bg-dark: #121826;
            --item-bg-dark: #1c2437;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Cairo', sans-serif;
        }

        /* الكارد الخاص بالصلاحية */
        .permission-card {
            background: #ffffff;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .dark-mode .permission-card {
            background: var(--item-bg-dark) !important;
            color: #fff;
        }

        .border-left-premium {
            border-left: 5px solid var(--accent-blue);
        }

        .text-navy {
            color: var(--primary-navy);
        }

        .dark-mode .text-navy {
            color: #8c9eff;
        }

        /* صندوق الأيقونة */
        .icon-box-modern {
            width: 45px;
            height: 45px;
            background: rgba(63, 81, 181, 0.1);
            color: var(--accent-blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .dark-mode .icon-box-modern {
            background: rgba(255, 255, 255, 0.05);
            color: #8c9eff;
        }

        /* تأثير الـ 3D Hover */
        .transition-3d {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .transition-3d:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1) !important;
            background-color: #fff;
        }

        .dark-mode .transition-3d:hover {
            background-color: #242f48 !important;
        }

        /* كاستم تشيك بوكس (دائري وأنيق) */
        .custom-checkbox-input {
            display: none;
        }

        .custom-checkbox-label {
            width: 24px;
            height: 24px;
            border: 2px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            transition: 0.3s;
        }

        .custom-checkbox-input:checked+.custom-checkbox-label {
            background-color: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .custom-checkbox-input:checked+.custom-checkbox-label::after {
            content: '✔';
            color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }

        /* زر الحفظ */
        .btn-save-modern {
            background: linear-gradient(135deg, #1a237e 0%, #3f51b5 100%);
            color: white !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: none;
            min-width: 300px;
        }

        .btn-save-modern:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .dark-mode .text-muted {
            color: #94a3b8 !important;
        }

        /* --- تنسيق الهيدر المودرن --- */
        .modern-header-card {
            background-color: #ffffff;
            /* لون الفاتح */
            border-right: 5px solid #3f51b5;
            /* استبدال border-left بـ border-right للغة العربية */
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .header-title {
            color: #1a237e;
        }

        .user-subtitle {
            color: #6c757d;
        }

        /* --- تنسيق الزر --- */
        .btn-back-modern {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #333;
            transition: 0.3s;
        }

        /* --- تعديلات الدارك مود (السحر هنا) --- */
        .dark-mode .modern-header-card {
            background-color: #1c2437 !important;
            /* لون كحلي عميق متناسق مع الكروت */
            border-right-color: #8c9eff !important;
            /* لون حدود أفتح للبروز */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
        }

        .dark-mode .header-title {
            color: #ffffff !important;
        }

        .dark-mode .user-subtitle {
            color: #94a3b8 !important;
        }

        .dark-mode .btn-back-modern {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }

        .dark-mode .btn-back-modern:hover {
            background-color: #4a5568;
            color: #fff;
        }
    </style>
@stop
