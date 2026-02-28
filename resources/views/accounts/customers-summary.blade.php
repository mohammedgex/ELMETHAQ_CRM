@extends('adminlte::page')

@section('title', 'ملخص حسابات العملاء')

@section('content_header')
    <h1 class="m-0">ملخص حسابات العملاء</h1>
@stop

@section('content')
    <div class="container-fluid">

        {{-- رسائل التنبيه --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- فورم إضافة قيد --}}
        <div class="card card-outline card-primary shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">إضافة قيد جديد</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                </div>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('accounts.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>اسم العميل</label>
                            <select name="customer_id" class="form-control customer-select" required></select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>مدين</label>
                            <input type="number" step="0.01" name="debit" class="form-control bg-light-input"
                                placeholder="0.00">
                        </div>

                        <div class="col-md-2 mb-3">
                            <label>دائن</label>
                            <input type="number" step="0.01" name="credit" class="form-control bg-light-input"
                                placeholder="0.00">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>الوصف</label>
                            <input type="text" name="description" class="form-control" placeholder="تفاصيل القيد">
                        </div>

                        <div class="col-md-1 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- جدول ملخص العملاء --}}
        <div class="card shadow-sm">
            <div class="card-header border-transparent">
                <h3 class="card-title font-weight-bold">جدول البيانات</h3>
                <div class="card-tools">
                    <button id="exportBtn" class="btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-file-excel mr-1"></i> تصدير إكسيل (JS)
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-right">اسم العميل</th>
                                <th>إجمالي المدين</th>
                                <th>إجمالي الدائن</th>
                                <th>الرصيد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grandDebit = 0;
                                $grandCredit = 0;
                                $grandBalance = 0;
                            @endphp

                            @forelse ($customers as $customer)
                                @php
                                    $debit = $customer->total_debit ?? 0;
                                    $credit = $customer->total_credit ?? 0;
                                    $balance = $customer->balance ?? 0;
                                    $grandDebit += $debit;
                                    $grandCredit += $credit;
                                    $grandBalance += $balance;
                                @endphp
                                <tr>
                                    <td class="text-right">
                                        <a href="{{ route('accounts.index', $customer->id) }}" class="font-weight-bold">
                                            {{ $customer->name_ar }}
                                        </a>
                                    </td>
                                    <td class="text-info font-weight-bold">{{ number_format($debit, 2) }}</td>
                                    <td class="text-warning font-weight-bold">{{ number_format($credit, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $balance >= 0 ? 'badge-success' : 'badge-danger' }} px-3 py-2">
                                            {{ number_format($balance, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-5 text-muted">لا توجد بيانات متاحة</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-light-sum font-weight-bold">
                            <tr>
                                <td class="text-right">الإجمالي العام</td>
                                <td class="text-info">{{ number_format($grandDebit, 2) }}</td>
                                <td class="text-warning">{{ number_format($grandCredit, 2) }}</td>
                                <td class="{{ $grandBalance >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($grandBalance, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* تحسينات ليتوافق Select2 مع الـ Dark Mode */
        .dark-mode .select2-selection--single {
            background-color: #343a40 !important;
            border-color: #6c757d !important;
            color: #fff !important;
            height: calc(2.25rem + 2px) !important;
        }

        .dark-mode .select2-selection__rendered {
            color: #fff !important;
            line-height: 1.5 !important;
            padding: .375rem .75rem !important;
        }

        .dark-mode .select2-dropdown {
            background-color: #343a40 !important;
            color: #fff !important;
        }

        .dark-mode .select2-search__field {
            background-color: #3f474e !important;
            color: white !important;
        }

        /* تنسيق عام للحقول */
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
            padding: .375rem .75rem !important;
        }

        /* ألوان مخصصة للفوتر تتغير حسب المود */
        .bg-light-sum {
            background-color: rgba(0, 0, 0, .05);
        }

        .dark-mode .bg-light-sum {
            background-color: rgba(255, 255, 255, .05);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.customer-select').select2({
                placeholder: 'ابحث عن العميل...',
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
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            // 1. تحديد الجدول المراد تصديره
            var table = document.querySelector(".table");

            // 2. تحويل الجدول إلى "Worksheet"
            // نبدأ من صف الرأس وحتى الفوتر
            var wb = XLSX.utils.table_to_book(table, {
                sheet: "ملخص الحسابات"
            });

            // 3. الحصول على التاريخ الحالي لتسمية الملف
            var date = new Date().toISOString().slice(0, 10);
            var fileName = "ملخص_حسابات_العملاء_" + date + ".xlsx";

            // 4. تنفيذ عملية التحميل
            XLSX.writeFile(wb, fileName);
        });
    </script>
@stop
