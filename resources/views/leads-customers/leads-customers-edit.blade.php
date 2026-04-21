@extends('adminlte::page')

@section('title', 'تعديل العميل المحتمل')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark font-weight-bold">
                    <i class="fas fa-user-edit text-primary mr-2"></i>
                    تعديل العميل: <span class="text-primary">{{ $lead->name }}</span>
                </h1>
            </div>

            <div class="col-sm-6">
                <div class="float-sm-left d-flex align-items-center">
                    <a href="{{ route('leads-customers.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm mr-2">
                        <i class="fas fa-arrow-right ml-1"></i> رجوع للقائمة
                    </a>

                    {{-- اختياري: إضافة Breadcrumb لتحسين التنقل --}}
                    <ol class="breadcrumb float-sm-right bg-transparent m-0 p-0 ml-3 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads-customers.index') }}">العملاء</a></li>
                        <li class="breadcrumb-item active">تعديل</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary card-outline shadow">
        <div class="card-body">
            <div>
                <form id="myForm" action="{{ route('leads-customers.edit', $lead->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- معلومات أساسية --}}
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0 mb-4 rounded-lg overflow-hidden">
                                <div
                                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-id-card-alt fa-lg ml-2"></i>
                                        <strong class="h5 mb-0">بيانات العميل الأساسية</strong>
                                    </div>

                                    @if ($history && $history->first())
                                        <div class="badge badge-pill badge-light py-2 px-3 shadow-sm">
                                            <i class="fas fa-user-edit text-primary ml-1"></i>
                                            <span class="text-dark">أنشأه:
                                                {{ $history->first()->user?->name ?? 'غير محدد' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body bg-white">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="font-weight-bold text-secondary">الاسم الكامل</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-left-0"><i
                                                            class="fas fa-user text-primary"></i></span>
                                                </div>
                                                <input type="text" id="name"
                                                    class="form-control border-2 shadow-none" name="name"
                                                    value="{{ $lead->name }}" placeholder="أدخل الاسم رباعي">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label class="font-weight-bold text-secondary">الوظيفة المقدم عليها</label>
                                            <select class="form-control custom-select border-2" name="job_title_id"
                                                id="job_title_select">
                                                <option value="">اختر الوظيفة...</option>
                                                @foreach ($jobs as $job)
                                                    <option value="{{ $job->id }}"
                                                        {{ $lead->job_title_id == $job->id ? 'selected' : '' }}>
                                                        {{ $job->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label class="font-weight-bold text-secondary">السن</label>
                                            <input type="number" id="age" class="form-control border-2 shadow-sm"
                                                name="age" value="{{ $lead->age }}">
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label class="font-weight-bold text-secondary">رقم الهاتف الأساسي</label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control border-2 {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                                    name="phone" value="{{ $lead->phone }}">
                                                <div class="input-group-append">
                                                    <a href="{{ route('reset.password.lead', $lead->id) }}"
                                                        class="btn btn-warning font-weight-bold shadow-sm"
                                                        title="إعادة تعيين الباسورد">
                                                        <i class="fas fa-key"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @if ($errors->has('phone'))
                                                <small
                                                    class="text-danger font-weight-bold">{{ $errors->first('phone') }}</small>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label class="font-weight-bold text-secondary">رقم هاتف إضافي</label>
                                            <input type="text"
                                                class="form-control border-2 {{ $errors->has('phone_two') ? 'is-invalid' : '' }}"
                                                name="phone_two" value="{{ $lead->phone_two }}">
                                            @if ($errors->has('phone_two'))
                                                <small
                                                    class="text-danger font-weight-bold">{{ $errors->first('phone_two') }}</small>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label class="font-weight-bold text-secondary">الرقم القومي</label>
                                            <input type="text" class="form-control border-2 shadow-sm" id="card_id"
                                                name="card_id" value="{{ $lead->card_id }}">
                                            @if ($errors->has('card_id'))
                                                <small
                                                    class="text-danger font-weight-bold">{{ $errors->first('card_id') }}</small>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label class="font-weight-bold text-secondary">رقم جواز السفر</label>
                                            <input type="text" class="form-control border-2 shadow-sm"
                                                id="passport_numder" name="passport_numder"
                                                value="{{ $lead->passport_numder }}">
                                        </div>

                                        <div class="form-group col-md-4 mb-3">
                                            <label class="font-weight-bold text-secondary">تاريخ الميلاد</label>
                                            <input type="date" class="form-control border-2 shadow-sm"
                                                id="date_of_birth" name="date_of_birth"
                                                value="{{ $lead->date_of_birth ? (\Carbon\Carbon::hasFormat($lead->date_of_birth, 'Y-m-d') ? $lead->date_of_birth : \Carbon\Carbon::createFromFormat('d/m/Y', $lead->date_of_birth)->format('Y-m-d')) : '' }}">
                                            @if ($errors->has('date_of_birth'))
                                                <small
                                                    class="text-danger font-weight-bold">{{ $errors->first('date_of_birth') }}</small>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="font-weight-bold text-secondary"><i
                                                    class="fas fa-sticky-note text-warning ml-1"></i> ملاحظات
                                                إضافية</label>
                                            <textarea name="notes" class="form-control border-2 shadow-sm" rows="2" placeholder="أدخل ملاحظاتك هنا...">{{ old('notes', $lead->notes ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- معلومات إضافية --}}
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0 mb-4 rounded-lg overflow-hidden">
                                <div class="card-header bg-info text-white d-flex align-items-center py-3">
                                    <i class="fas fa-info-circle fa-lg ml-2"></i>
                                    <strong class="h5 mb-0">تفاصيل إضافية والتعيين</strong>
                                </div>

                                <div class="card-body bg-white">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label class="font-weight-bold text-secondary">
                                                <i class="fas fa-user-tie text-info ml-1"></i> المندوب المسؤول
                                            </label>
                                            @if ($lead->delegate_id == null && $lead->licence_type)
                                                <span class="badge badge-warning-light mb-1 mr-2 text-dark">
                                                    <i class="fas fa-id-badge ml-1"></i> ({{ $lead->licence_type }})
                                                </span>
                                            @endif
                                            <select
                                                class="form-control custom-select border-2 shadow-none {{ !auth()->user()?->permissions->contains('permission', 'delegates-settings') ? 'bg-light cursor-not-allowed' : '' }}"
                                                name="delegate_id" @if (!auth()->user()?->permissions->contains('permission', 'delegates-settings')) disabled @endif>
                                                <option value="">اختر المندوب...</option>
                                                @foreach ($delegates as $delegate)
                                                    <option value="{{ $delegate->id }}"
                                                        {{ $lead->delegate_id == $delegate->id ? 'selected' : '' }}>
                                                        {{ $delegate->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label class="fw-bold text-secondary mb-2">
                                                <i class="fas fa-money-bill-wave text-info ml-1"></i>
                                                نوع المعاملة المالية
                                            </label>

                                            <select
                                                class="form-control select2 custom-select custom-dark-select border-2 shadow-none"
                                                name="payment_title_id[]" multiple
                                                style="width: 100%; min-height: 60px; border-radius: 8px;"
                                                @if (!auth()->user()?->permissions->contains('permission', 'financial-matters')) disabled @endif>

                                                <option value="" disabled>اختر النوع...</option>

                                                @foreach ($paymentTitles as $payment)
                                                    <option value="{{ $payment->id }}"
                                                        {{ isset($lead) && in_array($payment->id, optional($lead->paymentTitles)->pluck('id')->toArray() ?? []) ? 'selected' : '' }}>
                                                        {{ $payment->title }} — ({{ number_format($payment->price, 0) }}
                                                        ج.م)
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('payment_title_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label class="font-weight-bold text-secondary">
                                                <i class="fas fa-map-marker-alt text-info ml-1"></i> المحافظة
                                            </label>
                                            <select class="form-control custom-select border-2 shadow-none"
                                                id="governorate" name="governorate">
                                                <option value="">اختر المحافظة...</option>
                                                @foreach ($governorates as $gov)
                                                    <option value="{{ $gov }}"
                                                        {{ $lead->governorate == $gov ? 'selected' : '' }}>
                                                        {{ $gov }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label class="font-weight-bold text-secondary">
                                                <i class="fas fa-calendar-alt text-info ml-1"></i> موعد التسجيل
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-left-0"><i
                                                            class="fas fa-clock text-info"></i></span>
                                                </div>
                                                <input type="date" class="form-control border-2 shadow-none"
                                                    name="registration_date" value="{{ $lead->registration_date }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- أسئلة الوظيفة --}}
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0 mb-4 rounded-lg overflow-hidden">
                                <div class="card-header bg-secondary text-white d-flex align-items-center py-3"
                                    style="background: linear-gradient(45deg, #6c757d, #495057) !important;">
                                    <i class="fas fa-question-circle fa-lg ml-2"></i>
                                    <strong class="h5 mb-0">أسئلة التأهيل للوظيفة</strong>
                                </div>

                                <div class="card-body bg-white p-4" id="job-questions">
                                    <div class="row">
                                        @foreach ($questions as $index => $q)
                                            @php
                                                $answer = $lead->answers->where('job_question_id', $q->id)->first();
                                                $oldValue = $answer ? $answer->answer : '';
                                                $options = $q->options ? json_decode($q->options, true) : [];
                                            @endphp

                                            <div
                                                class="col-md-12 mb-4 p-3 rounded-sm shadow-none border-bottom hover-bg-light transition-all">
                                                <label class="form-label d-block mb-3">
                                                    <span class="badge badge-secondary ml-2">{{ $index + 1 }}</span>
                                                    <span class="font-weight-bold text-dark h6">{{ $q->question }}</span>
                                                </label>

                                                <div class="answer-container pr-md-4">
                                                    @switch($q->type)
                                                        @case('text')
                                                            <input type="text" name="questions[{{ $q->id }}]"
                                                                class="form-control border-2" value="{{ $oldValue }}"
                                                                placeholder="اكتب الإجابة هنا...">
                                                        @break

                                                        @case('textarea')
                                                            <textarea name="questions[{{ $q->id }}]" class="form-control border-2" rows="3"
                                                                placeholder="اكتب تفاصيل الإجابة..."></textarea>
                                                        @break

                                                        @case('number')
                                                            <div class="input-group" style="max-width: 250px;">
                                                                <input type="number" name="questions[{{ $q->id }}]"
                                                                    class="form-control border-2 text-center"
                                                                    value="{{ $oldValue }}">
                                                            </div>
                                                        @break

                                                        @case('date')
                                                            <div class="input-group" style="max-width: 250px;">
                                                                <input type="date" name="questions[{{ $q->id }}]"
                                                                    class="form-control border-2" value="{{ $oldValue }}">
                                                            </div>
                                                        @break

                                                        @case('select')
                                                            <select name="questions[{{ $q->id }}]"
                                                                class="form-control custom-select border-2 shadow-none pr-4"
                                                                style="max-width: 400px;">
                                                                <option value="">-- اختر من القائمة --</option>
                                                                @foreach ($options as $opt)
                                                                    <option value="{{ $opt }}"
                                                                        {{ $oldValue == $opt ? 'selected' : '' }}>
                                                                        {{ $opt }}</option>
                                                                @endforeach
                                                            </select>
                                                        @break

                                                        @case('radio')
                                                            <div class="d-flex flex-wrap gap-4 mt-2">
                                                                @foreach ($options as $opt)
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio"
                                                                            id="radio_{{ $q->id }}_{{ $loop->index }}"
                                                                            name="questions[{{ $q->id }}]"
                                                                            class="custom-control-input"
                                                                            value="{{ $opt }}"
                                                                            {{ $oldValue == $opt ? 'checked' : '' }}>
                                                                        <label class="custom-control-label mr-4 cursor-pointer"
                                                                            for="radio_{{ $q->id }}_{{ $loop->index }}">{{ $opt }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @break

                                                        @case('checkbox')
                                                            @php $oldValues = explode(',', $oldValue); @endphp
                                                            <div class="d-flex flex-wrap gap-4 mt-2">
                                                                @foreach ($options as $opt)
                                                                    <div
                                                                        class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox"
                                                                            id="check_{{ $q->id }}_{{ $loop->index }}"
                                                                            name="questions[{{ $q->id }}][]"
                                                                            class="custom-control-input"
                                                                            value="{{ $opt }}"
                                                                            {{ in_array($opt, $oldValues) ? 'checked' : '' }}>
                                                                        <label class="custom-control-label mr-4 cursor-pointer"
                                                                            for="check_{{ $q->id }}_{{ $loop->index }}">{{ $opt }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @break
                                                    @endswitch
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- تحسين تخطيط قسم الصور -->
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-header bg-warning text-dark d-flex align-items-center py-3">
                                    <i class="fas fa-images fa-lg ml-2"></i>
                                    <h5 class="mb-0 font-weight-bold">المستندات والصور</h5>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">

                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                                <div class="card-body p-3 d-flex flex-column">
                                                    <label for="dd" class="font-weight-bold text-dark mb-3">
                                                        <i class="fas fa-user-circle text-muted mr-2"></i>الصورة الشخصية
                                                    </label>

                                                    <div class="custom-file mb-3">
                                                        <input type="file" name="image"
                                                            class="custom-file-input preview-image-input"
                                                            data-preview="#preview_image" id="dd"
                                                            accept="image/*">
                                                        <label class="custom-file-label" for="dd text-truncate">اختر
                                                            الصورة</label>
                                                    </div>

                                                    <div id="preview_image"
                                                        class="border rounded d-flex align-items-center justify-content-center bg-white"
                                                        style="height: 220px; position: relative;">
                                                        <img src="{{ $lead->image ? asset('storage/' . $lead->image) : 'https://via.placeholder.com/150x150?text=الصورة+الشخصية' }}"
                                                            class="img-fluid rounded-circle shadow-sm"
                                                            style="max-height: 180px; width: 180px; object-fit: cover; display: {{ $lead->image ? 'block' : 'none' }} !important;"
                                                            alt="Preview">
                                                        @if (!$lead->image)
                                                            <div class="text-muted placeholder-text text-center">
                                                                <i class="fas fa-camera fa-2x mb-2"></i>
                                                                <p class="small mb-0">لم يتم اختيار صورة</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-block btn-sm mt-auto crop-image-btn"
                                                        data-input="#dd" data-preview="#preview_image">
                                                        <i class="fas fa-crop-alt mr-1"></i> تعديل واقتصاص
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                                <div class="card-body p-3 d-flex flex-column">
                                                    <label for="passportInput" class="font-weight-bold text-primary mb-3">
                                                        <i class="fas fa-passport mr-2"></i>صورة جواز السفر
                                                    </label>

                                                    <div class="custom-file mb-3">
                                                        <input type="file" name="passport_photo"
                                                            class="custom-file-input preview-image-input"
                                                            data-preview="#preview_passport_photo" id="passportInput"
                                                            accept="image/*">
                                                        <label class="custom-file-label"
                                                            for="passportInput">الملف...</label>
                                                    </div>

                                                    <div id="preview_passport_photo"
                                                        class="border rounded d-flex align-items-center justify-content-center bg-white"
                                                        style="height: 220px;">
                                                        <img id="imagePreviewpass"
                                                            src="{{ $lead->passport_photo ? asset('storage/' . $lead->passport_photo) : 'https://via.placeholder.com/150x150?text=صورة+جواز+السفر' }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="max-height: 200px; object-fit: contain; display: {{ $lead->passport_photo ? 'block' : 'none' }} !important;"
                                                            alt="Preview">
                                                        @if (!$lead->passport_photo)
                                                            <div class="text-muted placeholder-text text-center">
                                                                <i class="fas fa-passport fa-2x mb-2"></i>
                                                                <p class="small mb-0">يرجى رفع الجواز</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="mt-3 d-flex gap-2">
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-sm flex-grow-1 crop-image-btn"
                                                            data-input="#passportInput"
                                                            data-preview="#preview_passport_photo">
                                                            <i class="fas fa-crop-alt"></i> اقتصاص
                                                        </button>
                                                        <button type="button" id="analyzeBtn"
                                                            class="btn btn-success btn-sm flex-grow-1 ml-1">
                                                            <i class="fas fa-magic"></i> فك البيانات
                                                        </button>
                                                    </div>

                                                    <div id="passportInput_loader" class="text-center mt-2"
                                                        style="display: none;">
                                                        <div class="spinner-border spinner-border-sm text-primary"
                                                            role="status"></div>
                                                        <span class="small text-primary ml-1"
                                                            id="passportInput_loader_text">جاري التحليل...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                                <div class="card-body p-3 d-flex flex-column">
                                                    <label for="ff" class="font-weight-bold text-success mb-3">
                                                        <i class="fas fa-certificate mr-2"></i>إثبات مهنة
                                                    </label>

                                                    <div class="custom-file mb-3">
                                                        <input type="file" name="license_photo"
                                                            class="custom-file-input preview-image-input"
                                                            data-preview="#preview_license_photo" id="ff">
                                                        <label class="custom-file-label" for="ff">اختر الملف</label>
                                                    </div>

                                                    <div id="preview_license_photo"
                                                        class="border rounded d-flex align-items-center justify-content-center bg-white"
                                                        style="height: 220px;">
                                                        <img src="{{ $lead->license_photo ? asset('storage/' . $lead->license_photo) : 'https://via.placeholder.com/150x150?text=إثبات+المهنة' }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="max-height: 200px; object-fit: contain; display: {{ $lead->license_photo ? 'block' : 'none' }} !important;"
                                                            alt="Preview">
                                                        @if (!$lead->license_photo)
                                                            <div class="text-muted placeholder-text text-center">
                                                                <i class="fas fa-file-signature fa-2x mb-2"></i>
                                                                <p class="small mb-0">شهادة أو رخصة</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-block btn-sm mt-auto crop-image-btn"
                                                        data-input="#ff" data-preview="#preview_license_photo">
                                                        <i class="fas fa-crop-alt mr-1"></i> اقتصاص
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr class="my-4">

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body">
                                                    <label for="ss" class="font-weight-bold text-info mb-3">
                                                        <i class="fas fa-id-card mr-2"></i>بطاقة الرقم القومي (الأمام)
                                                    </label>
                                                    <div class="custom-file mb-3">
                                                        <input type="file" name="img_national_id_card"
                                                            class="custom-file-input preview-image-input"
                                                            data-preview="#preview_img_national_id_card" id="ss"
                                                            accept="image/*">
                                                        <label class="custom-file-label" for="ss">الوجه
                                                            الأمامي</label>
                                                    </div>
                                                    <div id="preview_img_national_id_card"
                                                        class="border rounded d-flex align-items-center justify-content-center bg-white mb-2"
                                                        style="height: 180px;">
                                                        <img src="{{ $lead->img_national_id_card ? asset('storage/' . $lead->img_national_id_card) : 'https://via.placeholder.com/200x120?text=البطاقة+من+الأمام' }}"
                                                            class="img-fluid rounded"
                                                            style="max-height: 160px; object-fit: contain; display: {{ $lead->img_national_id_card ? 'block' : 'none' }} !important;"
                                                            alt="Preview">
                                                        @if (!$lead->img_national_id_card)
                                                            <i class="fas fa-image fa-2x text-light"></i>
                                                        @endif
                                                    </div>
                                                    <button type="button"
                                                        class="btn btn-light btn-block btn-sm border crop-image-btn"
                                                        data-input="#ss" data-preview="#preview_img_national_id_card">
                                                        <i class="fas fa-crop-alt text-primary"></i> اقتصاص الوجه الأمامي
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body">
                                                    <label for="aa" class="font-weight-bold text-info mb-3">
                                                        <i class="fas fa-id-card mr-2"></i>بطاقة الرقم القومي (الخلف)
                                                    </label>
                                                    <div class="custom-file mb-3">
                                                        <input type="file" name="img_national_id_card_back"
                                                            class="custom-file-input preview-image-input"
                                                            data-preview="#preview_img_national_id_card_back"
                                                            id="aa" accept="image/*">
                                                        <label class="custom-file-label" for="aa">الوجه
                                                            الخلفي</label>
                                                    </div>
                                                    <div id="preview_img_national_id_card_back"
                                                        class="border rounded d-flex align-items-center justify-content-center bg-white mb-2"
                                                        style="height: 180px;">
                                                        <img src="{{ $lead->img_national_id_card_back ? asset('storage/' . $lead->img_national_id_card_back) : 'https://via.placeholder.com/200x120?text=البطاقة+من+الخلف' }}"
                                                            class="img-fluid rounded"
                                                            style="max-height: 160px; object-fit: contain; display: {{ $lead->img_national_id_card_back ? 'block' : 'none' }} !important;"
                                                            alt="Preview">
                                                        @if (!$lead->img_national_id_card_back)
                                                            <i class="fas fa-image fa-2x text-light"></i>
                                                        @endif
                                                    </div>
                                                    <button type="button"
                                                        class="btn btn-light btn-block btn-sm border crop-image-btn"
                                                        data-input="#aa"
                                                        data-preview="#preview_img_national_id_card_back">
                                                        <i class="fas fa-crop-alt text-primary"></i> اقتصاص الوجه الخلفي
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            /* تحسينات إضافية للتصميم */
                            .card {
                                transition: transform 0.2s ease-in-out;
                                border-radius: 12px;
                            }

                            .card:hover {
                                transform: translateY(-3px);
                            }

                            .custom-file-label::after {
                                content: "رفع" !important;
                                background-color: #f8f9fa;
                            }

                            .preview-image-input:focus~.custom-file-label {
                                border-color: #ffc107;
                                box-shadow: none;
                            }

                            .btn-sm {
                                border-radius: 8px;
                                font-weight: 500;
                            }

                            .spinner-border-sm {
                                width: 1rem;
                                height: 1rem;
                            }

                            #preview_image img {
                                border: 3px solid #fff;
                            }
                        </style>

                        {{-- زر الحفظ --}}
                        <div class="col-md-12">
                            <button type="submit" id="save-button" class="btn btn-success btn-block font-weight-bold">
                                <i class="fas fa-save ml-2"></i> حفظ التعديلات
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="history mt-4">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 font-weight-bold text-primary">
                            <i class="fas fa-history mr-2"></i> سجل النشاطات والتاريخ
                        </h5>
                    </div>

                    <div class="card-body p-0">
                        @if ($lead->historis && $lead->historis->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th class="border-0 px-4" style="width: 5%">#</th>
                                            <th class="border-0" style="width: 20%">المستخدم</th>
                                            <th class="border-0" style="width: 45%">الإجراء / الوصف</th>
                                            <th class="border-0 text-center" style="width: 30%">التوقيت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lead->historis->sortByDesc('created_at') as $index => $item)
                                            <tr>
                                                <td class="px-4 text-muted">{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm mr-2 bg-soft-primary text-primary rounded-circle text-center"
                                                            style="width:30px; height:30px; line-height:30px; background: #eef2f7;">
                                                            <i class="fas fa-user-circle"></i>
                                                        </div>
                                                        <span class="font-weight-600 text-dark">
                                                            {{ $item->user->name ?? 'نظام آلي' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="description-text">
                                                        <i class="fas fa-chevron-left fa-xs text-primary mr-2"></i>
                                                        {{ $item->description }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex flex-column text-right pr-3">
                                                        <span class="text-dark font-weight-bold"
                                                            style="font-size: 0.9rem;">
                                                            <i class="far fa-calendar-alt ml-1 text-muted"></i>
                                                            {{ $item->created_at ? $item->created_at->format('Y-m-d') : '---' }}
                                                        </span>
                                                        <small class="text-muted">
                                                            <i class="far fa-clock ml-1"></i>
                                                            {{ $item->created_at ? $item->created_at->diffForHumans() : '' }}
                                                            ({{ $item->created_at->format('g:i A') }})
                                                        </small>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 bg-light">
                                <img src="https://cdn-icons-png.flaticon.com/512/1376/1376786.png" width="80"
                                    class="opacity-50 mb-3" alt="No History">
                                <h6 class="text-muted font-weight-bold">لا توجد سجلات حتى الآن</h6>
                                <p class="text-muted small">سيظهر تاريخ تفاعل العميل هنا بمجرد البدء.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-overlay"
        style="display: none; position: fixed; z-index: 9999; top:0; left:0; width:100%; height:100%; background: rgba(255,255,255,0.8);">
        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
            <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                <span class="sr-only">جارٍ التحميل...</span>
            </div>
        </div>
    </div>

    <!-- نافذة اقتصاص محسّنة متوافقة مع Bootstrap 4 -->
    <div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 90vw;">
            <div class="modal-content" style="height: 80vh;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="cropperModalLabel">
                        <i class="fas fa-crop-alt mr-2"></i>
                        اقتصاص الصورة
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0 bg-dark d-flex align-items-center justify-content-center"
                    style="height: calc(100% - 130px); overflow: hidden;">
                    <img id="cropperImage" style="max-width: 100%; max-height: 100%; display: block;">
                </div>

                <div class="modal-footer d-flex justify-content-between flex-wrap">
                    <div class="btn-group mb-2 mb-md-0" role="group">
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomIn" title="تكبير">
                            <i class="fas fa-search-plus"></i> تكبير
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomOut" title="تصغير">
                            <i class="fas fa-search-minus"></i> تصغير
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="rotateLeft" title="تدوير">
                            <i class="fas fa-undo"></i> تدوير
                        </button>
                        <button type="button" class="btn btn-info btn-sm" id="reset" title="إعادة ضبط">
                            <i class="fas fa-refresh"></i> إعادة ضبط
                        </button>
                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            <i class="fas fa-times"></i> إلغاء
                        </button>
                        <button type="button" id="cropConfirm" class="btn btn-success">
                            <i class="fas fa-check"></i> تأكيد الاقتصاص
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if ($error)
        <script>
            Swal.fire({
                icon: 'error',
                title: 'فشلت',
                text: '{{ $error }}',
                confirmButtonText: 'حسناً'
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'نجاح',
                text: '{{ session('success') }}',
                confirmButtonText: 'حسناً'
            });
        </script>
    @endif
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* تحسينات CSS للمودال وتخطيط الصور */
        #cropperModal .modal-content {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        #cropperImage {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .preview-image-input+.custom-file-label::after {
            content: "تصفح";
        }

        .form-group.shadow-sm {
            transition: all 0.3s ease;
        }

        .form-group.shadow-sm:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-2px);
        }

        .crop-image-btn {
            transition: all 0.3s ease;
        }

        .crop-image-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        #analyzeBtn {
            transition: all 0.3s ease;
        }

        #analyzeBtn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        /* تحسين مظهر الصورة الشخصية */
        #preview_image img {
            border-radius: 50% !important;
            border: 3px solid #17a2b8;
            width: 120px !important;
            height: 120px !important;
            object-fit: cover;
        }

        #preview_image img:hover {
            border-color: #138496;
            transform: scale(1.05);
        }

        [id^="preview_"] {
            transition: all 0.3s ease;
            position: relative;
        }

        [id^="preview_"] img {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        [id^="preview_"] img:hover {
            border-color: #007bff;
            transform: scale(1.02);
        }

        /* تحسين الألوان */
        .card-header.bg-warning {
            background: linear-gradient(45deg, #ffc107, #fd7e14) !important;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }

        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            border: none;
        }

        /* محمل دوار محسّن */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .spinner-border {
            width: 2rem;
            height: 2rem;
        }

        /* تحسين responsiveness */
        @media (max-width: 768px) {
            #cropperModal .modal-dialog {
                max-width: 95vw;
                margin: 10px auto;
            }

            #cropperModal .modal-content {
                height: 90vh;
            }

            .modal-footer {
                flex-direction: column;
                gap: 10px;
            }

            .btn-group {
                width: 100%;
            }

            .btn-group .btn {
                flex: 1;
            }
        }

        /* تأثير عند السحب */
        .border-primary {
            border: 2px dashed #007bff !important;
            background: #f0f8ff;
            transition: 0.2s;
        }

        /* ستايل للمربعات القابلة للصق */
        .paste-zone:focus {
            outline: 2px dashed #007bff;
            outline-offset: 4px;
        }

        /* رأس الجدول - يتماشى مع الثيم */
        .custom-thead {
            background-color: var(#f8f9fa);
            color: var(#212529);
        }

        .custom-thead th {
            border-color: var(#dee2e6);
            font-weight: 600;
        }

        /* الإعدادات الافتراضية (Light Mode) */
        :root {
            --select-bg: #ffffff;
            --select-text: #333333;
            --select-border: #dee2e6;
            --select-shadow: rgba(0, 0, 0, 0.05);
            --select-option-hover: #f8f9fa;
        }

        /* إعدادات الدارك مود (بيشتغل لو البودي عليه كلاس dark أو حسب إعدادات الويندوز) */
        [data-theme="dark"],
        .dark-mode {
            --select-bg: #2b2b2b;
            --select-text: #e0e0e0;
            --select-border: #444444;
            --select-shadow: rgba(0, 0, 0, 0.3);
            --select-option-hover: #3d3d3d;
        }

        /* تطبيق الاستايل على Select2 */
        .custom-dark-select+.select2-container .select2-selection--multiple {
            background-color: var(--select-bg) !important;
            border: 2px solid var(--select-border) !important;
            border-radius: 8px !important;
            color: var(--select-text) !important;
            padding: 5px !important;
        }

        /* تظبيط شكل الـ Tags المختارة (Choices) */
        .custom-dark-select+.select2-container .select2-selection__choice {
            background-color: #007bff !important;
            /* لون أزرق براند */
            border: none !important;
            color: #fff !important;
            border-radius: 4px !important;
            padding: 2px 8px !important;
        }

        /* تظبيط القائمة المنسدلة نفسها */
        .select2-dropdown {
            background-color: var(--select-bg) !important;
            border: 1px solid var(--select-border) !important;
            color: var(--select-text) !important;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: var(--select-option-hover) !important;
            color: var(--select-text) !important;
        }

        /* حالة الـ Disabled */
        .custom-dark-select:disabled+.select2-container .select2-selection--multiple {
            background-color: #e9ecef !important;
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // إصلاح مشاكل اقتصاص الصورة
        // إصلاح مشاكل اقتصاص الصورة
        let cropper;
        let currentInputFile = null;
        let currentPreviewId = null;
        const cropperModal = document.getElementById("cropperModal");
        const cropperImage = document.getElementById("cropperImage");

        // معالج اختيار الصورة وعرضها في المعاينة
        document.querySelectorAll('.preview-image-input').forEach(input => {
            const previewSelector = input.getAttribute('data-preview');
            const previewDiv = document.querySelector(previewSelector);
            const previewImg = previewDiv.querySelector('img');
            const placeholderText = previewDiv.querySelector('.text-muted');

            // عرض الصورة الموجودة مسبقًا إذا كانت موجودة
            if (previewImg && previewImg.src && !previewImg.src.includes('placeholder')) {
                previewImg.style.display = 'block';
                if (placeholderText) placeholderText.style.display = 'none';
            } else {
                previewImg.style.display = 'none';
                if (placeholderText) placeholderText.style.display = 'block';
            }

            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                        if (placeholderText) placeholderText.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    // إذا لم يتم اختيار صورة جديدة
                    if (previewImg.src && !previewImg.src.includes('placeholder')) {
                        previewImg.style.display = 'block';
                        if (placeholderText) placeholderText.style.display = 'none';
                    } else {
                        previewImg.style.display = 'none';
                        if (placeholderText) placeholderText.style.display = 'block';
                    }
                }

                // تحديث label كما هو موجود في الكود الحالي
                const label = this.nextElementSibling;
                if (label && this.files[0]) {
                    label.textContent = this.files[0].name;
                } else if (label) {
                    const inputId = this.id;
                    switch (inputId) {
                        case 'dd':
                            label.textContent = 'اختر الصورة الشخصية';
                            break;
                        case 'passportInput':
                            label.textContent = 'اختر صورة جواز السفر';
                            break;
                        case 'ff':
                            label.textContent = 'اختر صورة إثبات المهنة';
                            break;
                        case 'ss':
                            label.textContent = 'اختر صورة البطاقة من الأمام';
                            break;
                        case 'aa':
                            label.textContent = 'اختر صورة البطاقة من الخلف';
                            break;
                        default:
                            label.textContent = 'اختر صورة';
                    }
                }
            });
        });

        // معالج أزرار الاقتصاص
        document.querySelectorAll(".crop-image-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const inputSelector = this.getAttribute("data-input");
                const previewSelector = this.getAttribute("data-preview");

                currentInputFile = document.querySelector(inputSelector);
                currentPreviewId = previewSelector;

                const previewDiv = document.querySelector(previewSelector);
                const previewImg = previewDiv.querySelector('img');

                // إذا لم يتم اختيار ملف جديد، استخدم الصورة الحالية
                if (!currentInputFile.files[0] && previewImg && previewImg.src && !previewImg.src.includes(
                        'placeholder')) {
                    cropperImage.src = previewImg.src;
                    $(cropperModal).modal('show');
                    return;
                }

                if (!currentInputFile.files[0]) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تنبيه',
                        text: 'اختر صورة أولاً قبل الاقتصاص!',
                        confirmButtonText: 'حسناً'
                    });
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    $(cropperModal).modal('show');
                };
                reader.readAsDataURL(currentInputFile.files[0]);
            });
        });

        // تهيئة Cropper عند فتح المودال
        $(cropperModal).on('shown.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            cropper = new Cropper(cropperImage, {
                aspectRatio: NaN, // حرية الاقتصاص
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.8,
                responsive: true,
                restore: false,
                guides: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                minCropBoxWidth: 50,
                minCropBoxHeight: 50,
                ready: function() {
                    console.log('Cropper ready');
                }
            });
        });

        // تنظيف Cropper عند إغلاق المودال
        $(cropperModal).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        // زر تأكيد الاقتصاص
        document.getElementById("cropConfirm").addEventListener("click", function() {
            if (cropper && currentPreviewId && currentInputFile) {
                const canvas = cropper.getCroppedCanvas({
                    width: 800,
                    height: 600,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });

                canvas.toBlob(function(blob) {
                    if (!blob) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'فشل في اقتصاص الصورة',
                            confirmButtonText: 'حسناً'
                        });
                        return;
                    }

                    const fileName = (currentInputFile.files[0]?.name) || 'cropped_image.jpg';
                    const file = new File([blob], fileName, {
                        type: "image/jpeg",
                        lastModified: Date.now()
                    });

                    // إذا لم يكن هناك ملف جديد في input، نضيف الملف الجديد
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentInputFile.files = dataTransfer.files;

                    // تحديث المعاينة
                    const previewDiv = document.querySelector(currentPreviewId);
                    const previewImg = previewDiv.querySelector('img');
                    const placeholderText = previewDiv.querySelector('.text-muted');

                    if (previewImg) {
                        previewImg.src = URL.createObjectURL(file);
                        previewImg.style.display = "block";
                        if (placeholderText) placeholderText.style.display = 'none';
                    }

                    // تحديث label
                    const label = currentInputFile.nextElementSibling;
                    if (label) {
                        label.textContent = fileName;
                    }

                    // إغلاق المودال
                    $(cropperModal).modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'تم',
                        text: 'تم اقتصاص الصورة بنجاح',
                        timer: 2000,
                        showConfirmButton: false
                    });

                }, "image/jpeg", 0.9);
            }
        });


        // أدوات التحكم في Cropper
        document.getElementById("zoomIn").addEventListener("click", function() {
            if (cropper) {
                cropper.zoom(0.1);
            }
        });

        document.getElementById("zoomOut").addEventListener("click", function() {
            if (cropper) {
                cropper.zoom(-0.1);
            }
        });

        document.getElementById("rotateLeft").addEventListener("click", function() {
            if (cropper) {
                cropper.rotate(-90);
            }
        });

        document.getElementById("reset").addEventListener("click", function() {
            if (cropper) {
                cropper.reset();
            }
        });

        // إضافة زر إغلاق للمودال
        document.querySelector('#cropperModal .btn-close, #cropperModal [data-bs-dismiss="modal"]')?.addEventListener(
            'click',
            function() {
                $(cropperModal).modal('hide');
            });

        // معالج تحميل النموذج
        document.getElementById('myForm').addEventListener('submit', function() {
            document.getElementById('loading-overlay').style.display = 'block';
            document.getElementById('save-button').disabled = true;
        });

        // Animation للـ loader
        const style = document.createElement('style');
        style.textContent = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                
                .custom-file-input:focus ~ .custom-file-label {
                    border-color: #007bff;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                }
                
                .crop-image-btn:hover {
                    background-color: #0056b3;
                }
                
                #cropperModal .modal-body {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            `;
        document.head.appendChild(style);
    </script>

    <script type="module">
        function calculateAge(dateOfBirthStr) {
            // تحويل التاريخ إلى أجزاء
            const [day, month, year] = dateOfBirthStr.split('/').map(Number);
            const birthDate = new Date(year, month - 1, day);
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();

            // لو لسه ما جاش تاريخ الميلاد في السنة الحالية
            const hasBirthdayPassedThisYear =
                today.getMonth() > birthDate.getMonth() ||
                (today.getMonth() === birthDate.getMonth() && today.getDate() >= birthDate.getDate());

            if (!hasBirthdayPassedThisYear) {
                age--;
            }

            return age;
        }

        import {
            GoogleGenerativeAI
        } from "https://esm.sh/@google/generative-ai";

        const genAI = new GoogleGenerativeAI("{{ env('GOOGLE_API_KEY') }}");

        async function fileToBase64(file) {
            const buffer = await file.arrayBuffer();
            const bytes = new Uint8Array(buffer);
            let binary = "";
            bytes.forEach((b) => binary += String.fromCharCode(b));
            return btoa(binary);
        }

        // ✅ للـ Blob اللي جاي من fetch
        async function blobToBase64(blob) {
            const buffer = await blob.arrayBuffer();
            const bytes = new Uint8Array(buffer);
            let binary = "";
            bytes.forEach((b) => binary += String.fromCharCode(b));
            return btoa(binary);
        }

        async function convertImageUrlToBase64(url) {
            const response = await fetch(url);
            const blob = await response.blob();
            return await blobToBase64(blob); // ✨ هنا التعديل
        }


        document.getElementById("analyzeBtn").addEventListener("click", async () => {
            document.getElementById("passportInput_loader").style.display = "block";
            document.getElementById("passportInput_loader_text").style.display = "block";
            const fileInput = document.getElementById("passportInput");
            const file = fileInput.files[0];
            const imageUrl = document.getElementById('imagePreviewpass')?.src || "";

            let base64Image, mimeType;

            if (file) {
                // ✅ لو فيه ملف مرفوع
                base64Image = await fileToBase64(file);
                mimeType = file.type;
            } else if (imageUrl && (imageUrl.startsWith("data:") || imageUrl.startsWith("http"))) {
                // ✅ لو فيه صورة في الـ preview
                base64Image = await convertImageUrlToBase64(imageUrl);
                mimeType = imageUrl.endsWith(".png") ? "image/png" : "image/jpeg";
            } else {
                // ❌ لو مفيش أي صورة
                Swal.fire({
                    title: "اختر صورة جواز السفر اولا",
                    icon: "error",
                    draggable: true
                });
                document.getElementById("passportInput_loader").style.display = "none";
                document.getElementById("passportInput_loader_text").style.display = "none";
                return;
            }

            try {
                // const base64Image = await fileToBase64(file);
                const model = genAI.getGenerativeModel({
                    model: "gemini-2.5-flash"
                });
                const prompt = `"Extract all information from the passport image with high accuracy, ensuring no errors, and present the output as a JSON object. The JSON should include the following keys:

                    passport_no

                    type

                    country_code

                    full_name_english

                    full_name_arabic (ensure 'ماهر' is one word, e.g., 'ماهر محمد عبدالعزيز مرسي')

                    date_of_birth

                    place_of_birth (must be one of: 'القاهرة', 'الجيزة', 'الأسكندرية', 'الدقهلية', 'البحر الأحمر', 'البحيرة', 'الفيوم', 'الغربية', 'الإسماعيلية', 'المنوفية', 'المنيا', 'القليوبية', 'الوادي الجديد', 'السويس', 'أسوان', 'أسيوط', 'بني سويف', 'بورسعيد', 'دمياط', 'الشرقية', 'جنوب سيناء', 'كفر الشيخ', 'مطروح', 'الأقصر', 'قنا', 'شمال سيناء', 'سوهاج','السعودية', 'القدس', 'الأردن', 'العراق', 'لبنان', 'فلسطين', 'اليمن', 'عمان', 'الإمارات العربية المتحدة', 'الكويت', 'قطر', 'البحرين')

                    nationality

                    sex

                    date_of_issue

                    date_of_expiry

                    issuing_office

                    national_id (should be in Western/English numerals, e.g., '28101191800397')

                    profession

                    mrz_lines (an array containing each line of the Machine Readable Zone)

                    Example of desired JSON structure:

                    JSON

                    {
                    "passport_no": "VALUE",
                    "type": "VALUE",
                    "country_code": "VALUE",
                    "full_name_english": "VALUE",
                    "full_name_arabic": "VALUE",
                    "date_of_birth": "VALUE",
                    "place_of_birth": "VALUE_FROM_LIST",
                    "nationality": "VALUE",
                    "sex": "VALUE",
                    "date_of_issue": "VALUE",
                    "date_of_expiry": "VALUE",
                    "issuing_office": "VALUE",
                    "national_id": "VALUE_IN_ENGLISH_NUMERALS",
                    "profession": "VALUE",
                    "mrz_lines": [
                        "VALUE_LINE_1",
                        "VALUE_LINE_2"
                    ]
                    }
                    "`;

                const result = await model.generateContent({
                    contents: [{
                        role: "user",
                        parts: [{
                                inlineData: {
                                    mimeType: mimeType,
                                    data: base64Image,
                                },
                            },
                            {
                                text: prompt
                            },
                        ],
                    }, ],
                });
                let text = await result.response.text();

                // تنظيف النص من Markdown إن وجد
                text = text.trim();
                if (text.startsWith("```json")) {
                text = text.replace(/^```json/, '').replace(/```$/, '').trim();

                try {
                    // تحويل النص إلى كائن JSON
                    const data = JSON.parse(text);

                    // التحقق من وجود full_mrz في الكائن
                    if (data.passport_type !== 'null') {
                        document.getElementById("name").value = data.full_name_arabic;
                        document.getElementById("card_id").value = data.national_id;
                        document.getElementById("age").value = calculateAge(data.date_of_birth);
                        document.getElementById("passport_numder").value = data.passport_no;
                        if (data.date_of_birth) {
                            let parts = data.date_of_birth.split('/');
                            if (parts.length === 3) {
                                let formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                                    document.getElementById("date_of_birth").value = formattedDate;
                                }
                            }
                            const govSelect = document.getElementById('governorate');
                            if (data.place_of_birth) {
                                const valueToSelect = data.place_of_birth.trim();
                                for (let option of govSelect.options) {
                                    if (option.value.trim() === valueToSelect) {
                                        option.selected = true;
                                        break;
                                    }
                                }
                            }
                            document.getElementById("passportInput_loader").style.display = "none";
                            document.getElementById("passportInput_loader_text").style.display = "none";

                        } else {
                            Swal.fire({
                                title: "الصورة غير واضحة!",
                                icon: "error",
                                draggable: true
                            });
                            document.getElementById("passportInput_loader").style.display = "none";
                            document.getElementById("passportInput_loader_text").style.display = "none";
                        }

                        console.log(data);
                    } catch (error) {
                        Swal.fire({
                            title: "الصورة غير واضحة!",
                            icon: "error",
                            draggable: true
                        });
                        document.getElementById("passportInput_loader").style.display = "none";
                        document.getElementById("passportInput_loader_text").style.display = "none";
                        console.error("Error parsing JSON:", error);
                    }
                }
                console.log(text)
            } catch (error) {
                document.getElementById("passportInput_loader").style.display = "none";
                document.getElementById("passportInput_loader_text").style.display = "none";
                console.error("❌ Error:", error);
                alert("حدث خطأ أثناء تحليل الصورة");
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // كل input فيه data-preview
            const fileInputs = document.querySelectorAll(".preview-image-input");

            fileInputs.forEach(fileInput => {
                const previewSelector = fileInput.getAttribute("data-preview");
                const dropArea = document.querySelector(previewSelector);
                const imgPreview = dropArea.querySelector("img");

                if (!dropArea) return;

                // منع السلوك الافتراضي (فتح الصورة في المتصفح)
                ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
                    dropArea.addEventListener(eventName, e => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });

                // إضافة ستايل عند السحب فوق المنطقة
                ["dragenter", "dragover"].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => {
                        dropArea.classList.add("border-primary");
                    });
                });

                ["dragleave", "drop"].forEach(eventName => {
                    dropArea.addEventListener(eventName, () => {
                        dropArea.classList.remove("border-primary");
                    });
                });

                // عند الإفلات
                dropArea.addEventListener("drop", e => {
                    const files = e.dataTransfer.files;
                    if (files.length > 0 && files[0].type.startsWith("image/")) {
                        fileInput.files = files; // تحديث input file
                        previewFile(files[0], imgPreview, dropArea);
                    }
                });

                // عند اختيار الصورة من الزر
                fileInput.addEventListener("change", e => {
                    if (e.target.files.length > 0) {
                        previewFile(e.target.files[0], imgPreview, dropArea);
                    }
                });
            });

            function previewFile(file, imgPreview, dropArea) {
                const reader = new FileReader();
                reader.onload = e => {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = "block";
                    dropArea.querySelector(".placeholder-text")?.remove(); // إزالة النص البديل لو موجود
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // كل عناصر الـ preview
            document.querySelectorAll("[id^='preview_']").forEach(previewDiv => {
                previewDiv.setAttribute("tabindex", "0"); // يخلي div قابل للفوكس
                previewDiv.classList.add("paste-zone"); // لو عايز تضيف ستايل

                previewDiv.addEventListener("paste", function(e) {
                    const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                    for (let i = 0; i < items.length; i++) {
                        if (items[i].type.indexOf("image") === 0) {
                            const file = items[i].getAsFile();

                            // قراءة الصورة
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                // عرض الصورة داخل الـ img
                                let img = previewDiv.querySelector("img");
                                if (img) {
                                    img.src = event.target.result;
                                    img.style.display = "block";
                                }

                                // اخفاء نص الـ placeholder إن وجد
                                let placeholder = previewDiv.querySelector(".placeholder-text");
                                if (placeholder) placeholder.style.display = "none";
                            };
                            reader.readAsDataURL(file);

                            // ربطها بالـ input[type=file]
                            let input = document.querySelector(
                                "input[data-preview='#" + previewDiv.id + "']"
                            );
                            if (input) {
                                let dataTransfer = new DataTransfer();
                                dataTransfer.items.add(file);
                                input.files = dataTransfer.files;
                            }

                            e.preventDefault();
                            break;
                        }
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jobSelect = document.querySelector("select[name='job_title_id']");
            const questionsContainer = document.getElementById("job-questions");

            jobSelect.addEventListener("change", function() {
                const jobId = this.value;

                if (!jobId) {
                    questionsContainer.innerHTML = "<p class='text-muted'>اختر وظيفة لعرض أسئلتها</p>";
                    return;
                }

                // مسح الأسئلة القديمة
                questionsContainer.innerHTML = "<p class='text-info'>جاري تحميل الأسئلة...</p>";
                let url = "{{ route('job.questions', ':id') }}";
                url = url.replace(':id', jobId);
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.status || !data.questions.length) {
                            questionsContainer.innerHTML =
                                "<p class='text-muted'>لا توجد أسئلة لهذه الوظيفة</p>";
                            return;
                        }

                        let html = "";
                        data.questions.forEach(q => {
                            html +=
                                `<div class="mb-3"><label class="form-label fw-bold">${q.question}</label>`;
                            switch (q.type) {
                                case "text":
                                    html +=
                                        `<input type="text" name="questions[${q.id}]" class="form-control" />`;
                                    break;
                                case "textarea":
                                    html +=
                                        `<textarea name="questions[${q.id}]" class="form-control"></textarea>`;
                                    break;
                                case "number":
                                    html +=
                                        `<input type="number" name="questions[${q.id}]" class="form-control" />`;
                                    break;
                                case "date":
                                    html +=
                                        `<input type="date" name="questions[${q.id}]" class="form-control" />`;
                                    break;
                                case "select":
                                    if (q.options) {
                                        let opts = JSON.parse(q.options).map(opt =>
                                            `<option value="${opt}">${opt}</option>`).join(
                                            "");
                                        html +=
                                            `<select name="questions[${q.id}]" class="form-control"><option value="">-- اختر --</option>${opts}</select>`;
                                    }
                                    break;
                                case "radio":
                                    if (q.options) {
                                        let radios = JSON.parse(q.options).map(opt => `
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="questions[${q.id}]" value="${opt}">
                                <label class="form-check-label">${opt}</label>
                            </div>`).join("");
                                        html +=
                                            `<div class="d-flex flex-wrap gap-3">${radios}</div>`;
                                    }
                                    break;
                                case "checkbox":
                                    if (q.options) {
                                        let checks = JSON.parse(q.options).map(opt => `
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="questions[${q.id}][]" value="${opt}">
                                <label class="form-check-label">${opt}</label>
                            </div>`).join("");
                                        html +=
                                            `<div class="d-flex flex-wrap gap-3">${checks}</div>`;
                                    }
                                    break;
                            }
                            html += `</div>`;
                        });

                        questionsContainer.innerHTML = html;
                    })
                    .catch(err => {
                        console.error("خطأ في جلب الأسئلة:", err);
                        questionsContainer.innerHTML = "<p class='text-danger'>تعذر تحميل الأسئلة</p>";
                    });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "اختر النوع...",
                allowClear: true,
                width: '100%',
            });
        });
    </script>
@stop
