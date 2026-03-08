@extends('adminlte::page')

@section('title', 'إعدادات الشركة')

@section('content')
    <div class="container-fluid pt-4">

        <div class="row mb-4 px-2">
            <div class="col-12 d-flex justify-content-between align-items-center modern-header-card p-3 shadow-sm">
                <div>
                    <h4 class="mb-0 font-weight-bold header-title">⚙️ إعدادات النظام والشركة</h4>
                    <p class="mb-0 small user-subtitle">إدارة البيانات الأساسية، التراخيص، وربط الخدمات التقنية</p>
                </div>
                <div class="icon-circle-bg">
                    <i class="fas fa-building fa-lg text-primary"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 modern-form-card" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <h5 class="section-divider mb-4"><span>البيانات التعريفية</span></h5>
                            <div class="row mb-4">
                                <div class="col-md-4 form-group">
                                    <label class="small-label">اسم الشركة</label>
                                    <input type="text" class="form-control modern-input" name="name"
                                        value="{{ $company->name ?? '' }}" required>
                                    @error('name')
                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="small-label">العنوان الفيزيائي</label>
                                    <input type="text" class="form-control modern-input" name="address"
                                        value="{{ $company->address ?? '' }}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="small-label">رقم الترخيص / السجل</label>
                                    <input type="text" class="form-control modern-input" name="license_number"
                                        value="{{ $company->license_number ?? '' }}">
                                </div>
                            </div>

                            <h5 class="section-divider mb-4"><span>إعدادات الربط (إنجاز & الخدمات)</span></h5>
                            <div class="row mb-4">
                                <div class="col-md-4 form-group">
                                    <label class="small-label text-primary">البريد الإلكتروني لإنجاز</label>
                                    <input type="email" class="form-control modern-input border-primary-soft"
                                        name="engaz_email" value="{{ $company->engaz_email ?? '' }}" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="small-label text-primary">كلمة المرور لإنجاز</label>
                                    <input type="text" class="form-control modern-input border-primary-soft"
                                        name="engaz_password" value="{{ $company->engaz_password ?? '' }}" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label class="small-label">ايميل الكشف الطبي</label>
                                    <input type="email" class="form-control modern-input" name="medical_email"
                                        value="{{ $company->medical_email ?? '' }}" required>
                                </div>
                            </div>

                            <div class="row mb-4 align-items-end">
                                <div class="col-md-6 form-group">
                                    <label class="small-label text-warning">توكن الرسائل (API Token)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-soft-warning"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="text" class="form-control modern-input" name="token"
                                            value="{{ $company->token ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="small-label">شعار الشركة (اللوجو)</label>
                                    <div class="upload-container shadow-sm p-2 d-flex align-items-center">
                                        <input type="file" name="logo" class="flex-grow-1">
                                        @if ($company && $company->logo)
                                            <div class="logo-preview-wrapper ml-3">
                                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 opacity-5">

                            <button type="submit" class="btn btn-save-premium py-3 px-5 shadow-lg">
                                <i class="fas fa-check-double ml-2"></i> حفظ كافة الإعدادات
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Session::has('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "تم التحديث!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                confirmButtonText: "ممتاز",
                confirmButtonColor: "#1a237e",
                background: document.body.classList.contains('dark-mode') ? '#1c2437' : '#fff',
                color: document.body.classList.contains('dark-mode') ? '#fff' : '#000'
            });
        </script>
    @endif
@endsection

@section('css')
    <style>
        :root {
            --primary-navy: #1a237e;
            --accent-blue: #3f51b5;
            --soft-bg: #f8fafc;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f1f5f9;
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

        .icon-circle-bg {
            width: 50px;
            height: 50px;
            background: rgba(63, 81, 181, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* الكارد والمدخلات */
        .modern-form-card {
            background-color: #ffffff;
            border-radius: 20px;
        }

        .modern-input {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 12px 15px !important;
            height: auto !important;
            transition: 0.3s;
            background-color: #fff;
        }

        .modern-input:focus {
            border-color: var(--accent-blue) !important;
            box-shadow: 0 0 10px rgba(63, 81, 181, 0.1) !important;
        }

        .border-primary-soft {
            border-color: rgba(63, 81, 181, 0.3) !important;
        }

        /* فواصل الأقسام */
        .section-divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--primary-navy);
            font-size: 0.95rem;
            font-weight: 700;
        }

        .section-divider::after,
        .section-divider::before {
            content: "";
            flex: 1;
            border-bottom: 1px solid #edf2f7;
        }

        .section-divider span {
            padding: 0 15px;
        }

        .small-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 8px;
            display: block;
        }

        /* اللوجو */
        .upload-container {
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            background: #fdfdfd;
        }

        .logo-preview-wrapper img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* زر الحفظ */
        .btn-save-premium {
            background: linear-gradient(135deg, #1a237e 0%, #3f51b5 100%);
            color: white !important;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
        }

        .btn-save-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(26, 35, 126, 0.2);
        }

        /* الدارك مود */
        .dark-mode .modern-header-card,
        .dark-mode .modern-form-card {
            background-color: #1c2437 !important;
        }

        .dark-mode .header-title {
            color: #fff !important;
        }

        .dark-mode .modern-input {
            background-color: #242f48 !important;
            border-color: #334155 !important;
            color: #fff !important;
        }

        .dark-mode .section-divider {
            color: #8c9eff;
        }

        .dark-mode .section-divider::after,
        .dark-mode .section-divider::before {
            border-color: #334155;
        }

        .dark-mode .small-label {
            color: #94a3b8;
        }

        .dark-mode .upload-container {
            background: #161e2e;
            border-color: #334155;
        }

        .dark-mode .input-group-text {
            background-color: #334155;
            border: none;
            color: #fbbf24;
        }

        .bg-soft-warning {
            background-color: #fffbeb;
            color: #d97706;
        }
    </style>
@stop
