@extends('adminlte::page')

@section('title', 'إنشاء حساب جديد')

@section('content')
    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header border-0 bg-transparent pt-4">
                        <h3 class="text-center font-weight-bold page-main-title mb-1">إنشاء حساب جديد</h3>
                        <p class="text-center text-muted small">قم بتعبئة البيانات التالية لإضافة عضو جديد للوحة التحكم</p>
                    </div>

                    <div class="card-body px-md-5 pb-5">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- الاسم الكامل --}}
                                <div class="form-group col-md-6 mb-4">
                                    <label class="small font-weight-bold ml-1">الاسم الكامل</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-user text-primary"></i></span>
                                        </div>
                                        <input type="text" name="name"
                                            class="form-control modern-input @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" placeholder="مثال: محمد أحمد" required>
                                    </div>
                                    @error('name')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- البريد الإلكتروني --}}
                                <div class="form-group col-md-6 mb-4">
                                    <label class="small font-weight-bold ml-1">البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-envelope text-primary"></i></span>
                                        </div>
                                        <input type="email" name="email"
                                            class="form-control modern-input @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="example@mail.com" required>
                                    </div>
                                    @error('email')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- كلمة المرور --}}
                                <div class="form-group col-md-6 mb-4">
                                    <label class="small font-weight-bold ml-1">كلمة المرور</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-lock text-primary"></i></span>
                                        </div>
                                        <input type="password" name="password"
                                            class="form-control modern-input @error('password') is-invalid @enderror"
                                            placeholder="••••••••" required>
                                    </div>
                                    @error('password')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- تأكيد كلمة المرور --}}
                                <div class="form-group col-md-6 mb-4">
                                    <label class="small font-weight-bold ml-1">تأكيد كلمة المرور</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="fas fa-check-double text-primary"></i></span>
                                        </div>
                                        <input type="password" name="password_confirmation"
                                            class="form-control modern-input" placeholder="••••••••" required>
                                    </div>
                                </div>

                                {{-- الصلاحيات --}}
                                <div class="form-group col-md-12 mb-4">
                                    <label class="small font-weight-bold ml-1">تحديد الصلاحية</label>
                                    <select name="role"
                                        class="form-control modern-input custom-select @error('role') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>اختر الصلاحية المناسبة...</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مشرف (Admin) -
                                            كامل الصلاحيات</option>
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم (User) -
                                            صلاحيات محدودة</option>
                                    </select>
                                    @error('role')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- أزرار التحكم --}}
                            <div class="text-center mt-4">
                                <button type="submit"
                                    class="btn btn-primary-gradient px-5 py-3 shadow rounded-pill font-weight-bold">
                                    <i class="fas fa-user-plus ml-2"></i> إتمام إنشاء الحساب
                                </button>
                                <div class="mt-3">
                                    <a href="{{ route('users') }}" class="text-muted small text-decoration-none">
                                        <i class="fas fa-arrow-right ml-1"></i> العودة لقائمة المستخدمين
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        /* المتغيرات الأساسية */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body {
            background-color: #f4f7f6;
            font-family: 'Cairo', sans-serif;
        }

        /* تنسيق الكارد */
        .modern-form-card {
            background-color: #ffffff;
            transition: transform 0.3s ease;
        }

        .dark-mode .modern-form-card {
            background-color: #1e293b !important;
        }

        /* تحسين شكل المدخلات */
        .modern-input {
            border: 2px solid #f1f5f9 !important;
            border-radius: 0 10px 10px 0 !important;
            /* للحواف مع الأيقونة */
            padding: 12px;
            height: auto;
            transition: all 0.3s ease;
        }

        .input-group-text {
            border: 2px solid #f1f5f9 !important;
            border-left: none !important;
            border-radius: 10px 0 0 10px !important;
        }

        .modern-input:focus {
            border-color: #667eea !important;
            box-shadow: none !important;
            background-color: #fff;
        }

        .dark-mode .modern-input,
        .dark-mode .input-group-text {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #fff !important;
        }

        /* زر التدرج اللوني */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white !important;
            min-width: 250px;
            transition: 0.3s;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3) !important;
        }

        /* تحسين العناوين */
        .page-main-title {
            color: #1e293b;
        }

        .dark-mode .page-main-title {
            color: #f1f5f9;
        }

        /* ضبط اتجاه العناصر للغة العربية */
        .input-group>.input-group-prepend>.input-group-text {
            border-radius: 0 10px 10px 0 !important;
            border: 2px solid #f1f5f9 !important;
            border-right: none !important;
        }

        .modern-input {
            border-radius: 10px 0 0 10px !important;
            border-right: none !important;
            text-align: right;
        }
    </style>
@stop
