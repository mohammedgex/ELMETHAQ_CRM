@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    @if (request()->is('customer-consulate'))
        <h1> العملاء المؤهلون للقنصلية</h1>
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
                                <a href="">
                                    <button class="btn btn-success me-2 mx-2">إضافة عميل جديد</button>
                                </a>
                                <!-- نموذج البحث -->
                                <form
                                    @if (request()->is('customer-consulate')) action="{{ route('consulate.search') }}"
                                    @else action="{{ route('customer.search') }}" @endif
                                    method="POST" class="d-flex">
                                    @csrf
                                    <select class="form-select w-auto me-2 rounded shadow-sm border-primary mx-2"
                                        id="searchBy" name="searchBy">
                                        <option value="name_ar">الاسم</option>
                                        <option value="phone">رقم الهاتف</option>
                                        <option value="card_id">الرقم القومي</option>
                                        <option value="mrz">الـ MRZ</option>
                                        <option value="age">السن</option>
                                        <option value="e_visa_number">رقم طلب التأشيرة</option>
                                        <option value="passport_id">رقم الجواز</option>
                                        <option value="issue_place">جهة الإصدار</option>
                                    </select>

                                    <input type="text" class="form-control flex-grow-1" id="searchInput"
                                        name="searchInput" style="width: 300px;" placeholder="اكتب هنا للبحث">
                                    <button type="submit" class="btn btn-primary mx-1">بحث</button>
                                </form>
                                @if (Route::currentRouteName() == 'customer.search')
                                    <a href="{{ route('customer.indes') }}">
                                        <button class="btn btn-primary mx-1">كل العملاء</button>
                                    </a>
                                @endif
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
                                        <li><button class="dropdown-item" onclick="sendSMS('option1')"> ارسال رسالة نصية
                                            </button></li>
                                        <li><button class="dropdown-item" onclick="sendSMS('option2')">إرسال رسالة واتساب
                                            </button></li>
                                        <li><button class="dropdown-item" onclick="sendSMS('option3')">إرسال مخصص</button>
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
                                        <form id="filterForm" method="POST"
                                            @if (request()->is('customer-consulate')) action="{{ route('consulate.filter') }}"
                                            @else
                                                action="{{ route('customers.filter') }}" @endif>
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
                                                                {{ $gov }}</option>
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
                                                                {{ $status }}</option>
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
                                                                {{ $type }}</option>
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
                                                                {{ $visa->outgoing_number }}</option>
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
                                                                {{ $sponser->name }}</option>
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
                                                                {{ $group->title }}</option>
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
                                                                {{ $job->title }}</option>
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
                                                                {{ $delegate->name }}</option>
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
                                                                {{ $edu }}</option>
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
                                                                {{ $marital }}</option>
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
                                                                {{ $med }}</option>
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
                                                                {{ $finger }}</option>
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
                                                                {{ $virus }}</option>
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
                                                                {{ $engaz }}</option>
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


                        <div class="table-responsive">
                            <table class="table table-hover text-center animate__animated animate__fadeInUp"
                                id="example">
                                <thead class="text-white"
                                    style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="checkAll" class="rounded">
                                        </th>
                                        <th>كود العميل</th>
                                        <th>اسم العميل</th>
                                        <th> الوظيفة </th>
                                        <th>الرقم القومي</th>
                                        <th>رقم الهاتف</th>
                                        <th>السن</th>
                                        <th>المندوب</th>
                                        <th>المجموعة</th>
                                        <th>نوع الرخصة</th>
                                        <th>نوع التأشيرة</th>
                                        <th>الحالة </th>
                                        <th>رقم جواز السفر</th>
                                        <th>عدد المرفقات</th>
                                        <th>عدد المدفوعات</th>
                                        <th> تاريخ التسجيل</th>
                                        <th>اخر تعديل</th>
                                        <th> الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        {{-- <tr class="table-light"> --}}
                                        <tr
                                            class="{{ $customer->blackList && $customer->blackList->block ? 'table-danger' : 'table-light' }}">
                                            <td>
                                                <input type="checkbox" id="myCheckbox" class="form-check-input rounded">
                                            </td>
                                            <td>#{{ $customer->id }}</td>
                                            <td class="highlight">{{ $customer->name_ar }}</td>
                                            <td class="highlight"><span
                                                    class="badge bg-success text-white">{{ $customer->jobTitle->title ?? '' }}</span>
                                            </td>
                                            <td class="highlight">{{ $customer->card_id }}</td>
                                            <td class="highlight">{{ $customer->phone }}</td>
                                            <td class="highlight">{{ $customer->age }}</td>
                                            <td class="highlight"><a
                                                    href="#">{{ $customer->delegate->name ?? '' }}</a>
                                            </td>
                                            <td class="highlight"><a
                                                    href="#">{{ $customer->customerGroup->title ?? '' }}</a></td>
                                            <td class="highlight">{{ $customer->license_type }}</td>
                                            <td class="highlight">{{ $customer->visaType->outgoing_number ?? '' }}</td>
                                            <td class="highlight">{{ $customer->status }}</td>
                                            <td class="highlight">{{ $customer->passport_id }}</td>
                                            <td class="highlight">{{ count($customer->documentTypes) }}</td>
                                            <td class="highlight">{{ count($customer->payments) }}</td>
                                            <td class="highlight">{{ $customer->created_at }}</td>
                                            <td class="highlight">{{ $customer->updated_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button
                                                        class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <!-- خيار التعديل -->
                                                        <li>
                                                            <a class="dropdown-item text-primary"
                                                                href="{{ route('customer.add', $customer->id) }}">
                                                                <i class="fas fa-edit"></i> تعديل
                                                            </a>
                                                        </li>

                                                        <!-- خيار العرض -->
                                                        <li>
                                                            <a class="dropdown-item text-info"
                                                                href="{{ route('customer.show', $customer->id) }}">
                                                                <i class="fas fa-eye"></i> عرض
                                                            </a>
                                                        </li>
                                                        @if ($customer->blackList)
                                                            @if ($customer->blackList->block == false)
                                                                <li>
                                                                    <a class="dropdown-item text-danger"
                                                                        href="{{ route('customers.block', $customer->id) }}">
                                                                        <i class="fas fa-users"></i> بلوك
                                                                    </a>
                                                                </li>
                                                            @elseif ($customer->blackList->block == true)
                                                                <li>
                                                                    <a class="dropdown-item text-danger"
                                                                        href="{{ route('customers.unblock', $customer->id) }}">
                                                                        <i class="fas fa-users"></i> ازالة البلوك
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                        <!-- الكشوفات والحجوزات -->
                                                        <li class="dropdown">
                                                            <a class="dropdown-item text-primary dropdown-toggle"
                                                                href="#" id="submenu-toggle">
                                                                <i class="fas fa-list-alt"></i> الكشوفات والحجوزات
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end submenu"
                                                                aria-labelledby="submenu-toggle">
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i class="fas fa-globe"></i> حجز
                                                                        نت</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i class="fas fa-passport"></i>
                                                                        بيانات التأشيرة</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i class="fas fa-virus"></i> كشف
                                                                        الفايرس</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light check-medical-status"
                                                                        href="#"><i class="fas fa-hospital"></i>
                                                                        نتيجة كشف طبي</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light check-medical-hospital"
                                                                        href="#"><i
                                                                            class="fas fa-clinic-medical"></i> نتيجة
                                                                        وبيانات المستشفى</a></li>
                                                            </ul>
                                                        </li>

                                                        <!-- الطباعة -->
                                                        <li class="dropdown">
                                                            <a class="dropdown-item text-primary dropdown-toggle"
                                                                href="#" id="submenu-toggle">
                                                                <i class="fas fa-print"></i> طباعة
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end submenu"
                                                                aria-labelledby="submenu-toggle">
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i class="fas fa-file-alt"></i> ملف
                                                                        العميل</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i
                                                                            class="fas fa-envelope-open-text"></i> خطاب
                                                                        ترشيح</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i class="fas fa-history"></i>
                                                                        تاريخ العميل</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="{{ route('clients.print.attachments', $customer->id) }}"><i
                                                                            class="fas fa-paperclip"></i>
                                                                        مرفقات العميل</a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light check-medical-hospital"
                                                                        href="{{ route('clients.print.payments', $customer->id) }}"><i
                                                                            class="fas fa-money-check-alt"></i> عمليات
                                                                        الدفع</a></li>
                                                            </ul>
                                                        </li>

                                                        <!-- المرفقات -->
                                                        <li class="dropdown">
                                                            <a class="dropdown-item text-primary dropdown-toggle"
                                                                href="#" id="submenu-toggle">
                                                                <i class="fas fa-file-upload"></i> المرفقات
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end submenu"
                                                                aria-labelledby="submenu-toggle">
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i class="fas fa-download"></i>
                                                                        تحميل </a></li>
                                                                <li><a class="dropdown-item text-dark hover:bg-light"
                                                                        href="#"><i class="fas fa-eye"></i> عرض </a>
                                                                </li>
                                                            </ul>
                                                        </li>


                                                        <!-- تصدير إلى إكسل -->
                                                        <li><a class="dropdown-item text-success" href="#"><i
                                                                    class="fas fa-file-excel"></i> تصدير العميل إكسيل</a>
                                                        </li>

                                                        <!-- إضافة العميل إلى القائمة السوداء -->

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
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        .table-responsive {
            overflow: visible;
        }

        .content-wrapper {
            width: fit-content;
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
            right: 100%;
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
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".check-medical-status").forEach(button => {
                button.addEventListener("click", async function(event) {
                    event.preventDefault();

                    let mrzCode = this.getAttribute("data-mrz");

                    try {
                        let response = await fetch(
                            "http://localhost:3000/check-status", { // Use 127.0.0.1 instead of localhost
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    mrzCode: mrzCode
                                })
                            });

                        if (!response.ok) throw new Error(
                            `HTTP Error! Status: ${response.status}`);

                        let result = await response.json();

                        if (result.status === "success") {
                            Swal.fire({
                                title: "تم اصدار نتيجة الكشف الطبي بنجاح",
                                icon: "success",
                                confirmButtonText: "تم",
                                showCancelButton: true,
                                cancelButtonText: "عرض النتيجة",
                                didOpen: () => {
                                    const cancelButton = document.querySelector(
                                        ".swal2-cancel");
                                    if (cancelButton) {
                                        cancelButton.addEventListener("click",
                                            () => {
                                                window.open(result.pdf_url,
                                                    "_blank"
                                                ); // Replace with actual PDF link
                                            });
                                    }
                                }
                            });
                        } else {
                            alert("⚠️ " + result.message);
                        }

                    } catch (error) {
                        alert("❌ Error: " + error.message);
                    }
                });
            });


            // المستشفي

            document.querySelectorAll(".check-medical-hopital").forEach(button => {
                button.addEventListener("click", async function(event) {
                    event.preventDefault();

                    try {
                        // إرسال الطلب لجلب بيانات المستشفى
                        let response = await fetch("http://localhost:3000/get-hospital", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                passport: "A23294560",
                                nationality: "Egyptian"
                            })
                        });

                        if (!response.ok) throw new Error(
                            `HTTP Error! Status: ${response.status}`);

                        let result = await response.json();

                        if (result.hospitalName && result.address && result.phone) {
                            // عرض بيانات المستشفى في SweetAlert
                            Swal.fire({
                                title: "✅ بيانات المستشفى",
                                html: `
                        <b>🏥 اسم المركز الطبي:</b> ${result.hospitalName} <br><br>
                        <b>📍 العنوان:</b> ${result.address} <br><br>
                        <b>📞 رقم الهاتف:</b> ${result.phone}
                    `,
                                icon: "info",
                                showCancelButton: true,
                                confirmButtonText: "إغلاق",
                                cancelButtonText: "📩 إرسال رسالة",
                            }).then(async (swalResult) => {
                                if (swalResult.dismiss === Swal.DismissReason
                                    .cancel) {
                                    await sendSms(result);
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "⚠️ لم يتم العثور على البيانات",
                                text: "يرجى التحقق من رقم جواز السفر والجنسية والمحاولة مرة أخرى.",
                                icon: "warning",
                                confirmButtonText: "إغلاق"
                            });
                        }

                    } catch (error) {
                        Swal.fire({
                            title: "❌ خطأ",
                            text: "حدث خطأ أثناء معالجة الطلب: " + error.message,
                            icon: "error",
                            confirmButtonText: "إغلاق"
                        });
                    }
                });
            });

            // دالة لإرسال الرسالة النصية
            async function sendSms(hospitalData) {
                try {
                    let smsResponse = await fetch("http://localhost:3000/send-sms", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            recipient: "201222540002",
                            hospitalName: hospitalData.hospitalName,
                            address: hospitalData.address,
                            phone: hospitalData.phone
                        })
                    });

                    let smsResult = await smsResponse.json();

                    if (smsResult.status === 'success') {
                        Swal.fire({
                            title: "✅ تم إرسال الرسالة بنجاح",
                            text: "تم إرسال بيانات المستشفى عبر الرسائل القصيرة.",
                            icon: "success",
                            confirmButtonText: "حسناً"
                        });
                    } else {
                        Swal.fire({
                            title: "⚠️ فشل في الإرسال",
                            text: "لم يتم إرسال الرسالة. حاول مرة أخرى لاحقًا.",
                            icon: "warning",
                            confirmButtonText: "إغلاق"
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        title: "❌ خطأ",
                        text: "حدث خطأ أثناء إرسال الرسالة: " + error.message,
                        icon: "error",
                        confirmButtonText: "إغلاق"
                    });
                }
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
                        Swal.fire({
                            title: "✅ تم إرسال الرسالة بنجاح",
                            text: "تم إرسال بيانات المستشفى عبر الرسائل القصيرة.",
                            icon: "success",
                            confirmButtonText: "حسناً"
                        });
                    } else {
                        Swal.fire({
                            title: "⚠️ فشل في الإرسال",
                            text: "لم يتم إرسال الرسالة. حاول مرة أخرى لاحقًا.",
                            icon: "warning",
                            confirmButtonText: "إغلاق"
                        });
                    }
                } catch (error) {
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
            dom: 'Bfrtip', // تخصيص ترتيب العناصر
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel"></i> تصدير إلى Excel',
                    className: 'buttons-excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3] // Specify which columns to export (0-based index)
                    }
                },

                {
                    extend: 'print',
                    text: '<i class="fa fa-file-pdf"></i> طباعة',
                    className: 'buttons-pdf',
                    customize: function(win) {
                        $(win.document.body).css('direction', 'rtl'); // Set text direction to right-to-left
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', '12px'); // Adjust font size
                    }
                },

            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            },
            searching: false,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "الكل"]
            ],
        });

        // document.addEventListener("DOMContentLoaded", function() {
        //     document.querySelectorAll(".dropdown-submenu > a").forEach((element) => {
        //         element.addEventListener("click", function(e) {
        //             e.preventDefault();
        //             let submenu = this.nextElementSibling;
        //             if (submenu.style.display === "block") {
        //                 submenu.style.display = "none";
        //             } else {
        //                 submenu.style.display = "block";
        //             }
        //         });
        //     });
        // });
    </script>
@stop
