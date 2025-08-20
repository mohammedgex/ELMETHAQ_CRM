@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    <h1>العملاء في حقيبة ({{ $bag->name }})</h1>
    {{-- مكتبات select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop

@section('content')
    <div class="container-fluid customers-page">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow border-0 customers-card">
                    <div class="card-body">

                        {{-- مجموعة الأزرار العلوية --}}
                        <div class="btn-group mb-3">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                عمليات
                            </button>
                            <ul class="dropdown-menu shadow-lg rounded-3 border-0">
                                {{-- السويس --}}
                                <li>
                                    <a href="{{ route('reports.transaction_statement_suez', $bag->id) }}" target="_blank"
                                        class="dropdown-item d-flex justify-content-between align-items-center text-success fw-bold">
                                        <div>
                                            <i class="fas fa-file-alt me-2"></i>
                                            كشف معاملات السويس
                                        </div>
                                        <span class="badge bg-success rounded-pill">
                                            {{ $bag->customers->filter(fn($c) => $c->customerGroup?->visaType?->embassy?->title === 'السويس')->count() }}
                                        </span>
                                    </a>
                                </li>

                                {{-- القاهرة --}}
                                <li>
                                    <a href="{{ route('reports.transaction_statement_cairo', $bag->id) }}" target="_blank"
                                        class="dropdown-item d-flex justify-content-between align-items-center text-primary fw-bold">
                                        <div>
                                            <i class="fas fa-file-alt me-2"></i>
                                            كشف معاملات القاهرة
                                        </div>
                                        <span class="badge bg-primary rounded-pill">
                                            {{ $bag->customers->filter(fn($c) => $c->customerGroup?->visaType?->embassy?->title === 'القاهرة')->count() }}
                                        </span>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        {{-- الجدول --}}
                        <div class="table-responsive">
                            <table class="table table-hover text-center customers-table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th width="40px">
                                            <input type="checkbox" id="checkAll" class="form-check-input">
                                        </th>
                                        <th>كود العميل</th>
                                        <th>اسم العميل</th>
                                        <th>الصورة</th>
                                        <th>الهاتف</th>
                                        <th>الكشف الطبي</th>
                                        <th>البصمة</th>
                                        <th>كشف المعامل</th>
                                        <th>إنجاز</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr
                                            class="{{ $customer->blackList && $customer->blackList->block ? 'bg-light-danger' : 'bg-light' }}">
                                            <td style="position: relative !important;">
                                                <input
                                                    style="position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);"
                                                    class="form-check-input row-checkbox width-input" type="checkbox"
                                                    class="form-check-input centered-checkbox">
                                            </td>
                                            <td>#{{ $customer->id }}</td>
                                            <td>
                                                <a href="{{ route('customer.add', $customer->id) }}"
                                                    class="text-primary fw-bold">
                                                    {{ $customer->name_ar }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $customer->image) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $customer->image) }}" width="40"
                                                        height="40" class="img-circle border" alt="صورة">
                                                </a>
                                            </td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>
                                                {!! $customer->medical_examination == 'تم الحجز'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                {!! $customer->finger_print_examination == 'تم تصدير الاكسيل'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                {!! $customer->virus_examination == 'تم اصدار ايصال المعامل'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                {!! $customer->engaz_request == 'تم الحجز'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                <div class="btn-group dropstart">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('reports.show', $customer->id) }}"><i
                                                                    class="fas fa-file-alt text-primary me-2"></i> عرض
                                                                التقارير</a>
                                                        </li>
                                                        @if ($customer->phone != null)
                                                            <li>
                                                                <a class="dropdown-item text-success"
                                                                    href="https://wa.me/{{ '20' . ltrim($customer->phone, '0') }}"
                                                                    target="_blank" rel="noopener noreferrer">
                                                                    <i class="fab fa-whatsapp"></i>
                                                                    تواصل عبر واتساب
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> {{-- نهاية الجدول --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('swal_errors'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'حدثت بعض الأخطاء',
                html: `{!! implode('<br>', session('swal_errors')) !!}`,
            });
        </script>
    @endif


    <style>
        /* ألوان وتنسيقات خاصة بالصفحة فقط */
        .customers-page .customers-card {
            border-radius: 12px;
        }

        .customers-page .customers-table thead {
            background: linear-gradient(45deg, #2c3e50, #3498db);
            color: #fff;
        }

        .customers-page .customers-table thead th {
            vertical-align: middle;
            font-weight: 600;
        }

        .customers-page .customers-table tbody tr:hover {
            background-color: #f1f5f9 !important;
            transition: background-color 0.2s ease;
        }

        .customers-page .img-circle {
            border-radius: 50%;
            object-fit: cover;
        }

        .customers-page .fw-bold {
            font-weight: 600 !important;
        }

        .customers-page .dropdown-menu {
            font-size: 14px;
        }
    </style>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        .form-check-input {
            width: 16px;
            height: 16px;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.4em 0.6em;
        }

        .checkbox-header {
            position: relative;
            padding: 0 !important;
            text-align: center;
            vertical-align: middle;
        }

        .form-check-input {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#dataTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                pageLength: 50
            });

            // تحديد الكل
            document.getElementById("checkAll").addEventListener("change", function() {
                document.querySelectorAll("#dataTable .row-checkbox").forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        });
    </script>
@stop
