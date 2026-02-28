@extends('adminlte::page')

@section('title', 'ملخص حسابات العملاء')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center px-3">
        <h1 class="m-0 font-weight-bold page-main-title">
            <i class="fas fa-file-invoice-dollar mr-2 text-primary"></i> ملخص حسابات العملاء
        </h1>
    </div>
@stop

@section('content')
    <div class="container-fluid pb-5">

        {{-- التنبيهات --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm shadow-sm-custom">
                <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- كارد الإضافة --}}
        <div class="card card-outline card-primary shadow-sm border-0 mb-4 custom-card">
            <div class="card-header border-0 bg-transparent">
                <h3 class="card-title font-weight-bold"><i class="fas fa-edit mr-1 text-primary"></i> إضافة قيد جديد</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body bg-form-section">
                <form method="POST" action="{{ route('accounts.store') }}">
                    @csrf
                    <input type="hidden" id="group_id" value="{{ $group_id }}">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3 text-right">
                            <label class="small font-weight-bold mb-2">اسم العميل</label>
                            <select name="customer_id" class="form-control customer-select" required></select>
                        </div>
                        <div class="col-md-2 mb-3 text-right">
                            <label class="small font-weight-bold text-info mb-2">مدين (له)</label>
                            <input type="number" step="0.01" name="debit"
                                class="form-control shadow-sm border-0-light" placeholder="0.00">
                        </div>
                        <div class="col-md-2 mb-3 text-right">
                            <label class="small font-weight-bold text-warning mb-2">دائن (عليه)</label>
                            <input type="number" step="0.01" name="credit"
                                class="form-control shadow-sm border-0-light" placeholder="0.00">
                        </div>
                        <div class="col-md-4 mb-3 text-right">
                            <label class="small font-weight-bold mb-2">البيان / الوصف</label>
                            <input type="text" name="description" class="form-control shadow-sm border-0-light"
                                placeholder="تفاصيل العملية...">
                        </div>
                        <div class="col-md-1 mb-3">
                            <button type="submit" class="btn btn-primary btn-block shadow ripple-btn">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- الكارد الرئيسي للجدول --}}
        <div class="card shadow-sm border-0 overflow-hidden custom-card">
            <div class="card-header bg-navy d-flex align-items-center py-3">
                <h3 class="card-title font-weight-bold mb-0 flex-grow-1">
                    <i class="fas fa-users-cog mr-2 text-warning"></i> جدول أرصدة العملاء
                </h3>
                <div class="card-tools">
                    <button id="exportBtn" class="btn btn-sm btn-success px-3 font-weight-bold shadow-sm border-0">
                        <i class="fas fa-file-excel mr-1"></i> Excel
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="accountsTable" class="table m-0 table-hover table-valign-middle text-center">
                        <thead>
                            <tr class="thead-custom-row">
                                <th style="width: 50px;">#</th>
                                <th class="text-left px-4">اسم العميل</th>
                                <th>الحالة</th>
                                <th style="width: 160px;">عدد الاختبارات</th>
                                <th>إجمالي المدين</th>
                                <th>إجمالي الدائن</th>
                                <th>الرصيد النهائي</th>
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
                                    <td class="text-muted small">#{{ $loop->iteration }}</td>
                                    <td class="text-left font-weight-bold px-4">
                                        <a href="{{ route('accounts.index', $customer->id) }}" class="customer-link">
                                            {{ $customer->name_ar }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline-secondary px-2 text-white">
                                            {{ $customer->experience ?? '---' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if (empty($customer->notes) || $customer->notes == 0)
                                            <div class="notes-edit input-group input-group-sm mx-auto"
                                                style="max-width: 120px;" data-id="{{ $customer->id }}">
                                                <input type="number" class="form-control notes-input" placeholder="0">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary notes-save"><i
                                                            class="fas fa-check"></i></button>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge badge-pill badge-info px-3 py-2 notes-badge shadow-sm"
                                                data-id="{{ $customer->id }}">
                                                <i class="fas fa-vial mr-1"></i> {{ $customer->notes }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-info font-weight-bold">{{ number_format($debit, 2) }}</td>
                                    <td class="text-warning font-weight-bold">{{ number_format($credit, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $balance >= 0 ? 'badge-success' : 'badge-danger' }} balance-pill">
                                            {{ number_format($balance, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-5 text-muted">لا توجد بيانات متاحة</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($customers->count() > 0)
                            <tfoot class="bg-footer-row">
                                <tr class="font-weight-bold">
                                    <td colspan="4" class="text-right pr-4">الإجمالي العام</td>
                                    <td class="text-info text-md">{{ number_format($grandDebit, 2) }}</td>
                                    <td class="text-warning text-md">{{ number_format($grandCredit, 2) }}</td>
                                    <td class="{{ $grandBalance >= 0 ? 'text-success' : 'text-danger' }} text-md">
                                        {{ number_format($grandBalance, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* الأساسيات */
        .page-main-title {
            font-size: 1.5rem;
            color: #333;
        }

        .bg-form-section {
            background-color: #f8f9fa;
        }

        .bg-navy {
            background-color: #001f3f !important;
            color: white;
        }

        .custom-card {
            border-radius: 12px !important;
        }

        /* التنسيق للوضع الفاتح */
        .thead-custom-row th {
            background-color: #f1f3f5;
            color: #495057;
            border-top: 0;
            padding: 15px 5px;
            font-size: 0.9rem;
        }

        .bg-footer-row {
            background-color: #f8f9fa;
            border-top: 2px solid #dee2e6;
        }

        .customer-link {
            color: #2c3e50;
            text-decoration: none !important;
            transition: 0.3s;
        }

        .customer-link:hover {
            color: #007bff;
        }

        .balance-pill {
            min-width: 90px;
            border-radius: 50px;
            padding: 8px 12px;
            font-size: 0.85rem;
            shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .badge-outline-secondary {
            border: 1px solid #dee2e6;
            color: #777;
            background: transparent;
        }

        /* تعديلات ذكية للوضع المظلم (Dark Mode) */
        .dark-mode .page-main-title {
            color: #fff;
        }

        .dark-mode .bg-form-section {
            background-color: #343a40 !important;
        }

        .dark-mode .thead-custom-row th {
            background-color: #3f474e;
            color: #eee;
        }

        .dark-mode .bg-footer-row {
            background-color: #3f474e;
            border-top: 2px solid #56606a;
        }

        .dark-mode .customer-link {
            color: #ecf0f1;
        }

        .dark-mode .customer-link:hover {
            color: #3498db;
        }

        .dark-mode .card-header.bg-white {
            background-color: #343a40 !important;
            color: #fff;
        }

        .dark-mode .border-0-light {
            background-color: #3f474e !important;
            color: #fff;
            border: 0 !important;
        }

        /* تحسين Select2 لكلا الوضعين */
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border-radius: 6px !important;
            border-color: #ced4da !important;
        }

        .dark-mode .select2-selection--single {
            background-color: #3f474e !important;
            color: #fff !important;
            border-color: #56606a !important;
        }

        .dark-mode .select2-selection__rendered {
            color: #fff !important;
            line-height: 25px !important;
        }

        .dark-mode .select2-dropdown {
            background-color: #3f474e !important;
            color: #fff !important;
        }

        /* تأثيرات إضافية */
        .ripple-btn {
            transition: all 0.2s ease;
        }

        .ripple-btn:active {
            transform: scale(0.95);
        }

        .notes-badge {
            transition: 0.2s;
            cursor: pointer;
        }

        .notes-badge:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // تهيئة Select2
            $('.customer-select').select2({
                placeholder: 'بحث عن عميل...',
                dir: "rtl",
                ajax: {
                    url: "{{ route('ajax.customers.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        q: params.term,
                        group_id: $('#group_id').val()
                    }),
                    processResults: data => ({
                        results: data
                    })
                },
                minimumInputLength: 1,
                width: '100%'
            });

            // حفظ الملاحظات Ajax

            $(document).ready(function() {
                // الضغط على زر الحفظ
                $(document).on('click', '.notes-save', function() {
                    saveNotes($(this).closest('.notes-edit'));
                });

                // الضغط على Enter داخل الـ input
                $(document).on('keypress', '.notes-input', function(e) {
                    if (e.which === 13) { // 13 هو كود Enter
                        e.preventDefault(); // منع السلوك الافتراضي (مثل إرسال form)
                        saveNotes($(this).closest('.notes-edit'));
                    }
                });

                // دالة الحفظ العامة
                function saveNotes(container) {
                    var customerId = container.data('id');
                    var notes = container.find('.notes-input').val();

                    if (notes.trim() === '') {
                        alert('الرجاء إدخال الملاحظات');
                        return;
                    }

                    $.ajax({
                        url: '{{ route('customers.updateNotes') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: customerId,
                            notes: notes
                        },
                        success: function(res) {
                            container.replaceWith(
                                `<span class="badge badge-pill badge-info px-3 notes-text" data-id="${customerId}">${notes}</span>`
                            );
                        },
                        error: function(err) {
                            alert('حدث خطأ أثناء الحفظ');
                        }
                    });
                }

            });

            // تصدير إكسيل
            $('#exportBtn').click(function() {
                const table = document.getElementById("accountsTable");
                const wb = XLSX.utils.table_to_book(table, {
                    sheet: "الحسابات"
                });
                XLSX.writeFile(wb, `Report_${new Date().toLocaleDateString()}.xlsx`);
            });
        });
    </script>
@stop
