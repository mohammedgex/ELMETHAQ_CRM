@extends('adminlte::page')

@section('title', 'التقارير')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">📊 عرض التقارير للعميل: {{ $customer->name_ar }}</h1>
@stop

@section('content')

    {{-- تحميل Font Awesome و SweetAlert2 (CDN) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- عرض الأخطاء بواسطة Swal --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'حدث خطأ',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'حسناً'
            });
        </script>
    @endif

    <style>
        /* === تثبيت الألوان لتعمل في الداكن والفاتح === */
        body {
            background: #eef1f6 !important;
        }

        .reports-wrapper {
            background: #fff !important;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            color: #000 !important;
        }

        .report-card {
            background: #ffffff !important;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.06);
            transition: transform .25s ease, box-shadow .25s ease;
            height: 100%;
            color: #000 !important;
        }

        .report-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 40px rgba(2, 6, 23, 0.12);
        }

        .icon-circle {
            display: inline-flex;
            width: 54px;
            height: 54px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 22px;
            color: #fff !important;
        }

        /* ألوان أيقونات */
        .icon-primary {
            background: linear-gradient(135deg, #0d6efd, #0069d9) !important;
        }

        .icon-success {
            background: linear-gradient(135deg, #28a745, #1e7e34) !important;
        }

        .icon-danger {
            background: linear-gradient(135deg, #dc3545, #c82333) !important;
        }

        /* عناوين وبِـرَافات */
        .report-card h5 {
            margin: 0 0 4px 0;
            font-size: 1.05rem;
            color: #0b1220 !important;
        }

        .report-card small {
            color: #6b7280 !important;
        }

        /* أزرار */
        .report-btn {
            width: 100%;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .report-btn i {
            font-size: 18px;
        }

        /* ثبات ألوان الأزرار ضد الداكن */
        .btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
            color: #fff !important;
        }

        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: #fff !important;
        }

        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: #fff !important;
        }

        /* responsive */
        @media (min-width: 992px) {
            .report-col {
                max-width: 33.3333%;
            }
        }

        /* اخفاء أي عناصر غير مرغوب فيها عند الطباعة */
        @media print {

            .navbar,
            .main-header,
            .main-footer,
            .sidebar,
            .btn {
                display: none !important;
            }

            .reports-wrapper {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
    <style>
        /* خلي الخلفية تتبع المود */
        body {
            background: var(--bs-body-bg) !important;
            color: var(--bs-body-color) !important;
        }

        .reports-wrapper {
            background: var(--bs-card-bg) !important;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            color: var(--bs-body-color) !important;
        }

        .report-card {
            background: #858585 !important;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.06);
            transition: transform .25s ease, box-shadow .25s ease;
            height: 100%;
            color: var(--bs-body-color) !important;
        }

        .report-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 40px rgba(2, 6, 23, 0.12);
        }

        .icon-circle {
            display: inline-flex;
            width: 54px;
            height: 54px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 22px;
            color: #fff !important;
        }

        /* ألوان أيقونات */
        .icon-primary {
            background: linear-gradient(135deg, #0d6efd, #0069d9) !important;
        }

        .icon-success {
            background: linear-gradient(135deg, #28a745, #1e7e34) !important;
        }

        .icon-danger {
            background: linear-gradient(135deg, #dc3545, #c82333) !important;
        }

        /* عناوين */
        .report-card h5 {
            margin: 0 0 4px 0;
            font-size: 1.05rem;
            color: var(--bs-heading-color, var(--bs-body-color)) !important;
        }

        .report-card small {
            color: var(--bs-secondary-color, #6b7280) !important;
        }

        /* أزرار */
        .report-btn {
            width: 100%;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .report-btn i {
            font-size: 18px;
        }

        /* responsive */
        @media (min-width: 992px) {
            .report-col {
                max-width: 33.3333%;
            }
        }

        /* الطباعة */
        @media print {

            .navbar,
            .main-header,
            .main-footer,
            .sidebar,
            .btn {
                display: none !important;
            }

            .reports-wrapper {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 0 !important;
            }
        }
    </style>


    <div class="container-fluid reports-wrapper">
        <div class="row mb-3">
            <div class="col-12 text-right">
                <p class="mb-0 text-muted">اختر التقرير الذي تريد عرضه أو تنزيله</p>
            </div>
        </div>

        <div class="row gx-3 gy-3">

            {{-- زر 1: استمارة الترشيح --}}
            <div class="col-12 col-md-6 col-lg-4 report-col">
                <div class="report-card d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-right">
                            <h5 class="mb-0">استمارة الترشيح</h5>
                            <small class="text-muted">عرض بيانات العميل كاملة ومعلومات الترشيح للطباعة أو التنزيل</small>
                        </div>
                        <div class="icon-circle icon-primary">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>

                    <a href="{{ route('reports.nomination_card', $customer->id) }}" target="_blank"
                        class="btn btn-primary report-btn mt-auto">
                        <i class="fas fa-eye"></i> عرض التقرير
                    </a>
                </div>
            </div>

            {{-- زر 2: باركود الـ E Number --}}
            <div class="col-12 col-md-6 col-lg-4 report-col">
                <div class="report-card d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-right">
                            <h5 class="mb-0">باركود الـ E Number</h5>
                            <small class="text-muted">الصورة القابلة للطباعة/المشاركة لباركود E Number</small>
                        </div>
                        <div class="icon-circle icon-success">
                            <i class="fas fa-barcode"></i>
                        </div>
                    </div>

                    <a href="{{ route('reports.e_number_barcode', $customer->id) }}" target="_blank"
                        class="btn btn-success report-btn mt-auto">
                        <i class="fas fa-eye"></i> عرض الصورة
                    </a>
                </div>
            </div>

            {{-- زر 3: باركود رقم التأشيرة --}}
            <div class="col-12 col-md-6 col-lg-4 report-col">
                <div class="report-card d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-right">
                            <h5 class="mb-0">باركود رقم التأشيرة</h5>
                            <small class="text-muted">صورة باركود قابلة للمسح الضوئي لرقم التأشيرة</small>
                        </div>
                        <div class="icon-circle icon-danger">
                            <i class="fas fa-qrcode"></i>
                        </div>
                    </div>

                    <a href="{{ route('reports.visaNumberBarcode', $customer->id) }}" target="_blank"
                        class="btn btn-danger report-btn mt-auto">
                        <i class="fas fa-eye"></i> عرض الصورة
                    </a>
                </div>
            </div>

        </div>
    </div>

@stop
