@extends('adminlte::page')

@section('title', 'عرض بيانات العميل المحتمل')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-right font-weight-bold">عرض بيانات العميل : {{ $lead->name }}</h1>
        <a href="{{ route('leads-customers.index') }}">
            <button type="submit" class="btn btn-success btn-block font-weight-bold">
                رجوع الي العملاء المحتملون
            </button>
        </a>
    </div>
@stop

@section('content')
    <div class="card card-primary card-outline shadow">
        <div class="card-body">
            <div class="row">
                <!-- معلومات العميل الأساسية -->
                <x-adminlte-input name="name" label="اسم العميل" value="{{ $lead->name }}" fgroup-class="col-md-6"
                    disabled />
                <x-adminlte-input name="job" label="الوظيفة المقدم عليها" value="{{ $lead->jobTitle->title }}"
                    fgroup-class="col-md-6" disabled />
                <x-adminlte-input name="age" label="السن" value="{{ $lead->age }}" fgroup-class="col-md-4"
                    disabled />
                <x-adminlte-input name="phone" label="رقم الهاتف" value="{{ $lead->phone }}" fgroup-class="col-md-4"
                    disabled />
                <x-adminlte-input name="card_id" label="الرقم القومي" value="{{ $lead->card_id }}" fgroup-class="col-md-4"
                    disabled />
                <x-adminlte-input name="delegate" label="المندوب" value="{{ $lead->delegate->name ?? '-' }}"
                    fgroup-class="col-md-6" disabled />
                <x-adminlte-input name="passport_numder" label="رقم الجواز" value="{{ $lead->passport_numder ?? '-' }}"
                    fgroup-class="col-md-6" disabled />
                <x-adminlte-input name="date_of_birth" label="تايرخ الميلاد" value="{{ $lead->date_of_birth }}"
                    fgroup-class="col-md-6" disabled />
            </div>

            <!-- عرض الملفات -->
            <x-adminlte-card title="الملفات المرفقة" theme="light" icon="fas fa-paperclip" class="mt-4">
                <div class="row">
                    @php
                        $attachments = [
                            'الصورة الشخصية' => $lead->image,
                            'جواز السفر' => $lead->passport_photo,
                            'بطاقة الرقم القومي من الامام' => $lead->img_national_id_card,
                            'بطاقة الرقم القومي من الخلف' => $lead->img_national_id_card_back,
                            'صورة اثبات المهنة' => $lead->license_photo,
                        ];
                    @endphp
                    @foreach ($attachments as $label => $path)
                        <div class="col-md-6 d-flex align-items-center mb-3">
                            <img src="{{ asset('storage/' . $path) }}" class="img-thumbnail mr-3" width="100"
                                height="120">
                            <div>
                                <label class="font-weight-bold d-block">{{ $label }}</label>
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="btn btn-sm btn-info mb-1">
                                    <i class="fas fa-eye"></i> عرض
                                </a>
                                <a href="{{ asset('storage/' . $path) }}" download class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> تحميل
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-adminlte-card>

            <!-- معلومات إضافية -->
            <div class="row">
                <x-adminlte-input name="test_type" label="نوع الاختبار" value="{{ $lead->test_type }}"
                    fgroup-class="col-md-6" disabled />
                <x-adminlte-input name="evaluation" label="التقييم" value="{{ $lead->evaluation }}" fgroup-class="col-md-6"
                    disabled />
                <x-adminlte-input name="governorate" label="المحافظة" value="{{ $lead->governorate }}"
                    fgroup-class="col-md-6" disabled />
                <x-adminlte-input name="registration_date" label="موعد التسجيل" value="{{ $lead->registration_date }}"
                    fgroup-class="col-md-6" disabled />
            </div>
        </div>
    </div>
@stop
