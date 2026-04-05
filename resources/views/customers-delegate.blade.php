@extends('adminlte::page')

@section('title', 'عملاء المندوب')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 style="font-weight:bold;">عملاء المندوب: <span class="text-success">{{ $delegate->name }}</span></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active">عملاء المندوب</li>
            </ol>
        </nav>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body">
            <div class="table-responsive">
                @if ($customers && $customers->count() > 0)
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>المجموعة</th>
                                <th>الحقيبة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td><strong>{{ $customer->name_ar }}</strong></td>
                                    <td><span class="badge badge-info">{{ $customer->phone }}</span></td>
                                    <td>{{ $customer->customerGroup->title ?? '-' }}</td>
                                    <td>{{ $customer->bag->name ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('customer.add', $customer->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center p-5">
                        <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">لا يوجد عملاء مخصصين لهذا المندوب</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- مكتبات DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

    <style>
        /* تحسينات التصميم */
        .card {
            border-radius: 15px !important;
            overflow: hidden;
        }

        .table thead {
            background-color: #343a40;
            color: white;
            text-align: center;
        }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
        }

        /* تنسيق أزرار التصدير لتظهر بشكل أجمل */
        .dt-buttons {
            margin-bottom: 20px !important;
            gap: 5px;
            display: flex;
        }

        .buttons-excel {
            background-color: #28a745 !important;
            border: none !important;
            border-radius: 5px !important;
        }

        .buttons-pdf {
            background-color: #dc3545 !important;
            border: none !important;
            border-radius: 5px !important;
        }

        .buttons-print {
            background-color: #17a2b8 !important;
            border: none !important;
            border-radius: 5px !important;
        }

        /* محاذاة الفلاتر */
        .dataTables_filter {
            text-align: left !important;
        }

        .dataTables_length {
            text-align: right !important;
        }
    </style>
@stop

@section('js')
    {{-- استدعاء ملفات الـ JS بالترتيب الصحيح --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    {{-- أزرار التصدير --}}
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                    {{-- تعريب الجدول بالكامل --}}
                },
                "dom": 'Bfrtip',
                {{-- لتحديد أماكن ظهور الأزرار والفلاتر --}} "buttons": [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> تصدير Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> تصدير PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> طباعة',
                        className: 'btn btn-info'
                    }
                ],
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [
                    [0, "desc"]
                ] {{-- ترتيب تنازلي حسب أول عمود (ID) --}}
            });
        });
    </script>
@stop
