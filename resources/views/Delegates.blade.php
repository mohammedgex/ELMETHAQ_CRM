@extends('adminlte::page')

@section('title', 'المناديب')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تعريف المناديب</h1>
@stop

@section('content')
    <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" style="border-radius: 15px;">
        @if ($delegatesEdit->name === '')
            <h4 class="mb-3 font-weight-bold" style="color: #343a40 !important;">إضافة مندوب جديد</h4>
            <form action="{{ route('delegates.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #343a44;">اسم المندوب</label>
                        <input type="text" class="form-control" style="border-color: #343a40;" name="name"
                            placeholder="أدخل اسم المندوب" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #343a44;">رقم الهاتف</label>
                        <input type="text" class="form-control" style="border-color: #343a40;" name="phone"
                            placeholder="أدخل رقم الهاتف" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="font-weight-bold" style="color: #343a44;">الرقم القومي</label>
                    <input type="text" class="form-control" style="border-color: #343a40;" name="card_id"
                        placeholder="أدخل الرقم القومي" required>
                </div>
                <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                    style="background-color: #28a745; color: white;">إضافة مندوب جديد</button>
            </form>
        @else
            <h4 class="mb-3 font-weight-bold" style="color: #997a44 !important;">تعديل على "{{ $delegatesEdit->name }}"</h4>
            <form action="{{ route('delegates.edit', $delegatesEdit->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #997a44;">اسم المندوب</label>
                        <input type="text" class="form-control" name="name" value="{{ $delegatesEdit->name }}"
                            placeholder="أدخل اسم المندوب" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #997a44;">رقم الهاتف</label>
                        <input type="text" class="form-control" name="phone" value="{{ $delegatesEdit->phone }}"
                            placeholder="أدخل رقم الهاتف" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="font-weight-bold" style="color: #997a44;">الرقم القومي</label>
                    <input type="text" class="form-control" name="card_id" value="{{ $delegatesEdit->card_id }}"
                        placeholder="أدخل الرقم القومي" required>
                </div>
                <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                    style="background-color: #28a745; color: white;">تحديث المندوب</button>
            </form>
        @endif

        <hr>

        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #ccc;">
                <h4 class="mb-3" style="color: #343a40; font-weight: bold;">
                    قائمة المناديب <span class="text-success">({{ $delegates->count() }})</span>
                </h4>

                <div class="table-responsive">
                    <table id="example" class="table table-hover text-center animate__animated animate__fadeInUp">
                        <thead style="background-color: #343a40; color: white;">
                            <tr>
                                <th>#</th>
                                <th>اسم المندوب</th>
                                <th>رقم الهاتف</th>
                                <th>الرقم القومي</th>
                                <th>عدد العملاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delegates as $delegate)
                                <tr class="table-light">
                                    <td>{{ $delegate->id }}</td>
                                    <td>{{ $delegate->name }}</td>
                                    <td>{{ $delegate->phone }}</td>
                                    <td>{{ $delegate->card_id }}</td>
                                    <td>
                                        <span class="badge bg-success text-white">
                                            {{ $delegate->customers->count() }} عميل
                                        </span>
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center gap-1">
                                        <a href="{{ route('Delegates.create', $delegate->id) }}"
                                            class="btn btn-sm btn-outline-success shadow-sm" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('Delegates.delete', $delegate->id) }}" method="POST"
                                            class="mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit"
                                                title="حذف" onsubmit="confirmDelete(event)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('customers.filter') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="delegate_id" value="{{ $delegate->id }}">
                                            <button class="btn btn-sm btn-outline-primary shadow-sm" title="عرض العملاء">
                                                <i class="fas fa-users"></i>
                                            </button>
                                        </form>

                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item text-success"
                                                        href="{{ route('export.delegates.xlsx', $delegate->id) }}">
                                                        <i class="fas fa-file-excel"></i> تصدير اكسيل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-warning"
                                                        href="{{ route('export.delegates.pdf', $delegate->id) }}">
                                                        <i class="fas fa-print"></i> طباعة تقرير
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطأ ⚠️',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'حسنًا',
                confirmButtonColor: '#dc2626',
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

    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Prevent form submission
            Swal.fire({
                title: "هل أنت متأكد من الحذف؟",
                text: "سيتم حذف البيانات بالكامل ، هل أنت متأكد ؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "حذف",
                cancelButtonText: "الغاء",
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Submit the form if confirmed
                    Swal.fire({
                        title: "تم الحذف",
                        text: "تم الحذف بنجاح!",
                        confirmButtonText: "تم",
                        icon: "success"
                    });
                }
            });
        }

        $('#example').DataTable({
            dom: 'Bfrtip', // تخصيص ترتيب العناصر
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel"></i> تصدير إلى Excel',
                    className: 'buttons-excel'
                },

                {
                    extend: 'print',
                    text: '<i class="fa fa-file-pdf"></i> طباعة',
                    className: 'buttons-pdf',
                },

            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            },
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
        });
    </script>
@stop
