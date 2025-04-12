@extends('adminlte::page')

@section('title', 'عرض بيانات العميل')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> عرض بيانات العميل</h1>
@stop

@section('content')
    <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
        style="border-radius: 15px; background-color: #f8f9fa;">

        <div class="row">
            <!-- اسم العميل -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> اسم العميل </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0"> {{ $lead->name }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- الوظيفة المقدم عليها -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> الوظيفة المقدم عليها </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0"> {{ $lead->jobTitle->title }} </p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- السن -->
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold"> السن </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0">{{ $lead->age }} </p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- رقم الهاتف -->
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold"> رقم الهاتف </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0"> {{ $lead->phone }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- الرقم القومي -->
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold"> الرقم القومي </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0"> {{ $lead->card_id }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- المندوب -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> المندوب </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0">{{ $lead->delegate->name }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- نوع الرخصة -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> نوع الرخصة </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0">{{ $lead->licence_type }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- تحميل الملفات -->
            <section class="card shadow-sm p-4 border-0 mt-4 w-100" style="border-radius: 15px; background-color: #ffffff;">
                <h4 class="mb-3 text-dark font-weight-bold text-center border p-2 rounded"
                    style="border: 2px solid #997a44; display: inline-block;">
                    الملفات المرفقة
                </h4>
                <div class="row">
                    @php
                        $files = [
                            [
                                'label' => 'الصورة الشخصية',
                                'url' => asset('storage/' . $lead->image),
                            ],
                            [
                                'label' => 'صورة جواز السفر',
                                'url' => asset('storage/' . $lead->passport_photo),
                            ],
                            [
                                'label' => 'بطاقة الرقم القومي',
                                'url' => asset('storage/' . $lead->img_national_id_card),
                            ],
                            [
                                'label' => 'صورة الرخصة',
                                'url' => asset('storage/' . $lead->license_photo),
                            ],
                        ];
                    @endphp

                    <div class="col-md-6 d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/' . $lead->image) }}" class="border rounded p-1" alt=""
                            width="100" height="120">
                        <div class="ml-3">
                            <label class="font-weight-bold d-block">الصورة الشخصية</label>
                            <a href="{{ asset('storage/' . $lead->image) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> عرض
                            </a>
                            <a href="{{ asset('storage/' . $lead->image) }}" download class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> تحميل
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/' . $lead->passport_photo) }}" class="border rounded p-1"
                            alt="" width="100" height="120">
                        <div class="ml-3">
                            <label class="font-weight-bold d-block">صورة جواز السفر</label>
                            <a href="{{ asset('storage/' . $lead->passport_photo) }}" target="_blank"
                                class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> عرض
                            </a>
                            <a href="{{ asset('storage/' . $lead->passport_photo) }}" download
                                class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> تحميل
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/' . $lead->img_national_id_card) }}" class="border rounded p-1"
                            alt="" width="100" height="120">
                        <div class="ml-3">
                            <label class="font-weight-bold d-block">بطاقة الرقم القومي</label>
                            <a href="{{ asset('storage/' . $lead->img_national_id_card) }}" target="_blank"
                                class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> عرض
                            </a>
                            <a href="{{ asset('storage/' . $lead->img_national_id_card) }}" download
                                class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> تحميل
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/' . $lead->license_photo) }}" class="border rounded p-1"
                            alt="" width="100" height="120">
                        <div class="ml-3">
                            <label class="font-weight-bold d-block">صورة الرخصة</label>
                            <a href="{{ asset('storage/' . $lead->license_photo) }}" target="_blank"
                                class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> عرض
                            </a>
                            <a href="{{ asset('storage/' . $lead->license_photo) }}" download
                                class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> تحميل
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- نوع الاختبار -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> نوع الاختبار </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0">{{ $lead->test_type }} </p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- التقييم -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> التقييم </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0">{{ $lead->evaluation }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- المحافظة -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> المحافظة </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0">{{ $lead->governorate }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <!-- موعد التسجيل -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> موعد التسجيل </label>
                <div class="input-group rounded">
                    <p id="textToCopy" class="form-control border-0 m-0"> {{ $lead->registration_date }}</p>
                    <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- أزرار التحكم -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('leads-customers.update', $lead->id) }}"
                class="btn btn-primary shadow-sm flex-grow-1 mx-2 text-center">
                <i class="fas fa-edit"></i> تعديل
            </a>
            <a href="#" class="btn btn-secondary shadow-sm flex-grow-1 mx-2 text-center">
                <i class="fas fa-arrow-left"></i> رجوع
            </a>
            <form action="{{ route('leads-customers.delete', $lead->id) }}" method="POST" class="flex-grow-1 mx-2"
                onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger shadow-sm w-100 text-center">
                    <i class="fas fa-trash-alt"></i> حذف
                </button>
            </form>
        </div>


    </div>
@stop

@section('css')
    <style>
        .form-control {
            border-radius: 10px;
            padding: 12px;
            height: auto;
            border: 1px solid #ced4da;
            background-color: #e9ecef;
            font-weight: bold;
        }
    </style>
@stop

@section('js')
    <script>
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                let text = this.previousElementSibling.innerText;
                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'تم النسخ!',
                        text: text,
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });
        });
    </script>
@stop
