@extends('adminlte::page')

@section('title', 'قوالب الرسائل')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تعريف قوالب الرسائل</h1>
@stop

@section('content')
    <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" style="border-radius: 15px;">
        <h4 class="mb-3 text-success font-weight-bold" style="color: #997a44 !important;">إضافة مندوب جديد</h4>
        <form action="{{ route('template.create') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 form-group">
                    <label class="font-weight-bold" style="color: #997a44;">عنوان القالب</label>
                    <input type="text" class="form-control" name="title" placeholder="أدخل العنوان" required>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="font-weight-bold" style="color: #997a44;">رسالة القالب</label>
                <textarea name="description" class="form-control" placeholder="اكتب مضمون الرسالة" required></textarea>
            </div>
            <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                style="background-color: #997a44; color: white;">إضافة القالب </button>
        </form>

        <hr>
        <div class="table-responsive">
            <table id="example" class="table table-hover text-center animate__animated animate__fadeInUp">
                <thead class="text-white"
                    style="background: linear-gradient(45deg, #997a44, #7a5e33); border-radius: 10px;">
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>الوصف</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templates as $template)
                        <tr class="table-light">
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->title }}</td>
                            <td title="{{ $template->description }}">
                                {{ \Illuminate\Support\Str::limit($template->description, 100) }}
                            </td>
                            <td class="d-flex justify-content-center">
                                <form action="{{ route('template.delete', $template->id) }}" method="POST" class="mx-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if (Session::has('success'))
        <script>
            Swal.fire({
                title: "تم حفظ بيانات المندوب بنجاح",
                icon: "success",
                confirmButtonText: "تم",
                draggable: true
            });
        </script>
    @endif

    @if (Session::has('edit_success'))
        <script>
            Swal.fire({
                title: "تم تعديل '{{ Session::get('edit_success') }}' بنجاح",
                icon: "success",
                confirmButtonText: "تم",
                draggable: true
            });
        </script>
    @endif

    @if (Session::has('pdf_export'))
        <script>
            Swal.fire({
                title: "تم تصدير '{{ Session::get('pdf_export') }}' بنجاح",
                icon: "success",
                confirmButtonText: "تم",
                draggable: true
            });
        </script>
    @endif
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
