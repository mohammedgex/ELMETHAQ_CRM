@extends('adminlte::page')

@section('title', 'المناديب')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">المناديب</h1>
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
                <button type="submit" class="btn mt-3 px-4 shadow-sm w-100" style="background-color: #997a44; color: white;">إضافة مندوب</button>
            </form>
        @else
            <h4 class="mb-3 font-weight-bold" style="color: #997a44 !important;">تعديل على "{{ $delegatesEdit->name }}"</h4>
            <form action="{{ route('delegates.edit', $delegatesEdit->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #997a44;">اسم المندوب</label>
                        <input type="text" class="form-control" name="name" value="{{ $delegatesEdit->name }}" placeholder="أدخل اسم المندوب" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold" style="color: #997a44;">رقم الهاتف</label>
                        <input type="text" class="form-control" name="phone" value="{{ $delegatesEdit->phone }}" placeholder="أدخل رقم الهاتف" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="font-weight-bold" style="color: #997a44;">الرقم القومي</label>
                    <input type="text" class="form-control" name="card_id" value="{{ $delegatesEdit->card_id }}" placeholder="أدخل الرقم القومي" required>
                </div>
                <button type="submit" class="btn mt-3 px-4 shadow-sm w-100" style="background-color: #997a44; color: white;">تحديث المندوب</button>
            </form>
        @endif

        <hr>

        <h4 class="mb-3 font-weight-bold" style="color: #997a44;">قائمة المناديب</h4>
        <div class="table-responsive">
            <table class="table table-hover text-center animate__animated animate__fadeInUp">
                <thead class="text-white" style="background: linear-gradient(45deg, #997a44, #7a5e33); border-radius: 10px;">
                    <tr>
                        <th>#</th>
                        <th>اسم المندوب</th>
                        <th>رقم الهاتف</th>
                        <th>الرقم القومي</th>
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
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('Delegates.create', $delegate->id) }}">
                                    <button class="btn btn-sm shadow-sm mx-1" style="border-color: #997a44; color: #997a44;">
                                        <i class="fas fa-edit"></i> تعديل
                                    </button>
                                </a>
                                <form action="{{ route('Delegates.delete', $delegate->id) }}" method="POST" class="mx-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm shadow-sm" style="border-color: #997a44; color: #997a44;" type="submit">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>
                                <button class="btn btn-sm shadow-sm mx-1" style="border-color: #997a44; color: #997a44;">
                                    <i class="fas fa-users"></i> عرض العملاء
                                </button>
                            
                                <div class="btn-group">
        <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item text-success" href="{{ route('Delegates.create', $delegate->id) }}">
                    <i class="fas fa-edit"></i> طباعة تقرير
                </a>
            </li>
            <li>
                <button class="dropdown-item text-success">
                    <i class="fas fa-users"></i> تصدير PDF
                </button>
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
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stop