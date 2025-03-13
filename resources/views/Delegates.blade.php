@extends('adminlte::page')

@section('title', 'المناديب')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تعريف المناديب</h1>
@stop

@section('content')
    <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" style="border-radius: 15px;">
        @if ($delegatesEdit->name === '')
            <h4 class="mb-3 text-success font-weight-bold" style="color: #997a44 !important;">إضافة مندوب جديد</h4>
            <form action="{{ route('delegates.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #997a44;">اسم المندوب</label>
                        <input type="text" class="form-control" name="name" placeholder="أدخل اسم المندوب" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #997a44;">رقم الهاتف</label>
                        <input type="text" class="form-control" name="phone" placeholder="أدخل رقم الهاتف" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="font-weight-bold" style="color: #997a44;">الرقم القومي</label>
                    <input type="text" class="form-control" name="card_id" placeholder="أدخل الرقم القومي" required>
                </div>
                <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                    style="background-color: #997a44; color: white;">إضافة مندوب جديد</button>
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
                    style="background-color: #ffc107; color: white;">تحديث المندوب</button>
            </form>
        @endif

        <hr>

        <h4 class="mb-3 text-dark font-weight-bold">
            قائمة المناديب <span class="text-success"> ({{$delegates->count()}})</span>
        </h4>
            <div class="table-responsive">
            <table class="table table-hover text-center animate__animated animate__fadeInUp">
                <thead class="text-white"
                    style="background: linear-gradient(45deg, #997a44, #7a5e33); border-radius: 10px;">
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
                            <td class="highlight"><span class="badge bg-success text-white">{{$delegate->customers->count()}} عميل</span></td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('Delegates.create', $delegate->id) }}">
                                    <button class="btn btn-sm btn-outline-success shadow-sms">
                                        <i class="fas fa-edit"></i> تعديل
                                    </button>
                                </a>
                                <form action="{{ route('Delegates.delete', $delegate->id) }}" method="POST"
                                    class="mx-1" onsubmit="confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit" >
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>
                                <button class="btn btn-sm btn-outline-primary shadow-sm mx-1" >
                                    <i class="fas fa-users"></i> عرض العملاء
                                </button>

                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-success"
                                                href="{{ route('export.delegates.xlsx', $delegate->id) }}">
                                                <i class="fas fa-edit"></i> تصدير اكسيل
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-warning"
                                                href="{{ route('export.delegates.pdf', $delegate->id) }}">
                                                <i class="fas fa-edit"></i> طباعة تقرير
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger">
                                                <i class="fas fa-users"></i> بلاك ليست
                                            </button>
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
                title: "تم تعديل '{{Session::get('edit_success')}}' بنجاح",
                icon: "success",
                  confirmButtonText: "تم",
                draggable: true
                });
            </script>
            @endif

            @if (Session::has('pdf_export'))
            <script>
                    Swal.fire({
                    title: "تم تصدير '{{Session::get('pdf_export')}}' بنجاح",
                    icon: "success",
                    confirmButtonText: "تم",
                    draggable: true
                    });
            </script>
            @endif

            
        






@stop

@section('css')

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
        .table-responsive{
            overflow: visible !important;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    </script>
@stop
