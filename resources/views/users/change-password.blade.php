@extends('adminlte::page')

@section('title', 'تغيير كلمة المرور')

@section('content')
    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="modern-header-card p-3 shadow-sm mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 font-weight-bold header-title">تحديث أمان الحساب</h4>
                        <p class="mb-0 small user-subtitle">تغيير كلمة المرور للمستخدم: <strong>{{ $user->name }}</strong>
                        </p>
                    </div>
                    <i class="fas fa-shield-alt fa-2x text-primary opacity-25"></i>
                </div>

                <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('user.changePassword', $user->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- اسم المستخدم (للعرض فقط) --}}
                                <div class="form-group col-12 mb-4">
                                    <label class="small font-weight-bold mb-2">الاسم الكامل</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-soft border-0"><i
                                                    class="fas fa-user text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control modern-input readonly-input"
                                            value="{{ $user->name }}" readonly disabled>
                                    </div>
                                </div>

                                {{-- كلمة المرور الجديدة --}}
                                <div class="form-group col-12 mb-4">
                                    <label class="small font-weight-bold mb-2 text-navy">كلمة المرور الجديدة</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-soft border-0"><i
                                                    class="fas fa-key text-primary"></i></span>
                                        </div>
                                        <input type="password" name="password"
                                            class="form-control modern-input @error('password') is-invalid @enderror"
                                            placeholder="أدخل كلمة المرور الجديدة هنا" required>
                                    </div>
                                    @error('password')
                                        <small class="text-danger mt-1 d-block font-weight-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- زر الحفظ --}}
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-save-modern w-100 py-3 rounded-pill shadow">
                                    <i class="fas fa-check-circle ml-2"></i> تأفيذ تغيير كلمة المرور
                                </button>
                                <a href="{{ route('users') }}" class="btn btn-link btn-sm mt-3 text-muted">
                                    إلغاء والعودة للقائمة
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'تم التحديث',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#1a237e',
                    background: document.body.classList.contains('dark-mode') ? '#1c2437' : '#fff',
                    color: document.body.classList.contains('dark-mode') ? '#fff' : '#000'
                });
            </script>
        @endif
    </div>
@endsection

@section('css')
    <style>
        /* المتغيرات والسمات العامة */
        :root {
            --primary-navy: #1a237e;
            --accent-blue: #3f51b5;
            --soft-bg: #f8fafc;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f7f9;
        }

        /* الهيدر الموحد */
        .modern-header-card {
            background-color: #ffffff;
            border-right: 5px solid var(--accent-blue);
            border-radius: 15px;
        }

        .header-title {
            color: var(--primary-navy);
        }

        /* الكارد والمدخلات */
        .modern-form-card {
            background-color: #ffffff;
        }

        .modern-input {
            border: 2px solid #edf2f7 !important;
            border-radius: 10px !important;
            padding: 12px;
            height: auto;
            transition: 0.3s;
        }

        .modern-input:focus {
            border-color: var(--accent-blue) !important;
            box-shadow: none !important;
        }

        .readonly-input {
            background-color: #f8fafc !important;
            color: #a0aec0;
        }

        .input-group-text {
            border-radius: 10px 0 0 10px !important;
        }

        .bg-soft {
            background-color: #f1f5f9;
        }

        /* زر الحفظ المودرن */
        .btn-save-modern {
            background: linear-gradient(135deg, #1a237e 0%, #3f51b5 100%);
            color: white !important;
            border: none;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-save-modern:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* إعدادات الدارك مود */
        .dark-mode .modern-header-card,
        .dark-mode .modern-form-card {
            background-color: #1c2437 !important;
            color: #fff;
        }

        .dark-mode .header-title {
            color: #fff !important;
        }

        .dark-mode .user-subtitle {
            color: #94a3b8 !important;
        }

        .dark-mode .modern-input {
            background-color: #242f48 !important;
            border-color: #334155 !important;
            color: #fff !important;
        }

        .dark-mode .readonly-input {
            background-color: #161e2e !important;
            opacity: 0.6;
        }

        .dark-mode .bg-soft {
            background-color: #334155 !important;
        }

        .dark-mode .input-group-text i {
            color: #8c9eff !important;
        }

        /* ضبط اتجاه العناصر */
        .input-group>.input-group-prepend>.input-group-text {
            border-radius: 0 10px 10px 0 !important;
        }

        .modern-input {
            border-radius: 10px 0 0 10px !important;
            text-align: right;
        }
    </style>
@stop
