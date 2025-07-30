@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    @if (request()->is('customer-consulate'))
        <h1>
            العملاء المؤهلون للقنصلية</h1>
    @else
        <h1>العملاء</h1>
    @endif
@stop

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow border-0">

                    <div class="card-body">
                        <div class="row d-flex justify-content-between">
                            <div class="mb-3 d-flex">
                                <!-- نموذج البحث -->
                                <form
                                    @if (request()->is('customer-consulate')) action="{{ route('consulate.search') }}"
                                @else action="{{ route('customer.search') }}" @endif
                                    method="POST" class="d-flex">
                                    @csrf
                                    <select class="form-select w-auto me-2 rounded shadow-sm border-primary mx-2"
                                        id="searchBy" name="searchBy">
                                        <option value="id">السريال</option>
                                        <option value="name_ar">الاسم</option>
                                        <option value="phone">رقم الهاتف</option>
                                        <option selected value="card_id">الرقم القومي</option>
                                        <option value="mrz">الـ MRZ</option>
                                        <option value="age">السن</option>
                                        <option value="e_visa_number">رقم طلب التأشيرة</option>
                                        <option value="passport_id">رقم الجواز</option>
                                        <option value="issue_place">جهة الإصدار</option>
                                    </select>

                                    <input type="text" class="form-control flex-grow-1" id="searchInput"
                                        name="searchInput" style="width: 300px;" placeholder="اكتب هنا للبحث" autofocus>
                                    <button type="submit" class="btn btn-primary mx-1">بحث</button>
                                </form>
                                @if (Route::currentRouteName() == 'customer.search')
                                    <a href="{{ route('customer.indes') }}">
                                        <button class="btn btn-primary mx-1">كل العملاء</button>
                                    </a>
                                @endif
                            </div>
                            <div class="d-flex" style="align-items: center;">
                                <div id="gggg" class="loader mr-2"
                                    style=" border: 4px solid #f3f3f3; border-top: 4px solid #997a44; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite; display: none;">
                                </div>
                                <div id="hhhh" class="loading-text"
                                    style=" font-size: 14px; color: #997a44;display: none;">
                                    الرجاء الانتظار...
                                </div>
                            </div>
                            <!-- أزرار الإجراءات -->
                            <div class="mb-3 me-2 mx-2">

                                <!-- زر تصفية -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#filterModal">
                                    <i class="fas fa-filter"></i> تصفية العملاء
                                </button>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        عمليات
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                                data-bs-target="#whatsappModal">إرسال
                                                رسالة نصية</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#groupModal">
                                                تعيين مجموعة
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#delegateModal">
                                                تعيين مندوب
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#bagModal">
                                                تعيين حقيبة
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="filterModalLabel">تصفية العملاء</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="filterForm" method="POST" action="{{ route('customers.filter') }}">
                                            @csrf

                                            <div class="col-md-12 my-2">
                                                <label class="fw-bold" style="color: #997a44;">MRZ جواز السفر</label>
                                                <textarea class="form-control fw-bold" name="mrz">{{ old('mrz', $fillter['mrz'] ?? '') }}</textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">الاسم الكامل</label>
                                                    <input type="text" class="form-control fw-bold" name="name_ar"
                                                        value="{{ old('name_ar', $fillter['name_ar'] ?? '') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">الرقم القومي</label>
                                                    <input type="text" class="form-control fw-bold" name="card_id"
                                                        value="{{ old('card_id', $fillter['card_id'] ?? '') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">رقم الهاتف</label>
                                                    <input type="text" class="form-control fw-bold" name="phone"
                                                        value="{{ old('phone', $fillter['phone'] ?? '') }}">
                                                </div>
                                            </div>

                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">محافظة الإقامة</label>
                                                    @php
                                                        $governorates = [
                                                            'القاهرة',
                                                            'الجيزة',
                                                            'الإسكندرية',
                                                            'الدقهلية',
                                                            'البحر الأحمر',
                                                            'البحيرة',
                                                            'الفيوم',
                                                            'الغربية',
                                                            'الإسماعلية',
                                                            'المنوفية',
                                                            'المنيا',
                                                            'القليوبية',
                                                            'الوادي الجديد',
                                                            'السويس',
                                                            'أسوان',
                                                            'أسيوط',
                                                            'بني سويف',
                                                            'بورسعيد',
                                                            'دمياط',
                                                            'الشرقية',
                                                            'جنوب سيناء',
                                                            'كفر الشيخ',
                                                            'مطروح',
                                                            'الأقصر',
                                                            'قنا',
                                                            'شمال سيناء',
                                                            'سوهاج',
                                                        ];
                                                    @endphp
                                                    <select class="form-control fw-bold" name="governorate_live">
                                                        <option value="">اختر المحافظة</option>
                                                        @foreach ($governorates as $gov)
                                                            <option value="{{ $gov }}"
                                                                {{ old('governorate_live', $fillter['governorate_live'] ?? '') == $gov ? 'selected' : '' }}>
                                                                {{ $gov }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">الحالة</label>
                                                    <select class="form-control fw-bold" name="status">
                                                        <option value="">اختر الحالة</option>
                                                        @foreach (['جديد', 'ناجح', 'تجهيز الأوراق'] as $status)
                                                            <option value="{{ $status }}"
                                                                {{ old('status', $fillter['status'] ?? '') == $status ? 'selected' : '' }}>
                                                                {{ $status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">نوع الرخصة</label>
                                                    <select class="form-control fw-bold" name="license_type">
                                                        <option value="">اختر النوع</option>
                                                        @foreach (['خاصة', 'عامة'] as $type)
                                                            <option value="{{ $type }}"
                                                                {{ old('license_type', $fillter['license_type'] ?? '') == $type ? 'selected' : '' }}>
                                                                {{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row my-2">
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">السن</label>
                                                    <input type="text" class="form-control fw-bold" name="age"
                                                        value="{{ old('age', $fillter['age'] ?? '') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">رقم جواز السفر</label>
                                                    <input type="text" class="form-control fw-bold" name="passport_id"
                                                        value="{{ old('passport_id', $fillter['passport_id'] ?? '') }}">
                                                </div>
                                            </div>

                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">نوع التأشيرة</label>
                                                    <select class="form-control fw-bold" name="visa_type_id">
                                                        <option value="">اختر التأشيرة</option>
                                                        @foreach ($visas as $visa)
                                                            <option value="{{ $visa->id }}"
                                                                {{ old('visa_type_id', $fillter['visa_type_id'] ?? '') == $visa->id ? 'selected' : '' }}>
                                                                {{ $visa->outgoing_number }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">الكفيل</label>
                                                    <select class="form-control fw-bold" name="sponser_id">
                                                        <option value="">اختر الكفيل</option>
                                                        @foreach ($sponsers as $sponser)
                                                            <option value="{{ $sponser->id }}"
                                                                {{ old('sponser_id', $fillter['sponser_id'] ?? '') == $sponser->id ? 'selected' : '' }}>
                                                                {{ $sponser->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">المجموعة</label>
                                                    <select class="form-control fw-bold" name="customer_group_id">
                                                        <option value="">اختر المجموعة</option>
                                                        @foreach ($groups as $group)
                                                            <option value="{{ $group->id }}"
                                                                {{ old('customer_group_id', $fillter['customer_group_id'] ?? '') == $group->id ? 'selected' : '' }}>
                                                                {{ $group->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">الوظيفة</label>
                                                    <select class="form-control fw-bold" name="job_title_id">
                                                        <option value="">اختر الوظيفة</option>
                                                        @foreach ($jobs as $job)
                                                            <option value="{{ $job->id }}"
                                                                {{ old('job_title_id', $fillter['job_title_id'] ?? '') == $job->id ? 'selected' : '' }}>
                                                                {{ $job->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="fw-bold" style="color: #997a44;">المندوب</label>
                                                    <select class="form-control fw-bold" name="delegate_id">
                                                        <option value="">اختر المندوب</option>
                                                        @foreach ($delegates as $delegate)
                                                            <option value="{{ $delegate->id }}"
                                                                {{ old('delegate_id', $fillter['delegate_id'] ?? '') == $delegate->id ? 'selected' : '' }}>
                                                                {{ $delegate->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row my-2">
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">المؤهل الدراسي</label>
                                                    <select class="form-control fw-bold" name="education">
                                                        <option value="">اختر المؤهل</option>
                                                        @foreach (['محو امية', 'مؤهل متوسط'] as $edu)
                                                            <option value="{{ $edu }}"
                                                                {{ old('education', $fillter['education'] ?? '') == $edu ? 'selected' : '' }}>
                                                                {{ $edu }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">الحالة
                                                        الاجتماعية</label>
                                                    <select class="form-control fw-bold" name="marital_status">
                                                        <option value="">اختر الحالة الاجتماعية</option>
                                                        @foreach (['اعزب', 'متزوج'] as $marital)
                                                            <option value="{{ $marital }}"
                                                                {{ old('marital_status', $fillter['marital_status'] ?? '') == $marital ? 'selected' : '' }}>
                                                                {{ $marital }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <h4 class="fw-bold mt-3">المراحل</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">الكشف الطبي</label>
                                                    <select class="form-control fw-bold" name="medical_examination">
                                                        <option value="">اختر المرحلة</option>
                                                        @foreach (['في انتظار الحجز', 'تم الحجز', 'لائق', 'غير لائق'] as $med)
                                                            <option value="{{ $med }}"
                                                                {{ old('medical_examination', $fillter['medical_examination'] ?? '') == $med ? 'selected' : '' }}>
                                                                {{ $med }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">البصمة</label>
                                                    <select class="form-control fw-bold" name="finger_print_examination">
                                                        <option value="">اختر المرحلة</option>
                                                        @foreach (['في انتظار الحجز', 'تم تصدير الاكسيل'] as $finger)
                                                            <option value="{{ $finger }}"
                                                                {{ old('finger_print_examination', $fillter['finger_print_examination'] ?? '') == $finger ? 'selected' : '' }}>
                                                                {{ $finger }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">كشف المعامل</label>
                                                    <select class="form-control fw-bold" name="virus_examination">
                                                        <option value="">اختر المرحلة</option>
                                                        @foreach (['بأنتظار ايصال المعامل', 'تم اصدار ايصال المعامل', 'سالب', 'موجب'] as $virus)
                                                            <option value="{{ $virus }}"
                                                                {{ old('virus_examination', $fillter['virus_examination'] ?? '') == $virus ? 'selected' : '' }}>
                                                                {{ $virus }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold" style="color: #997a44;">حجز النت</label>
                                                    <select class="form-control fw-bold" name="engaz_request">
                                                        <option value="">اختر المرحلة</option>
                                                        @foreach (['في انتظار الطلب', 'تم الحجز', 'تم اصدار التأشيرة'] as $engaz)
                                                            <option value="{{ $engaz }}"
                                                                {{ old('engaz_request', $fillter['engaz_request'] ?? '') == $engaz ? 'selected' : '' }}>
                                                                {{ $engaz }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column gap-3 mt-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="travel_before"
                                                        value="1"
                                                        {{ old('travel_before', $fillter['travel_before'] ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold">هل سافر من قبل؟</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="e_visa_number_issued" value="1"
                                                        {{ old('e_visa_number_issued', $fillter['e_visa_number_issued'] ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold">هل أصدر له رقم تأشيرة؟</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="e_visa_number_entered" value="1"
                                                        {{ old('e_visa_number_entered', $fillter['e_visa_number_entered'] ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold">هل ورقه دخل القنصلية؟</label>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">إغلاق</button>
                                                <button type="button" class="btn btn-warning" id="resetFilter">إعادة
                                                    تعيين</button>
                                                <button type="submit" class="btn btn-primary">تطبيق الفلترة</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr> <!-- Divider -->

                        {{-- <div class="d-flex flex-wrap gap-2 mb-4">
                            <div>
                                <a href="{{ route('customer.indes') }}">
                                    <button class="btn btn-outline-primary active">الكل</button>
                                </a>
                            </div>

                            <form method="POST" action="{{ route('customers.filter') }}">
                                @csrf
                                <input type="hidden" name="status" value="جديد">
                                <button type="submit" class="btn btn-outline-success">جديد</button>
                            </form>

                            <form method="POST" action="{{ route('customers.filter') }}">
                                @csrf
                                <input type="hidden" name="medical_examination" value="تم الحجز">
                                <button class="btn btn-outline-info">تم حجز الكشف الطبي</button>
                            </form>

                            <form method="POST" action="{{ route('customers.filter') }}">
                                @csrf
                                <input type="hidden" name="finger_print_examination" value="تم تصدير الاكسيل">
                                <button class="btn btn-outline-info">تم عمل البصمة</button>
                            </form>

                            <form method="POST" action="{{ route('customers.filter') }}">
                                @csrf
                                <input type="hidden" name="virus_examination" value="تم اصدار ايصال المعامل">
                                <button class="btn btn-outline-info">تم أصدر كشف المعامل</button>
                            </form>

                            <form method="POST" action="{{ route('customers.filter') }}">
                                @csrf
                                <input type="hidden" name="engaz_request" value="تم الحجز">
                                <button class="btn btn-outline-info">تم أصدر طلب انجاز</button>
                            </form>

                            <div>
                                <button class="btn btn-outline-success">المؤهلون للقنصلية</button>
                            </div>

                            <div>
                                <button class="btn btn-outline-primary">تم أصدار التأشيرة</button>
                            </div>

                            <div>
                                <button class="btn btn-outline-success">تم السفر</button>
                            </div>

                            <div>
                                <button class="btn btn-outline-dark">أرشيف</button>
                            </div>
                        </div> --}}

                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="example">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"
                                                class="form-check-input cccccccc width-input"></th>
                                        <th>كود العميل</th>
                                        <th>اسم العميل</th>
                                        <th>الصورة</th>
                                        <th>الهاتف</th>
                                        <th>السن</th>
                                        <th>المندوب</th>
                                        <th>المجموعة</th>
                                        <th>الحالة</th>
                                        <th>المرفقات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr
                                            class="
                                                        @if ($customer->blackList && $customer->blackList->block) table-danger
                                                        @elseif(is_null($customer->passport_expire_date))
                                                            table-warning @endif
                                                    ">
                                            <td style="position: relative !important;" class="text-center align-middle">
                                                <input
                                                    style="position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);"
                                                    type="checkbox" id="myCheckbox"
                                                    class="form-check-input row-checkbox width-input" name="customer_id"
                                                    value="{{ $customer->id }}"
                                                    data-customer='@json($customer)'>
                                            </td>
                                            <td>#{{ $customer->id }}</td>
                                            <td><a
                                                    href="{{ route('customer.add', $customer->id) }}">{{ $customer->name_ar }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $customer->image) }}" target="blank">
                                                    <img src="{{ asset('storage/' . $customer->image) }}" width="40"
                                                        height="40" class="img-circle" alt="صورة" loading="lazy">
                                                </a>
                                            </td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->age }}</td>
                                            <td>{{ $customer->delegate->name ?? '-' }}</td>
                                            <td>
                                                @if ($customer->customerGroup)
                                                    <a href="{{ route('group.customer', $customer->customerGroup->id) }}">
                                                        {{ $customer->customerGroup->title ?? '-' }}
                                                    </a>
                                                @else
                                                    {{ $customer->customerGroup->title ?? '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $customer->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('attachments.toAttach', $customer->id) }}?tap=attach"
                                                    class="badge bg-dark">
                                                    {{ count($customer->documentTypes) }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">

                                                        <!-- تعديل -->
                                                        <li>
                                                            <a class="dropdown-item text-primary"
                                                                href="{{ route('customer.add', $customer->id) }}">
                                                                <i class="fas fa-edit me-1"></i> تعديل
                                                            </a>
                                                        </li>

                                                        <!-- عرض -->
                                                        @if (auth()->user()?->permissions->contains('permission', 'show-customer') || auth()->user()?->role == 'admin')
                                                            <li>
                                                                <a class="dropdown-item text-info"
                                                                    href="{{ route('customer.show', $customer->id) }}">
                                                                    <i class="fas fa-eye me-1"></i> عرض
                                                                </a>
                                                            </li>
                                                        @endif

                                                        <!-- بلوك / إزالة بلوك -->
                                                        <li>
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ $customer->blackList && $customer->blackList->block ? route('customers.unblock', $customer->id) : route('customers.block', $customer->id) }}">
                                                                <i class="fas fa-users me-1"></i>
                                                                {{ $customer->blackList && $customer->blackList->block ? 'إزالة البلوك' : 'بلوك' }}
                                                            </a>
                                                        </li>

                                                        <!-- الكشوفات والحجوزات -->
                                                        <li class="dropdown-submenu dropstart">
                                                            <a class="dropdown-item dropdown-toggle" href="#"><i
                                                                    class="fas fa-list-alt me-1"></i> الكشوفات</a>
                                                            <ul class="dropdown-menu"
                                                                style="position: absolute; left: 100% !important; right: auto;">

                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('print_visaEntriy', $customer->id) }}"
                                                                        target="_blank"><i
                                                                            class="fas fa-passport me-1"></i>
                                                                        طباعة طلب
                                                                        دخول</a></li>
                                                                {{-- @if ($customer->token_medical)
                                                                    <li>
                                                                        <a href="{{ route('check.medical.status', $customer->token_medical) }}"
                                                                            class="dropdown-item show-loading">
                                                                            <i class="fas fa-hospital me-1"></i>

                                                                            تحقق من الحالة الطبية
                                                                        </a>
                                                                    </li>
                                                                @endif --}}
                                                            </ul>
                                                        </li>

                                                        {{-- <!-- الطباعة -->
                                                        <li class="dropdown-submenu dropstart">
                                                            <a class="dropdown-item dropdown-toggle" href="#"><i
                                                                    class="fas fa-print me-1"></i> طباعة</a>
                                                            <ul class="dropdown-menu"
                                                                style="position: absolute; left: 100% !important; right: auto;">
                                                                <li><a class="dropdown-item" href="#"><i
                                                                            class="fas fa-file-alt me-1"></i> ملف
                                                                        العميل</a></li>
                                                                <li><a class="dropdown-item" href="#"><i
                                                                            class="fas fa-envelope-open-text me-1"></i>
                                                                        خطاب ترشيح</a></li>
                                                                <li><a class="dropdown-item" href="#"><i
                                                                            class="fas fa-history me-1"></i> تاريخ
                                                                        العميل</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('clients.print.attachments', $customer->id) }}"><i
                                                                            class="fas fa-paperclip me-1"></i> مرفقات
                                                                        العميل</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('clients.print.payments', $customer->id) }}"><i
                                                                            class="fas fa-money-check-alt me-1"></i> عمليات
                                                                        الدفع</a></li>
                                                            </ul>
                                                        </li> --}}

                                                        <!-- تصدير -->
                                                        {{-- <li>
                                                            <a class="dropdown-item text-success" href="#"><i
                                                                    class="fas fa-file-excel me-1"></i> تصدير لإكسل</a>
                                                        </li> --}}

                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- End card-body -->
                </div> <!-- End card -->
            </div>
        </div>
        <!-- تعيين مجموعة -->
        <div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="groupModalLabel">
                            <i class="bi bi-people-fill"></i>
                            تعيين مجموعة للعملاء المحددين
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="assignGroupForm">
                            <div class="mb-4">
                                <label for="groupSelect" class="form-label">اختر المجموعة</label>
                                <select class="form-select-modal" id="groupSelect" name="group_id" required>
                                    <option value="" selected disabled>-- اختر المجموعة --</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->id }}: {{ $group->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal"
                                    style="border-radius: var(--border-radius); padding: 0.65rem 1.5rem;">
                                    إلغاء
                                </button>
                                <button type="submit" class="btn btn-primary ml-2">
                                    <i class="bi bi-save"></i> حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- تعيين مندوب --}}
        <div class="modal fade" id="delegateModal" tabindex="-1" aria-labelledby="delegateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delegateModalLabel">تعيين مندوب للعملاء المحددين</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <form id="assignDelegateForm">
                            <div class="mb-4">
                                <label for="delegateSelect" class="form-label">اختر المندوب</label>
                                <select class="form-select-modal" id="delegateSelect" name="delegate_id" required>
                                    <option value="" selected disabled>-- اختر المندوب --</option>
                                    @foreach ($delegates as $delegate)
                                        <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                                    إلغاء
                                </button>
                                <button type="submit" class="btn btn-primary ml-2">
                                    <i class="bi bi-save"></i> حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- تعيين حقيبة --}}
        <div class="modal fade" id="bagModal" tabindex="-1" aria-labelledby="bagModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold" id="bagModalLabel">تعيين حقيبة للعملاء المحددين</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="assignBagForm">
                            <div class="mb-3">
                                <label for="bagSelect" class="form-label">اختر الحقيبة</label>
                                <select class="form-select-modal rounded" id="bagSelect" name="bag_id" required>
                                    <option value="" selected disabled>-- اختر الحقيبة --</option>
                                    @foreach (App\Models\bag::all() as $bag)
                                        <option value="{{ $bag->id }}">{{ $bag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ارسال رسالة   -->
        <div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="whatsappModalLabel">اختيار القالب لإرسال رسالة نصية</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <form id="whatsappForm">
                            <div class="mb-3">
                                <label for="customerSelect" class="form-label">اختر قالب الرسالة</label>
                                <select class="form-select-modal" id="customerSelect" required>
                                    <option value="" disabled selected>-- اختر القالب --</option>
                                    <!-- يتم إضافة الأسماء هنا عبر JavaScript -->
                                    @foreach (App\Models\Template::all() as $template)
                                        <option value="{{ $template->description }}">{{ $template->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Loading Overlay -->
        <div id="loading-overlay"
            style="display: none; position: fixed; z-index: 9999; top:0; left:0; width:100%; height:100%; background: rgba(255,255,255,0.8);">
            <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                    <span class="sr-only">جارٍ التحميل...</span>
                </div>
            </div>
        </div>
        @if (session('swal'))
            <script>
                Swal.fire(@json(session('swal')));
            </script>
        @endif

        @if (Session::has('success'))
            <script>
                Swal.fire({
                    position: "bottom-end",
                    icon: "success",
                    title: "{{ Session::get('success') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "{{ Session::get('error') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script src="{{ asset(path: 'js/entry_applocation.js') }}"></script>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        /* الدعم للقائمة الفرعية */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            /* right: 100%; */
            /* خليها يمين للقائمة الأساسية */
            margin-top: -6px;
            display: none;
            position: absolute;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        /* سهم بجانب العناصر اللي لها قائمة فرعية */
        .dropdown-submenu>a::after {
            content: "\f104";
            /* FontAwesome arrow-left */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            float: left;
            margin-left: 5px;
        }

        .dropdown-submenu>a:after {
            border-right: none !important;
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .table-responsive {
            overflow: visible;
        }

        /* .content-wrapper {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    width: fit-content;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } */

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

        .form-check-input.rounded {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            accent-color: #dc3545;
            /* لون أحمر */
        }

        /* يجعل القائمة الفرعية تظهر عند تمرير الماوس */
        .submenu {
            display: none;
            position: absolute;
            top: 0;
            right: -100%;
            /* يجعل القائمة الفرعية تظهر على اليمين */
            min-width: 200px;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 1000;
        }

        /* عند تمرير الماوس تظهر القائمة الفرعية */
        .dropdown-item:hover+.submenu,
        .submenu:hover {
            display: block;
        }


        /* تعيين مجموعة */
        .modal-content {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem 1.5rem 0.5rem;
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
        }

        .modal-title {
            font-size: 1.35rem;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
        }

        .modal-title i {
            font-size: 1.5rem;
            margin-left: 10px;
        }

        .btn-close {
            filter: invert(1);
            opacity: 0.8;
            transition: all 0.2s ease;
        }

        .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .form-select-modal {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            height: auto;
            box-shadow: none;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        /* Animation for modal appearance */
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal.fade .modal-dialog {
            animation: modalEnter 0.3s ease-out;
        }

        /* Custom scrollbar for select */
        .form-select::-webkit-scrollbar {
            width: 8px;
        }

        .form-select::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .form-select::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .form-select::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        .btn-outline-secondary {
            border-radius: var(--border-radius);
            padding: 0.65rem 1.5rem;
            transition: all 0.3s ease;
        }

        .loader {
            border: 5px solid #f3f3f3;
            /* لون الخلفية */
            border-top: 5px solid #4caf50;
            /* لون الدائرة المتحركة */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 16px;
            text-align: center;
        }


        .cccccccc {
            position: absolute;
            margin-top: 0 !important;
            margin-right: 0 !important;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>


@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        $(document).on('click', '.show-loading', function(e) {
            $('#loading-overlay').fadeIn();
        });
        // #########################################################################################################
        // document.addEventListener("DOMContentLoaded", function() {
        //     document.querySelectorAll(".check-medical-status").forEach(button => {
        //         button.addEventListener("click", async function(event) {
        //             event.preventDefault();
        //             const customer = JSON.parse(this.dataset.customer);
        //             console.log("Customer ID:", customer.id);
        //             let nameParts = customer.name_en_mrz.trim().split(' ');
        //             const data = {
        //                 firstName: nameParts[0],
        //                 lastName: nameParts[nameParts.length - 1],
        //                 passportNumber: customer.passport_id,
        //                 country: "EGY",
        //                 city: "87",
        //                 destinationCountry: "SA",
        //                 dateOfBirth: customer.date_birth,
        //                 nationality: "1",
        //                 gender: "male",
        //                 maritalStatus: "unmarried",
        //                 passportIssueDate: "01/01/2020",
        //                 passportIssuePlace: customer.issue_place,
        //                 passportExpiryDate: customer.passport_expire_date,
        //                 visaType: "wv",
        //                 email: "john.doe@example.com",
        //                 phone: "+2" + customer.phone,
        //                 nationalId: customer.card_id,
        //                 position: "22"
        //             };
        //             console.log(data);
        //             fetch("http://localhost:3000/api/wafid", {
        //                     method: "POST",
        //                     headers: {
        //                         "Content-Type": "application/json"
        //                     },
        //                     body: JSON.stringify(data)
        //                 })
        //                 .then(response => {
        //                     if (!response.ok) {
        //                         throw new Error(`HTTP error! Status: ${response.status}`);
        //                     }
        //                     return response.json();
        //                 })
        //                 .then(result => {
        //                     const routeUrl =
        //                         "{{ route('hospital.book', ['id' => 'customerId']) }}"; // توليد الرابط
        //                     const customerId = customer
        //                         .id; // مثال على ID العميل، يمكنك تمريره من الـ PHP أو الـ JavaScript

        //                     const url = routeUrl.replace('customerId', customerId);
        //                     fetch(url, {
        //                             method: "GET", // تأكد من استخدام الطريقة الصحيحة
        //                             headers: {
        //                                 "Content-Type": "application/json"
        //                             },
        //                         })
        //                         .then(response => {
        //                             Swal.fire({
        //                                 title: customer.name_ar +
        //                                     " تم حجز الكشف الطبي بنجاح",
        //                                 icon: "success",
        //                                 draggable: true
        //                             });
        //                             if (!response.ok) {
        //                                 throw new Error(
        //                                     `HTTP error! Status: ${response.status}`
        //                                 );
        //                             }
        //                             return response.json();
        //                         })
        //                         .then(result => {

        //                         })
        //                         .catch(error => {
        //                             console.error("Error:", error);
        //                         });
        //                 })
        //                 .catch(error => {
        //                     console.error("Error:", error);
        //                 });
        //         });
        //     });


        //     // المستشفي

        //     document.querySelectorAll(".check-medical-hospital").forEach(button => {
        //         button.addEventListener("click", async function(event) {
        //             let phone = this.getAttribute("data-phone");
        //             console.log(phone);

        //             event.preventDefault();

        //             try {
        //                 // إرسال الطلب لجلب بيانات المستشفى
        //                 let response = await fetch("http://localhost:3000/get-hospital", {
        //                     method: "POST",
        //                     headers: {
        //                         "Content-Type": "application/json"
        //                     },
        //                     body: JSON.stringify({
        //                         passport: "A23294560",
        //                         nationality: "Egyptian"
        //                     })
        //                 });

        //                 if (!response.ok) throw new Error(
        //                     `HTTP Error! Status: ${response.status}`);

        //                 let result = await response.json();

        //                 if (result.hospitalName && result.address && result.phone) {
        //                     // عرض بيانات المستشفى في SweetAlert
        //                     Swal.fire({
        //                         title: " بيانات المستشفى",
        //                         html: `
    //                 <b>🏥 اسم المركز الطبي:</b> ${result.hospitalName} <br><br>
    //                 <b>📍 العنوان:</b> ${result.address} <br><br>
    //                 <b>📞 رقم الهاتف:</b> ${result.phone}
    //             `,
        //                         icon: "info",
        //                         showCancelButton: true,
        //                         confirmButtonText: "إغلاق",
        //                         cancelButtonText: "📩 إرسال رسالة",
        //                     }).then(async (swalResult) => {
        //                         if (swalResult.dismiss === Swal.DismissReason
        //                             .cancel) {
        //                             await sendSms(result);
        //                         }
        //                     });
        //                 } else {
        //                     Swal.fire({
        //                         title: "⚠️ لم يتم العثور على البيانات",
        //                         text: "يرجى التحقق من رقم جواز السفر والجنسية والمحاولة مرة أخرى.",
        //                         icon: "warning",
        //                         confirmButtonText: "إغلاق"
        //                     });
        //                 }

        //             } catch (error) {
        //                 Swal.fire({
        //                     title: "❌ خطأ",
        //                     text: "حدث خطأ أثناء معالجة الطلب: " + error.message,
        //                     icon: "error",
        //                     confirmButtonText: "إغلاق"
        //                 });
        //             }
        //         });
        //     });

        //     // دالة لإرسال الرسالة النصية
        //     async function sendSms(hospitalData) {
        //         try {
        //             let smsResponse = await fetch("http://localhost:3000/send-sms", {
        //                 method: "POST",
        //                 headers: {
        //                     "Content-Type": "application/json",
        //                     "Accept": "application/json"
        //                 },
        //                 body: JSON.stringify({
        //                     recipient: `2${phone}`,
        //                     hospitalName: hospitalData.hospitalName,
        //                     address: hospitalData.address,
        //                     phone: hospitalData.phone
        //                 })
        //             });

        //             let smsResult = await smsResponse.json();

        //             if (smsResult.status === 'success') {
        //                 Swal.fire({
        //                     title: "✅ تم إرسال الرسالة بنجاح",
        //                     text: "تم إرسال بيانات المستشفى عبر الرسائل القصيرة.",
        //                     icon: "success",
        //                     confirmButtonText: "حسناً"
        //                 });
        //             } else {
        //                 Swal.fire({
        //                     title: "⚠️ فشل في الإرسال",
        //                     text: "لم يتم إرسال الرسالة. حاول مرة أخرى لاحقًا.",
        //                     icon: "warning",
        //                     confirmButtonText: "إغلاق"
        //                 });
        //             }
        //         } catch (error) {
        //             Swal.fire({
        //                 title: "❌ خطأ",
        //                 text: "حدث خطأ أثناء إرسال الرسالة: " + error.message,
        //                 icon: "error",
        //                 confirmButtonText: "إغلاق"
        //             });
        //         }
        //     }


        // });

        document.addEventListener('keydown', function(event) {
            if (event.key == 's') {
                const input = document.getElementById('searchInput');
                input.focus();
                input.value = ''; // Clears the input field
            }
        });
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                }
            });

            // تحديد الكل
            $('#selectAll').on('click', function() {
                $('.rowCheckbox').prop('checked', this.checked);
            });

            // البحث المخصص
            $('#tableSearch').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#dataTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });

        document.querySelectorAll(".send-sms").forEach(button => {
            button.addEventListener("click", async function(event) {
                document.getElementById("hhhh").style.display = "block"
                document.getElementById("gggg").style.display = "block"
                event.preventDefault();

                try {
                    let smsResponse = await fetch("http://localhost:3000/send-sms", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            "recipient": "201117831932",
                            "hospitalName": "dfdf",
                            "address": "sfddfdf",
                            "phone": "5455"
                        })
                    });

                    let smsResult = await smsResponse.json();

                    if (smsResult['status'] == 'success') {
                        document.getElementById("hhhh").style.display = "none"
                        document.getElementById("gggg").style.display = "none"
                        Swal.fire({
                            title: "✅ تم إرسال الرسالة بنجاح",
                            text: "تم إرسال بيانات المستشفى عبر الرسائل القصيرة.",
                            icon: "success",
                            confirmButtonText: "حسناً"
                        });
                    } else {
                        document.getElementById("hhhh").style.display = "none"
                        document.getElementById("gggg").style.display = "none"
                        Swal.fire({
                            title: "⚠️ فشل في الإرسال",
                            text: "لم يتم إرسال الرسالة. حاول مرة أخرى لاحقًا.",
                            icon: "warning",
                            confirmButtonText: "إغلاق"
                        });
                    }
                } catch (error) {
                    document.getElementById("hhhh").style.display = "none"
                    document.getElementById("gggg").style.display = "none"
                    Swal.fire({
                        title: "❌ خطأ",
                        text: "حدث خطأ أثناء إرسال الرسالة: " + error.message,
                        icon: "error",
                        confirmButtonText: "إغلاق"
                    });
                }
            })
        });

        // check all
        document.getElementById("checkAll").addEventListener("change", function() {
            let checkboxes = document.querySelectorAll(".form-check-input");
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        $('#example').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            },
            searching: false,
            pageLength: 100,
        });

        document.querySelectorAll(".finger-print").forEach(button => {
            button.addEventListener("click", function(e) {
                document.getElementById("hhhh").style.display = "block"
                document.getElementById("gggg").style.display = "block"
                // الحصول على بيانات العميل من data-customer
                const customer = JSON.parse(this.dataset.customer);

                // تقسيم الاسم إلى أجزاء (الاسم الأول، الاسم الثاني، إلخ)
                let nameParts = customer.name_en_mrz.trim().split(' ');

                // تحضير البيانات لتصديرها إلى Excel
                const data = [
                    ["الاسم الأول", "الاسم الثاني", " e-number", "جهة الإصدار", "تاريخ الانتهاء",
                        "الإيميل",
                        "رقم الهاتف", "تاريخ الإصدار", "الجنسية"
                    ],
                    [nameParts[0], nameParts[nameParts.length - 1], customer.e_visa_number, customer
                        .issue_place, customer
                        .passport_expire_date, "eslam@gmail.com", customer.phone, customer
                        .passport_expire_date, customer.nationality
                    ]
                ];

                // إنشاء ملف Excel باستخدام SheetJS
                const worksheet = XLSX.utils.aoa_to_sheet(data);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "البيانات");
                XLSX.writeFile(workbook, "بيانات البصمة.xlsx");
                document.getElementById("hhhh").style.display = "none"
                document.getElementById("gggg").style.display = "none"
            });
        });
        // ######################################################################### تعيين مجموعة
        document.getElementById('assignGroupForm').addEventListener('submit', function(e) {
            document.getElementById("hhhh").style.display = "block"
            document.getElementById("gggg").style.display = "block"
            e.preventDefault();

            const selectedGroupId = document.getElementById('groupSelect').value;

            const selectedCustomerIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedCustomerIds.length === 0) {
                alert("يرجى تحديد عملاء أولاً.");
                return;
            }
            console.log(selectedCustomerIds);

            fetch('{{ route('group.assign') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        customers: selectedCustomerIds,
                        group: selectedGroupId
                    })
                })
                .then(async response => {
                    document.getElementById("hhhh").style.display = "none";
                    document.getElementById("gggg").style.display = "none";

                    const data = await response.json();

                    if (!response.ok) {
                        // هنا حدث خطأ من السيرفر (مثل الحالة 400 أو 422)
                        throw new Error(data.message || "حدث خطأ أثناء تنفيذ العملية");
                    }

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "تم تعيين المجموعة للعملاء بنجاح",
                        showConfirmButton: false,
                        timer: 3000
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                })
                .catch(error => {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: error.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
        });
        // ############################################################# تعيين مندوب
        document.getElementById('assignDelegateForm').addEventListener('submit', function(e) {
            document.getElementById("hhhh").style.display = "block";
            document.getElementById("gggg").style.display = "block";
            e.preventDefault();

            const delegateId = document.getElementById('delegateSelect').value;
            const selectedCustomerIds = Array.from(document.querySelectorAll('input[name="customer_id"]:checked'))
                .map(checkbox => checkbox.value);

            if (selectedCustomerIds.length === 0) {
                alert("الرجاء تحديد العملاء أولاً.");
                return;
            }

            fetch('{{ route('delegate.assign') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        customers: selectedCustomerIds,
                        delegate: delegateId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("hhhh").style.display = "none";
                    document.getElementById("gggg").style.display = "none";

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "تم تعيين المندوب للعملاء بنجاح",
                        showConfirmButton: false,
                        timer: 3000
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                })
                .catch(err => {
                    document.getElementById("hhhh").style.display = "none"
                    document.getElementById("gggg").style.display = "none"
                    console.error(err);
                    alert("حدث خطأ أثناء التعيين");
                });
        });
        // ###################################################################### تعيين حقيبة 
        document.getElementById('assignBagForm').addEventListener('submit', function(e) {
            document.getElementById("hhhh").style.display = "block"
            document.getElementById("gggg").style.display = "block"
            e.preventDefault();

            const bagId = document.getElementById('bagSelect').value;
            const selectedCustomerIds = Array.from(document.querySelectorAll('input[name="customer_id"]:checked'))
                .map(checkbox => checkbox.value);

            if (selectedCustomerIds.length === 0) {
                alert("الرجاء تحديد العملاء أولاً.");
                return;
            }

            fetch('{{ route('bag.assign') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        customers: selectedCustomerIds,
                        bag: bagId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("hhhh").style.display = "none"
                    document.getElementById("gggg").style.display = "none"
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "تم تعيين الحقيبة للعملاء بنجاح",
                        showConfirmButton: false,
                        timer: 3000
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById("hhhh").style.display = "none"
                    document.getElementById("gggg").style.display = "none"
                    alert("حدث خطأ أثناء التعيين");
                });
        });

        document.getElementById("whatsappForm").addEventListener("submit", async function(e) {
            e.preventDefault();
            document.getElementById("whatsappModal").style.display = "none";
            Swal.fire({
                title: '<span style="font-size: 20px; font-weight: bold;">جاري ارسال الرسالة ...</span>',
                html: `
                        <div dir="rtl" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 10px;">
                            <div style="background: linear-gradient(135deg, #007bff, #6610f2); border-radius: 50%; padding: 18px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                                <div class="spinner-border text-white" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                            </div>
                            <h2 style="margin-top: 20px; font-size: 20px; font-weight: bold; color: #333;">جاري تنفيذ ارسال الرسائل الي العملاء...</h2>
                            <p style="font-size: 15px; color: #666; margin-top: 5px;">يرجى الانتظار حتى انتهاء ارسال الرسائل للعملاء</p>
                        </div>
                    `,
                background: '#fff',
                width: '400px',
                customClass: {
                    popup: 'modern-swal-popup',
                },
                showConfirmButton: false,
                allowOutsideClick: false,
                backdrop: `rgba(0,0,0,0.2)`
            });
            document.getElementById("hhhh").style.display = "block";
            document.getElementById("gggg").style.display = "block";
            const templite = document.getElementById('customerSelect').value;
            const selectedCustomerIds = Array.from(document.querySelectorAll(
                    'input[name="customer_id"]:checked'))
                .map(checkbox => checkbox.value);

            if (selectedCustomerIds.length === 0) {
                Swal.fire({
                    title: 'تنبيه',
                    text: 'يرجى تحديد العملاء أولاً',
                    icon: 'warning',
                    confirmButtonText: 'حسناً'
                });
                document.getElementById("hhhh").style.display = "none";
                document.getElementById("gggg").style.display = "none";
                return;
            }
            document.getElementById("whatsappModal").style.display = "none";
            fetch('{{ route('send.sms') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        customer_ids: selectedCustomerIds,
                        templite: templite
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    document.getElementById("hhhh").style.display = "none"
                    document.getElementById("gggg").style.display = "none"
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "تم ارسالة رسالة نصية بنجاح",
                        showConfirmButton: false,
                        timer: 3000
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById("hhhh").style.display = "none"
                    document.getElementById("gggg").style.display = "none"
                    alert("حدث خطأ أثناء التعيين");
                });
        });

        document.getElementById('labBookingBtn').addEventListener('click', function() {
            const selectedCustomers = [];

            document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
                const customerData = checkbox.getAttribute('data-customer');
                selectedCustomers.push(JSON.parse(customerData));
            });

            selectedCustomers.forEach(customer => {
                console.log(customer.e_visa_number);
                fetch('http://localhost:3000/submit-form', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            nationalId: customer.card_id,
                            passportNumber: customer.passport_id,
                            fullName: customer.name_ar,
                            e_visa_number: customer.e_visa_number,
                        })
                    })
                    .then(response => {
                        return response.json(); // إذا كنت تتوقع JSON كرد
                    })
                    .then(data => {
                        fetch("{{ route('savePDF') }}", {
                                method: "POST",
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    pdf: data.pdf,
                                    customer_id: customer.id,
                                    user: "{{ auth()->user()->email }}"
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                Swal.fire({
                                    title: "نجحت العملية!",
                                    text: "تم حجز كشف المعامل بنجاح!",
                                    icon: "success"
                                });
                            })
                            .catch(err => {
                                console.error("خطأ:", err);
                                alert("فشل في حفظ PDF");
                            });
                    })
                    .catch(error => {
                        console.error('خطأ أثناء الإرسال:', error);
                    });
            });

        });

        // document.getElementById('medical-examination').addEventListener('click', function() {
        //     const selectedCustomers = [];

        //     document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
        //         const customerData = checkbox.getAttribute('data-customer');
        //         selectedCustomers.push(JSON.parse(customerData));
        //     });

        //     if (selectedCustomers.length === 0) {
        //         Swal.fire({
        //             title: 'تنبيه',
        //             text: 'يرجى تحديد العملاء أولاً',
        //             icon: 'warning',
        //             confirmButtonText: 'حسناً'
        //         });
        //         return;
        //     }

        //     selectedCustomers.forEach(customer => {
        //         const name_ar = customer.name_ar?.split(" ") || [];
        //         const name_en = customer.name_en_mrz?.split(" ") || [];

        //         if (name_ar.length < 3 || name_en.length < 3) {
        //             Swal.fire({
        //                 title: "فشلت العملية!",
        //                 text: "هناك مشكلة في الاسم: " + customer.name_ar,
        //                 icon: "error"
        //             });
        //             return; // لا تكمل هذا العميل
        //         }

        //         const first_ar = name_ar[0] || "";
        //         const middle_ar = name_ar[1] || "";
        //         const last_ar = name_ar[2] || "";
        //         const end_ar = name_ar[name_ar.length - 1] || "";

        //         const first_en = name_en[0] || "";
        //         const middle_en = name_en[1] || "";
        //         const last_en = name_en[2] || "";
        //         const end_en = name_en[name_en.length - 1] || "";

        //         const payload = {
        //             firstName: first_en,
        //             lastName: middle_en,
        //             passportNumber: customer.passport_id,
        //             country: "EGY",
        //             city: "87",
        //             destinationCountry: "SA",
        //             dateOfBirth: customer.date_birth,
        //             nationality: "55",
        //             gender: "male",
        //             maritalStatus: "unmarried",
        //             passportIssueDate: customer.passport_issuance_date,
        //             passportIssuePlace: customer.issue_place,
        //             passportExpiryDate: customer.passport_expire_date,
        //             visaType: "wv",
        //             email: "",
        //             phone: "+2" + customer.phone,
        //             nationalId: customer.card_id,
        //             position: customer.customer_group?.visa_profession?.job,
        //         };

        //         const requiredFields = [
        //             "firstName", "lastName", "passportNumber", "country", "city", "destinationCountry",
        //             "dateOfBirth", "nationality", "gender", "maritalStatus", "passportIssueDate",
        //             "passportIssuePlace", "passportExpiryDate", "visaType", "phone", "nationalId",
        //             "position"
        //         ];

        //         const missingFields = requiredFields.filter(key => {
        //             const value = payload[key];
        //             return value === undefined || value === null || value === "";
        //         });

        //         if (missingFields.length > 0) {
        //             Swal.fire({
        //                 title: "بيانات ناقصة!",
        //                 html: `
    //             <div>العميل: <strong>${customer.name_ar}</strong></div>
    //             <div>الحقول الناقصة:</div>
    //             <ul style="text-align:right">
    //                 ${missingFields.map(f => `<li>${f}</li>`).join("")}
    //             </ul>
    //         `,
        //                 icon: "error"
        //             });
        //             return; // لا تكمل لهذا العميل
        //         }

        //         // إرسال الطلب إذا كانت البيانات مكتملة
        //         fetch('http://localhost:3000/api/wafid', {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json'
        //                 },
        //                 body: JSON.stringify(payload)
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 console.log('Response:', data);
        //             })
        //             .catch(error => {
        //                 console.error('Error:', error);
        //             });
        //     });
        // });


        document.getElementById('visa').addEventListener('click', async function() {

            const selectedCustomers = [];

            document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
                const customerData = checkbox.getAttribute('data-customer');
                selectedCustomers.push(JSON.parse(customerData));
            });

            if (selectedCustomers.length === 0) {
                Swal.fire({
                    title: 'تنبيه',
                    text: 'يرجى تحديد العملاء أولاً',
                    icon: 'warning',
                    confirmButtonText: 'حسناً'
                });
                return;
            }

            for (const customer of selectedCustomers) {
                await handleCustomerVisa(customer); // دالة async
            }
        });

        async function handleCustomerVisa(customer) {
            // ✅ 1. رسالة البدء
            const loadingSwal = Swal.fire({
                title: '<span style="font-size: 20px; font-weight: bold;">جاري تنفيذ الكشف عن التأشيرة أو طلب الدخول...</span>',
                html: `
                        <div dir="rtl" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 10px;">
                            <div style="background: linear-gradient(135deg, #007bff, #6610f2); border-radius: 50%; padding: 18px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                                <div class="spinner-border text-white" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                            </div>
                            <h2 style="margin-top: 20px; font-size: 20px; font-weight: bold; color: #333;">يرجى الانتظار حتى انتهاء الحجز للعميل: ${customer.name_ar}</h2>
                        </div>
                    `,
                background: '#fff',
                width: '400px',
                customClass: {
                    popup: 'modern-swal-popup',
                },
                showConfirmButton: false,
                allowOutsideClick: false,
                backdrop: `rgba(0,0,0,0.2)`
            });

            const name_en = customer.name_en_mrz?.split(" ") || [];
            const name_ar = customer.name_ar || "";

            if (name_ar.length < 3 || name_en.length < 3) {
                await Swal.close(); // ⛔️ غلق رسالة الانتظار
                await Swal.fire({
                    title: "فشلت العملية!",
                    text: "هناك مشكلة في الاسم: " + name_ar,
                    icon: "error"
                });
                return;
            }

            try {
                const response = await fetch('http://localhost:3000/open-mofa', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        applicationNumber: customer.e_visa_number,
                        sponserId: customer.passport_id,
                        name: customer.name_en_mrz,
                        customer_id: customer.id,
                        email: "{{ auth()->user()->email }}",
                    }),
                });

                const data = await response.json();

                await Swal.close(); // ✅ غلق الرسالة السابقة قبل عرض الجديدة

                if (data.status === true) {
                    const successMessage = data.visaNumber ?
                        `تم فتح موقع وزارة الخارجية بنجاح!\nرقم التأشيرة: ${data.visaNumber}\nاسم العميل: ${customer.name_ar}` :
                        `تم إصدار طلب الدخول للعميل: ${customer.name_ar}`;

                    await Swal.fire({
                        title: "نجحت العملية!",
                        text: successMessage,
                        icon: "success",
                        timer: 3000, // ✅ الانتظار 3 ثواني
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                } else {
                    await Swal.fire({
                        title: "فشلت العملية!",
                        text: data.message || "حدث خطأ غير معروف",
                        icon: "error"
                    });
                }

            } catch (error) {
                await Swal.close();
                console.error('❌ Error:', error);
                await Swal.fire({
                    title: "فشلت العملية!",
                    text: "حدثت مشكلة في فتح الموقع",
                    icon: "error"
                });
            }
        }

        document.getElementById('collectSelected').addEventListener('click', async function() {
            const selectedCustomers = [];

            document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
                const customerData = checkbox.getAttribute('data-customer');
                selectedCustomers.push(JSON.parse(customerData));
            });

            if (selectedCustomers.length === 0) {
                return Swal.fire({
                    title: 'تنبيه',
                    text: 'يرجى تحديد العملاء أولاً',
                    icon: 'warning',
                    confirmButtonText: 'حسناً'
                });
            }

            // إظهار رسالة التحميل (مرة واحدة)


            const btn = document.getElementById('collectSelected');
            const companyData = JSON.parse(btn.getAttribute('data-company'));

            for (const customer of selectedCustomers) {
                Swal.fire({
                    title: '<span style="font-size: 20px; font-weight: bold;">جاري تنفيذ الحجز...</span>',
                    html: `
                        <div dir="rtl" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 10px;">
                            <div style="background: linear-gradient(135deg, #007bff, #6610f2); border-radius: 50%; padding: 18px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                                <div class="spinner-border text-white" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                            </div>
                            <h2 style="margin-top: 20px; font-size: 20px; font-weight: bold; color: #333;">جاري تنفيذ الحجز لكل عميل...</h2>
                            <p style="font-size: 15px; color: #666; margin-top: 5px;">يرجى الانتظار</p>
                        </div>
                        `,
                    background: '#fff',
                    width: '400px',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    backdrop: `rgba(0,0,0,0.2)`
                });
                const name_ar = customer.name_ar?.split(" ") || [];
                const name_en = customer.name_en_mrz?.split(" ") || [];

                if (name_ar.length < 3 || name_en.length < 3) {
                    await Swal.fire({
                        title: "فشلت العملية!",
                        text: "هناك مشكلة في الاسم: " + customer.name_ar,
                        icon: "error"
                    });
                    await new Promise(resolve => setTimeout(resolve, 3000));
                    continue;
                }

                const data = {
                    UserName: companyData.engaz_email,
                    Password: companyData.engaz_password,
                    VisaKind: customer.customer_group.visa_type.visa_peroid,
                    NATIONALITY: "EGY",
                    ResidenceCountry: "272",
                    EmbassyCode: customer.customer_group.visa_type.embassy.title,
                    NumberOfEntries: "0",
                    NumberEntryDay: "90",
                    ResidencyInKSA: "120",
                    AFIRSTNAME: name_ar[0] || "",
                    AFATHER: name_ar[1] || "",
                    AGRAND: name_ar[2] || "",
                    AFAMILY: name_ar[name_ar.length - 1] || "",
                    EFIRSTNAME: name_en[0] || "",
                    EFATHER: name_en[1] || "",
                    EGRAND: name_en[2] || "",
                    EFAMILY: name_en[name_en.length - 1] || "",
                    PASSPORTnumber: customer.passport_id,
                    imageUrl: `{{ asset('storage') }}/${customer.image}`,
                    PASSPORType: "1",
                    PASSPORT_ISSUE_PLACE: "مصر",
                    PASSPORT_ISSUE_DATE: "05/04/2023",
                    PASSPORT_EXPIRY_DATE: customer.passport_expire_date,
                    BIRTH_PLACE: "القاهرة",
                    BIRTH_DATE: customer.date_birth,
                    PersonId: customer.card_id,
                    DEGREE: "-",
                    DEGREE_SOURCE: "-",
                    ADDRESS_HOME: "بحره",
                    Personal_Email: "moha@gmail.com",
                    SPONSER_NAME: customer.customer_group.visa_type.sponser.name,
                    SPONSER_NUMBER: customer.customer_group.visa_type.sponser.id_number,
                    SPONSER_ADDRESS: customer.customer_group.visa_type.sponser.address,
                    SPONSER_PHONE: customer.customer_group.visa_type.sponser.phone,
                    COMING_THROUGH: "2",
                    ENTRY_POINT: "1",
                    ExpectedEntryDate: new Date(new Date().setMonth(new Date().getMonth() + 2))
                        .toLocaleDateString('en-GB'),
                    porpose: "عمل",
                    car_number: "SV123",
                    RELIGION: "1",
                    SOCIAL_STATUS: "2",
                    Sex: "1",
                    JOB_OR_RELATION_Id: customer.customer_group.visa_profession.job
                };

                try {
                    const res = await fetch('http://localhost:3000/submit-all', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const response = await res.json();

                    if (response.appNo) {
                        await fetch('{{ route('engaz_request') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                customer_id: customer.id,
                                e_number: response.appNo,
                                email: "{{ auth()->user()->email }}"
                            })
                        });

                        await new Promise((resolve) => {
                            Swal.fire({
                                title: "نجحت العملية!",
                                text: `تم إصدار طلب إنجاز للعميل: ${customer.name_ar}\nرقم الطلب: ${response.appNo}`,
                                icon: "success",
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                didClose: resolve // ⬅️ هنا يتم تنفيذ resolve عند غلق الرسالة
                            });
                        });

                    } else {
                        await new Promise((resolve) => {
                            Swal.fire({
                                title: "فشلت العملية!",
                                text: "لم يتم إصدار الطلب للعميل: " + customer.name_ar,
                                icon: "error",
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                didClose: resolve
                            });
                        });
                    }
                } catch (error) {
                    await new Promise((resolve) => {
                        Swal.fire({
                            title: "فشلت العملية!",
                            text: "حدث خطأ أثناء تنفيذ الطلب للعميل: " + customer.name_ar,
                            icon: "error",
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            didClose: resolve
                        });
                    });

                }
            }
        });

        document.getElementById('check-medical').addEventListener('click', async function() {
            const companyData = JSON.parse(btn.getAttribute('data-company'));
            console.log(companyData);

            const customer = JSON.parse(this.getAttribute('data-customer'));
            Swal.fire({
                title: 'جاري فتح المتصفح لك...',
                text: 'في انتظار',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            function reverseDateFormat(dateStr) {
                if (!dateStr) return null;

                const parts = dateStr.split("-");
                if (parts.length !== 3) return null;

                const [year, month, day] = parts;
                return `${day}-${month}-${year}`;
            }

            const payload = {
                firstName: extractFirstName(customer.name_en_mrz),
                lastName: extractLastName(customer.name_en_mrz),
                passportNumber: customer.passport_id,
                dateOfBirth: reverseDateFormat(customer.date_birth),
                maritalStatus: customer.marital_status,
                passportIssueDate: reverseDateFormat(customer.passport_issuance_date),
                passportIssuePlace: customer.issue_place,
                passportExpiryDate: reverseDateFormat(customer.passport_expire_date),
                phone: "+" + customer.phone,
                nationalId: customer.card_id,
                position: customer.customer_group.visa_profession.job,
            };
            console.log(customer.card_id);

            const fieldLabels = {
                firstName: "الاسم الأول",
                lastName: "اسم العائلة",
                passportNumber: "رقم الجواز",
                dateOfBirth: "تاريخ الميلاد",
                maritalStatus: "الحالة الاجتماعية",
                passportIssueDate: "تاريخ إصدار الجواز",
                passportIssuePlace: "مكان إصدار الجواز",
                passportExpiryDate: "تاريخ انتهاء الجواز",
                phone: "رقم الهاتف",
                nationalId: "الرقم القومي",
                position: "المهنة الخاصة بمجموعته"
            };

            // التحقق من القيم الناقصة فقط لهذه الحقول
            const missingFields = [];

            for (const [key, value] of Object.entries(payload)) {
                if (!value || value === "N/A" || value === "unknown") {
                    missingFields.push(fieldLabels[key] || key);
                }
            }

            if (missingFields.length > 0) {
                Swal.close(); // إغلاق الانتظار

                Swal.fire({
                    icon: 'warning',
                    title: 'بيانات ناقصة',
                    html: 'يرجى استكمال الحقول التالية قبل المتابعة:<br><b>' + missingFields.join(
                        '<br>') + '</b>',
                });
                return;
            }

            // باقي البيانات ثابتة أو افتراضية
            payload.country = "EGY";
            payload.city = "87";
            payload.destinationCountry = "SA";
            payload.nationality = "55";
            payload.visaType = "wv";
            payload.gender = "male";
            payload.email = companyData.medical_email;
            payload.userEmail = "{{ auth()->user()->email }}";

            try {
                const response = await fetch('http://localhost:3000/api/wafid', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();
                console.log('Result:', result);
                Swal.close(); // إغلاق الانتظار
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحجز',
                        text: 'تم إرسال البيانات بنجاح.',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء الاتصال بالخادم.',
                    });
                }

            } catch (error) {
                console.error('Fetch error:', error);
                Swal.close(); // إغلاق الانتظار
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء الاتصال بالخادم.',
                });
            }

            // مساعدات لتقسيم الاسم
            function extractFirstName(fullName) {
                return fullName?.split(" ")[0] ?? "Unknown";
            }

            function extractLastName(fullName) {
                const parts = fullName?.split(" ");
                return parts?.slice(1).join(" ") ?? "Unknown";
            }
        });
    </script>
@stop
