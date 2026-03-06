@extends('adminlte::page')

@section('title', 'إضافة عملية مالية')

@section('content_header')
    <h1 class="m-0 text-dark">تسجيل حركة مالية جديدة</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-success shadow">
                <div class="card-header">
                    <h3 class="card-title text-bold">بيانات العميل والمعاملة</h3>
                </div>

                <form method="POST" action="{{ route('accounts.store') }}">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                    <div class="card-body">
                        <div class="text-center mb-4">
                            @php
                                $imageUrl = $customer->image
                                    ? asset('storage/' . $customer->image)
                                    : asset('vendor/adminlte/dist/img/user-placeholder.jpg');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="Customer Image" class="img-circle elevation-2 shadow"
                                style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #28a745;">
                            <h4 class="mt-2 text-bold">{{ $customer->name_ar }}</h4>
                            <span class="badge badge-secondary">كود العميل: #{{ $customer->id }}</span>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="debit" class="text-danger"><i class="fas fa-minus-circle mr-1"></i> مبلغ
                                        مدين (له)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-success text-white border-0"><i
                                                    class="fas fa-money-bill-wave"></i></span>
                                        </div>
                                        <input type="number" step="0.01" name="debit" id="debit"
                                            class="form-control form-control-lg border-danger" placeholder="0.00"
                                            value="0.00">
                                    </div>
                                    <small class="text-muted">أدخل المبلغ الذي سدده العميل أو أودعه.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit" class="text-success"><i class="fas fa-plus-circle mr-1"></i> مبلغ
                                        دائن (عليه)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-danger text-white border-0"><i
                                                    class="fas fa-cash-register"></i></span>
                                        </div>
                                        <input type="number" step="0.01" name="credit" id="credit"
                                            class="form-control form-control-lg border-success" placeholder="0.00"
                                            value="0.00">
                                    </div>
                                    <small class="text-muted">أدخل المبلغ الذي سحبه العميل أو ذمته المالية.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">وصف العملية / البيان</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                </div>
                                <textarea name="description" id="description" class="form-control" rows="3"
                                    placeholder="اكتب تفاصيل العملية هنا..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm px-5">
                            <i class="fas fa-save mr-1"></i> حفظ العملية
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg shadow-sm px-4 float-right">
                            <i class="fas fa-arrow-left mr-1"></i> رجوع
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* تحسين شكل الإدخال عند التركيز */
        .form-control:focus {
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.2);
        }

        /* تنسيق خاص للوضع الليلي */
        .dark-mode .card-footer {
            background-color: #3f474e !important;
        }

        .dark-mode .input-group-text {
            background-color: #4b545c;
            color: #fff;
            border-color: #6c757d;
        }
    </style>
@stop
