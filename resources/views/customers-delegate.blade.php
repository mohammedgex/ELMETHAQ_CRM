@extends('adminlte::page')

@section('title', 'عملاء المندوب')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">عملاء المندوب ({{ $delegate->name }})</h1>
@stop

@section('content')
    <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" style="border-radius: 15px;">
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #ccc;">

                <div class="table-responsive">
                    @if ($customers && $customers->count() > 0)
                        <table id="example" class="table table-hover text-center animate__animated animate__fadeInUp">
                            <thead style="background-color: #343a40; color: white;">
                                <tr>
                                    <th>#</th>
                                    <th>اسم</th>
                                    <th>رقم الهاتف</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr class="table-light">
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->name_ar }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td class="d-flex justify-content-center align-items-center gap-1">
                                            <a href="{{ route('customer.add', $customer->id) }}"
                                                class="btn btn-sm btn-outline-success shadow-sm" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h1 class="text-center">لا توجد عملاء</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <style>
        /* تحسين إدخال البيانات */
        .form-control {
            border-radius: 10px;
            padding: 12px;
            height: 50px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        /* تحسين الجدول */
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
            transition: 0.3s ease-in-out;
        }

        /* تحسين الأزرار */
        .btn {
            transition: all 0.3s ease-in-out;
            font-weight: bold;

        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* تحسين البطاقة */
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-responsive {
            overflow: visible !important;
        }

        /* تحسين مظهر الجدول */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100%;
            background-color: #fff;
            font-size: 16px;
            text-align: center;
        }

        table.dataTable thead {
            background-color: #007bff;
            color: #fff;
        }

        table.dataTable tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table.dataTable tbody tr:hover {
            background-color: #d9edf7;
        }

        /* تنسيق أزرار التصدير */
        .dt-buttons {
            margin-bottom: 10px;
        }

        .dt-button {
            padding: 8px 15px;
            margin: 5px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons-excel {
            background-color: #28a745 !important;
            color: white !important;
        }

        .buttons-pdf {
            background-color: #dc3545 !important;
            color: white !important;
        }

        /* تحسين حقل البحث */
        .dataTables_filter {
            text-align: left !important;
            margin-bottom: 15px;
        }

        .dataTables_filter input {
            width: 250px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
@stop
