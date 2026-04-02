@extends('adminlte::page')

@section('title', 'استيراد حركات العملاء')

@section('content_header')
    <div class="container-fluid">
        <h1 class="text-bold">معالجة شيت حركة الأصناف</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- بطاقة الرفع --}}
                <div class="card card-outline card-dark shadow">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">
                            <i class="fas fa-upload mr-2 text-primary"></i> رفع ملف الإكسيل
                        </h3>
                    </div>

                    <form id="importForm" action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body py-4">
                            <div class="text-center mb-4">
                                <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                                <p class="text-secondary">يرجى اختيار ملف الإكسيل المستخرج لبدء عملية ترحيل البيانات
                                    تلقائياً.</p>
                            </div>

                            <div class="form-group">
                                <label for="excel_file">ملف الحركة (.xlsx, .xls, .csv)</label>
                                <div class="custom-file shadow-sm">
                                    <input type="file" name="excel_file" class="custom-file-input" id="excel_file"
                                        accept=".xlsx, .xls, .csv" required>
                                    <label class="custom-file-label" for="excel_file" data-browse="تصفح">اختر
                                        الملف...</label>
                                </div>
                                <small class="form-text text-danger mt-2">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> تأكد من مطابقة أعمدة الشيت للنظام لتجنب
                                    أخطاء الاستيراد.
                                </small>
                            </div>
                        </div>

                        <div class="card-footer bg-light text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary px-4 shadow-sm">
                                <span id="btnText"><i class="fas fa-check-circle mr-1"></i> بدء المعالجة والرفع</span>
                                <span id="btnLoader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> جاري المعالجة...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- تنبيه بسيط --}}
                <div class="alert alert-info border-0 shadow-sm mt-3">
                    <h5><i class="icon fas fa-info"></i> ملاحظة:</h5>
                    سيتم التعرف على العملاء من خلال أسمائهم الموجودة في الشيت ومطابقتها بقاعدة البيانات.
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* تحسين شكل الـ Custom File Input */
        .custom-file-label::after {
            background-color: #343a40 !important;
            color: white !important;
        }

        .custom-file-input:focus~.custom-file-label {
            border-color: #007bff;
            box-shadow: none;
        }
    </style>
@stop

@section('js')
    {{-- استدعاء مكتبة SweetAlert2 من CDN لضمان عملها --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // تحديث اسم الملف عند الاختيار
            $('#excel_file').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // منع التكرار وإظهار لودر التحميل
            $('#importForm').on('submit', function() {
                $('#submitBtn').attr('disabled', true);
                $('#btnText').hide();
                $('#btnLoader').show();
            });

            // عرض رسالة النجاح بـ SWAL
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'تم الاستيراد!',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'موافق',
                    confirmButtonColor: '#007bff',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            // عرض رسالة الخطأ بـ SWAL
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'فشل الاستيراد',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'إغلاق',
                    confirmButtonColor: '#dc3545'
                });
            @endif
        });
    </script>
@stop
