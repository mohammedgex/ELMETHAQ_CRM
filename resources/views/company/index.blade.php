@extends('adminlte::page')

@section('title', 'إعدادات الشركة')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">إعدادات الشركة</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #f8f9fa;">
                <h4 class="mb-3 text-dark font-weight-bold">معلومات الشركة</h4>
                <form action="{{ route('company.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">اسم الشركة</label>
                            <input type="text" class="form-control" name="name" value="{{ $company->name ?? '' }}"
                                required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">العنوان</label>
                            <input type="text" class="form-control" name="address" value="{{ $company->address ?? '' }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">رقم الترخيص</label>
                            <input type="text" class="form-control" name="license_number"
                                value="{{ $company->license_number ?? '' }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">البريد الإلكتروني لإنجاز</label>
                            <input type="email" class="form-control" name="engaz_email"
                                value="{{ $company->engaz_email ?? '' }}" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">كلمة المرور لإنجاز</label>
                            <input type="text" class="form-control" name="engaz_password"
                                value="{{ $company->engaz_password ?? '' }}" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold d-block mb-2">شعار الشركة</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="file" class="form-control" name="logo" style="max-width: 70%;">
                                @if ($company && $company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="شعار الشركة"
                                        style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover; margin-right: 10px">
                                @endif
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                        style="background-color: #997a44; color: white;">
                        حفظ الإعدادات
                    </button>
                </form>
            </div>
        </div>

        @if (Session::has('success'))
            <script>
                Swal.fire({
                    title: "{{ Session::get('success') }}",
                    icon: "success",
                    confirmButtonText: "تم",
                    draggable: true
                });
            </script>
        @endif
    </div>
@stop

@section('css')
    <style>
        .form-control {
            border-radius: 10px;
            padding: 12px;
            height: 50px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #997a44;
            box-shadow: 0 0 8px rgba(153, 122, 68, 0.3);
        }

        .btn {
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@stop
