@extends('adminlte::page')

@section('title', 'عرض بيانات العميل المحتمل')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold">
                    <i class="fas fa-id-card text-primary mr-2"></i> تفاصيل العميل المحتمل
                </h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-left">
                    <a href="{{ route('leads-customers.index') }}" class="btn btn-outline-secondary shadow-sm">
                        <i class="fas fa-arrow-right ml-1"></i> رجوع للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-info-circle mr-1"></i> البيانات الأساسية
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 info-group">
                                <label>اسم العميل</label>
                                <p class="form-control-static bg-light p-2 rounded">{{ $lead->name }}</p>
                            </div>
                            <div class="col-md-6 info-group">
                                <label>الوظيفة المقدم عليها</label>
                                <p class="form-control-static bg-light p-2 rounded text-primary font-weight-bold">
                                    {{ $lead->jobTitle->title ?? '---' }}
                                </p>
                            </div>
                            <div class="col-md-4 info-group mt-3">
                                <label>رقم الهاتف</label>
                                <p class="form-control-static bg-light p-2 rounded"><i
                                        class="fas fa-phone-alt mr-1 text-success"></i> {{ $lead->phone }}</p>
                            </div>
                            <div class="col-md-4 info-group mt-3">
                                <label>الرقم القومي</label>
                                <p class="form-control-static bg-light p-2 rounded">{{ $lead->card_id }}</p>
                            </div>
                            <div class="col-md-4 info-group mt-3">
                                <label>السن</label>
                                <p class="form-control-static bg-light p-2 rounded">{{ $lead->age }} عاماً</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-3">
                            <div class="col-md-6 info-group">
                                <label>المندوب المسجل</label>
                                <p class="form-control-static"><span class="badge badge-info p-2"><i
                                            class="fas fa-user-tie mr-1"></i> {{ $lead->delegate->name ?? '-' }}</span></p>
                            </div>
                            <div class="col-md-6 info-group">
                                <label>تاريخ التسجيل</label>
                                <p class="form-control-static text-muted"><i class="far fa-calendar-check mr-1"></i>
                                    {{ $lead->registration_date ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-outline card-info shadow-sm mt-4">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-paperclip mr-1"></i> المستندات والوثائق
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $attachments = [
                                    'الصورة الشخصية' => ['path' => $lead->image, 'icon' => 'fa-user-circle'],
                                    'جواز السفر' => ['path' => $lead->passport_photo, 'icon' => 'fa-passport'],
                                    'البطاقة (أمام)' => ['path' => $lead->img_national_id_card, 'icon' => 'fa-id-card'],
                                    'البطاقة (خلف)' => [
                                        'path' => $lead->img_national_id_card_back,
                                        'icon' => 'fa-id-card-alt',
                                    ],
                                    'إثبات المهنة' => ['path' => $lead->license_photo, 'icon' => 'fa-briefcase'],
                                ];
                            @endphp

                            @foreach ($attachments as $label => $data)
                                @if ($data['path'])
                                    <div class="col-lg-4 col-md-6 mb-4 text-center border-bottom pb-3">
                                        <div class="attachment-preview mb-2">
                                            <img src="{{ asset('storage/' . $data['path']) }}"
                                                class="img-fluid rounded shadow-sm border"
                                                style="height: 120px; width: 100%; object-fit: cover;">
                                        </div>
                                        <small class="d-block font-weight-bold mb-2"><i
                                                class="fas {{ $data['icon'] }} text-muted mr-1"></i>
                                            {{ $label }}</small>
                                        <div class="btn-group w-100">
                                            <a href="{{ asset('storage/' . $data['path']) }}" target="_blank"
                                                class="btn btn-xs btn-outline-info"><i class="fas fa-eye"></i></a>
                                            <a href="{{ asset('storage/' . $data['path']) }}" download
                                                class="btn btn-xs btn-outline-success"><i class="fas fa-download"></i></a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-outline card-warning shadow-sm">
                    <div class="card-header text-center">
                        <h3 class="card-title float-none font-weight-bold"><i class="fas fa-tasks mr-1"></i> تفاصيل التقييم
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush text-right">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>نوع الاختبار</b>
                                <span class="badge badge-warning p-2">{{ $lead->test_type ?? 'لا يوجد' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>التقييم</b>
                                <span class="text-bold text-success">{{ $lead->evaluation ?? 'لم يقيم' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>المحافظة</b>
                                <span>{{ $lead->governorate }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>رقم الجواز</b>
                                <span class="text-muted">{{ $lead->passport_numder ?? '---' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        <style>

        /* تحسين شكل التسميات */
        label {
            color: #555;
            font-size: 0.85rem;
            margin-bottom: 5px;
            display: block;
            font-weight: 600;
        }

        /* تأثيرات على صور المرفقات */
        .attachment-preview img {
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .attachment-preview img:hover {
            transform: scale(1.05);
        }

        /* تخصيص الـ Lists في العمود الأيسر */
        .list-group-item {
            padding: 1rem 1.25rem;
            border-color: rgba(0, 0, 0, 0.05);
        }

        /* تحسين الكروت */
        .card {
            border-radius: 12px;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
        }
    </style>
    </style>
@stop
