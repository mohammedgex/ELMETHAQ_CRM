@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'مطابقة العملاء')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center px-3">
        <h1 class="m-0 font-weight-bold">
            <i class="fas fa-sync-alt mr-2 text-primary"></i> مطابقة بيانات الشيت
        </h1>
    </div>
@stop

@section('content')
    <div class="container-fluid pb-5">

        {{-- قسم الإحصائيات السريعة --}}
        <div class="row mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small">إجمالي العملاء</span>
                        <span class="info-box-number h5 mb-0">{{ count($customersList) }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-double"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small">تم التعرف عليهم</span>
                        <span class="info-box-number h5 mb-0">
                            {{ collect($customersList)->where('status', 'found')->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm mb-3 border-right border-danger">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-slash"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small">عملاء جدد / مجهولين</span>
                        <span class="info-box-number h5 mb-0">
                            {{ collect($customersList)->where('status', 'not_found')->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-percentage text-white"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted small">نسبة المطابقة</span>
                        <span class="info-box-number h5 mb-0">
                            @php
                                $total = count($customersList);
                                $found = collect($customersList)->where('status', 'found')->count();
                                $percent = $total > 0 ? round(($found / $total) * 100) : 0;
                            @endphp
                            {{ $percent }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- الكارد الرئيسي للجدول --}}
        <div class="card card-outline card-primary shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h3 class="card-title font-weight-bold text-muted">
                    <i class="fas fa-table mr-1 text-primary"></i> جدول مراجعة البيانات
                </h3>
            </div>

            <form action="{{ route('import.final_confirm') }}" method="POST">
                @csrf
                <div class="card-body p-0">
                    <div class="table-responsive" style="overflow: visible !important;">
                        <table class="table table-hover mb-0 align-middle text-center custom-mapping-table">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 40%" class="text-right px-4">الاسم في ملف الإكسيل</th>
                                    <th style="width: 60%">الربط مع قاعدة البيانات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customersList as $index => $item)
                                    <tr class="{{ $item['status'] == 'not_found' ? 'table-warning-light' : '' }}">
                                        <td class="align-middle text-right px-4">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="status-indicator {{ $item['status'] == 'found' ? 'bg-success' : 'bg-danger shadow-pulse' }} mr-3">
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-weight-bold text-dark">{{ $item['display_name'] }}</span>
                                                    <br><small class="text-muted">{{ $item['excel_original'] }}</small>
                                                    <input type="hidden" name="mapping[{{ $index }}][excel_name]"
                                                        value="{{ $item['excel_original'] }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <select name="mapping[{{ $index }}][customer_id]"
                                                class="form-control customer-select" required>
                                                @if ($item['system_id'])
                                                    <option value="{{ $item['system_id'] }}" selected>
                                                        {{ $item['system_name'] }}</option>
                                                @else
                                                    <option></option>
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm font-weight-bold ripple-btn">
                        <i class="fas fa-cloud-upload-alt mr-2"></i> تأكيد وحفظ كافة البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* ستايل الإحصائيات */
        .info-box {
            min-height: 85px;
            border-radius: 10px;
        }

        .info-box-text {
            font-size: 0.85rem;
            letter-spacing: 0.3px;
        }

        .info-box-number {
            font-weight: 800;
            color: #2d3436;
        }

        /* ستايل الجدول */
        .custom-mapping-table thead th {
            border-top: 0;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #636e72;
        }

        .table-warning-light {
            background-color: rgba(255, 193, 7, 0.04);
        }

        /* مؤشر الحالة */
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .shadow-pulse {
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        /* Select2 - نفس تنسيقك المعتمد */
        .select2-container {
            width: 100% !important;
            text-align: right;
        }

        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border-radius: 8px !important;
            border: 1px solid #dfe6e9 !important;
            padding-top: 6px;
        }

        /* Dark Mode */
        .dark-mode .info-box {
            background-color: #343a40 !important;
            color: #fff;
        }

        .dark-mode .info-box-number {
            color: #fff;
        }

        .dark-mode .bg-white {
            background-color: #343a40 !important;
            border-bottom: 1px solid #4b545c !important;
        }

        .dark-mode .text-dark {
            color: #fff !important;
        }

        .ripple-btn {
            transition: transform 0.2s;
        }

        .ripple-btn:active {
            transform: scale(0.95);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.customer-select').select2({
                placeholder: 'اختر العميل المطابق من السيستم...',
                dir: "rtl",
                ajax: {
                    url: "{{ route('ajax.customers.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        q: params.term
                    }),
                    processResults: data => ({
                        results: data
                    })
                },
                minimumInputLength: 1,
                width: '100%'
            });
        });

        $(document).ready(function() {
            // التحقق من وجود رسالة نجاح في الجلسة
            @if (session('success'))
                Swal.fire({
                    title: 'تمت العملية بنجاح!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#28a745', // لون أخضر مناسب لـ AdminLTE
                    timer: 3000, // تختفي تلقائياً بعد 3 ثواني
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            @endif

            // يمكنك أيضاً إضافة تنبيه للخطأ إذا أردت
            @if (session('error'))
                Swal.fire({
                    title: 'خطأ!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'إغلاق',
                    confirmButtonColor: '#dc3545'
                });
            @endif
        });
    </script>
@stop
