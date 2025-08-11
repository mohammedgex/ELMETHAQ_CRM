@extends('adminlte::page')

@section('title', 'فلترة العملاء')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-filter text-primary"></i>
                        فلترة العملاء
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('customers.filter') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">فلترة العملاء</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Filter Card -->
        @if (empty($customers) || $customers == 'undefined')
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-search"></i>
                        بحث وفلترة العملاء
                    </h3>
                </div>
                <div class="card-body">
                    <form id="filterForm" method="POST" action="{{ route('customers.filter.data') }}">
                        @csrf
                        <div class="row">

                            <!-- الحقيبة -->
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-briefcase text-success"></i>
                                        الحقيبة
                                    </label>
                                    <select name="package_ids[]" id="package_id" class="form-control select2"
                                        data-placeholder="اختر الحقيبة" multiple>
                                        <option></option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}"
                                                {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                                {{ $package->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- المندوب -->
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user-tie text-success"></i>
                                        المندوب
                                    </label>
                                    <select name="delegates[]" id="delegates" class="form-control select2"
                                        data-placeholder="اختر المناديب" multiple>
                                        <option></option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{ $delegate->id }}"
                                                {{ in_array($delegate->id, request('delegates', [])) ? 'selected' : '' }}>
                                                {{ $delegate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- الوظيفة -->
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user-tie text-success"></i>
                                        الوظيفة
                                    </label>
                                    <select name="job_title_ids[]" id="job_title_id" class="form-control select2"
                                        data-placeholder="اختر الوظيفة" multiple>
                                        <option></option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- المحافظة -->
                            <!-- المحافظة -->
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        المحافظة
                                    </label>
                                    <select name="governorates[]" id="governorate" class="form-control select2"
                                        data-placeholder="اختر المحافظة" multiple>
                                        <option></option>
                                        <option value="القاهرة">القاهرة</option>
                                        <option value="الجيزة">الجيزة</option>
                                        <option value="الأسكندرية">الأسكندرية</option>
                                        <option value="الدقهلية">الدقهلية</option>
                                        <option value="البحر الأحمر">البحر الأحمر</option>
                                        <option value="البحيرة">البحيرة</option>
                                        <option value="الفيوم">الفيوم</option>
                                        <option value="الغربية">الغربية</option>
                                        <option value="الإسماعيلية">الإسماعيلية</option>
                                        <option value="المنوفية">المنوفية</option>
                                        <option value="المنيا">المنيا</option>
                                        <option value="القليوبية">القليوبية</option>
                                        <option value="الوادي الجديد">الوادي الجديد</option>
                                        <option value="السويس">السويس</option>
                                        <option value="أسوان">أسوان</option>
                                        <option value="أسيوط">أسيوط</option>
                                        <option value="بني سويف">بني سويف</option>
                                        <option value="بورسعيد">بورسعيد</option>
                                        <option value="دمياط">دمياط</option>
                                        <option value="الشرقية">الشرقية</option>
                                        <option value="جنوب سيناء">جنوب سيناء</option>
                                        <option value="كفر الشيخ">كفر الشيخ</option>
                                        <option value="مطروح">مطروح</option>
                                        <option value="الأقصر">الأقصر</option>
                                        <option value="قنا">قنا</option>
                                        <option value="شمال سيناء">شمال سيناء</option>
                                        <option value="سوهاج">سوهاج</option>
                                        <option value="السعودية">السعودية</option>
                                        <option value="القدس">القدس</option>
                                        <option value="الأردن">الأردن</option>
                                        <option value="العراق">العراق</option>
                                        <option value="لبنان">لبنان</option>
                                        <option value="فلسطين">فلسطين</option>
                                        <option value="اليمن">اليمن</option>
                                        <option value="عمان">عمان</option>
                                        <option value="الإمارات العربية المتحدة">الإمارات العربية المتحدة</option>
                                        <option value="الكويت">الكويت</option>
                                        <option value="قطر">قطر</option>
                                        <option value="البحرين">البحرين</option>
                                    </select>
                                </div>
                            </div>

                            <!-- الكفيل -->
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user-shield text-warning"></i>
                                        الكفلاء
                                        <span class="badge badge-warning" id="sponsor-count">0</span>
                                    </label>
                                    <select name="sponsor_ids[]" id="sponsor_ids" class="form-control select2" multiple
                                        data-placeholder="اختر الكفلاء...">
                                        @foreach ($sponsors as $sponsor)
                                            <option value="{{ $sponsor->id }}"
                                                {{ in_array($sponsor->id, request('sponsor_ids', [])) ? 'selected' : '' }}>
                                                {{ $sponsor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">يمكنك اختيار أكثر من كفيل</small>
                                </div>
                            </div>

                            <!-- القنصلية -->
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-building text-info"></i>
                                        القنصليات
                                        <span class="badge badge-info" id="consulate-count">0</span>
                                    </label>
                                    <select name="consulate_ids[]" id="consulate_ids" class="form-control select2"
                                        multiple data-placeholder="اختر القنصليات...">
                                        @foreach ($consulates as $consulate)
                                            <option value="{{ $consulate->id }}"
                                                {{ in_array($consulate->id, request('consulate_ids', [])) ? 'selected' : '' }}>
                                                {{ $consulate->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">يمكنك اختيار أكثر من قنصلية</small>
                                </div>
                            </div>

                            <!-- التأشيرات -->
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-passport text-danger"></i>
                                        التأشيرات
                                        <span class="badge badge-danger" id="visa-count">0</span>
                                    </label>
                                    <select name="visa_ids[]" id="visa_ids" class="form-control select2" multiple
                                        data-placeholder="اختر التأشيرات...">
                                        @if (isset($visas) && count($visas))
                                            @foreach ($visas as $visa)
                                                <option value="{{ $visa->id }}" selected>{{ $visa->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="form-text text-muted">يمكنك اختيار أكثر من تأشيرة</small>
                                </div>
                            </div>

                            <!-- المجموعات -->
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-layer-group text-purple"></i>
                                        المجموعات
                                        <span class="badge badge-purple" id="group-count">0</span>
                                    </label>
                                    <select name="group_ids[]" id="group_ids" class="form-control select2" multiple
                                        data-placeholder="اختر المجموعات...">
                                        @if (isset($groups) && count($groups))
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="form-text text-muted">المجموعات المرتبطة بالتأشيرات المختارة</small>
                                </div>
                            </div>

                            <!-- أزرار التحكم -->
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label class="form-label d-block">&nbsp;</label>
                                    <div class="btn-group w-100" role="group">
                                        <button type="submit" class="btn btn-primary" id="searchBtn">
                                            <i class="fas fa-search"></i>
                                            بحث
                                        </button>
                                        <a href="{{ route('customers.filter') }}">
                                            <button type="button" class="btn btn-secondary">
                                                <i class="fas fa-undo"></i>
                                                إعادة تعيين
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Loading Overlay -->
                <div class="overlay" id="loadingOverlay" style="display: none;">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            </div>
        @endif

        <!-- Results Section -->
        @if (isset($customers) && $customers->count() > 0)
            <div id="results-section" style="">
                <div class="table-responsive">
                    <table class="table table-hover text-center" id="example">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>
                                </th>
                                <th>كود العميل</th>
                                <th>اسم العميل</th>
                                <th>الصورة</th>
                                <th>الهاتف</th>
                                <th>السن</th>
                                <th>المندوب</th>
                                <th>التاشيرة</th>
                                <th>المجموعة</th>
                                <th>الحقيبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr
                                    style="
                                                    @if ($customer->blackList && $customer->blackList->block) background-color: #f8d7da; color: #721c24;
                                                    @elseif(is_null($customer->passport_expire_date))
                                                        background-color: #664d03; @endif
                                                ">
                                    <td style="position: relative !important;" class="text-center align-middle">

                                    </td>
                                    <td>#{{ $customer->id }}</td>
                                    <td><a href="{{ route('customer.add', $customer->id) }}">{{ $customer->name_ar }}</a>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif (isset($customers) && $customers->count() == 0)
            <div id="results-section" style="">
                <h1>لا توجد بيانات</h1>
            </div>
        @endif
    </div>
@stop

@section('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* الوضع الفاتح - Light Mode */
        body:not(.dark-mode) {
            background-color: #f4f6f9;
            color: #212529;
        }

        body:not(.dark-mode) .card {
            background-color: #fff;
            border-color: #ced4da;
        }

        /* Select2 في الوضع الفاتح */
        body:not(.dark-mode) .select2-container--default .select2-selection--single,
        body:not(.dark-mode) .select2-container--default .select2-selection--multiple {
            background-color: #fff;
            border-color: #ced4da;
            color: #495057;
        }

        body:not(.dark-mode) .select2-dropdown {
            background-color: #fff;
            border-color: #ced4da;
            color: #212529;
        }

        body:not(.dark-mode) .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
            color: white;
        }

        /* ألوان البادج */
        body:not(.dark-mode) .badge-purple {
            background-color: #6f42c1;
            color: #fff;
        }

        body:not(.dark-mode) .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        body:not(.dark-mode) .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        body:not(.dark-mode) .badge-info {
            background-color: #17a2b8;
            color: #fff;
        }

        /* أزرار الوضع الفاتح */
        body:not(.dark-mode) .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        body:not(.dark-mode) .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        /* مؤشر التحميل الوضع الفاتح */
        body:not(.dark-mode) .loading-spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
        }

        /* ------------------------------------------ */
        /* الوضع الداكن - Dark Mode */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .card {
            background-color: #1e1e1e;
            border-color: #333;
        }

        body.dark-mode .select2-container--default .select2-selection--single,
        body.dark-mode .select2-container--default .select2-selection--multiple {
            background-color: #2c2c2c;
            border-color: #555;
            color: #e0e0e0;
        }

        body.dark-mode .select2-dropdown {
            background-color: #2c2c2c;
            border-color: #555;
            color: #e0e0e0;
        }

        body.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3a6ffb;
            color: white;
        }

        /* ألوان البادج في الداكن */
        body.dark-mode .badge-purple {
            background-color: #9a75e6;
            color: #f0f0f0;
        }

        body.dark-mode .badge-danger {
            background-color: #e55353;
            color: #fff;
        }

        body.dark-mode .badge-warning {
            background-color: #d6a100;
            color: #fff;
        }

        body.dark-mode .badge-info {
            background-color: #4da6ff;
            color: #fff;
        }

        /* أزرار الداكن */
        body.dark-mode .btn-primary {
            background-color: #3a6ffb;
            border-color: #3a6ffb;
        }

        body.dark-mode .btn-secondary {
            background-color: #555;
            border-color: #555;
        }

        /* مؤشر التحميل في الداكن */
        body.dark-mode .loading-spinner {
            border: 2px solid #444;
            border-top: 2px solid #3a6ffb;
        }

        /* ------------------------------------------ */
        /* أنماط مشتركة بدون تضارب */

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border-radius: 0.25rem !important;
            padding: 6px 12px !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
        }

        .select2-container--default .select2-selection--multiple {
            min-height: 38px !important;
            border-radius: 0.25rem !important;
        }

        .select2-container--default .select2-selection__rendered {
            line-height: 26px !important;
            padding-left: 0 !important;
        }

        .select2-container--default .select2-selection__arrow {
            height: 36px !important;
        }

        /* عند التركيز */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #80bdff !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        }

        /* القائمة المنسدلة */
        .select2-dropdown {
            border-radius: 0.25rem !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        /* تحسين المظهر العام */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-label i {
            margin-left: 5px;
        }

        /* تأثيرات التحميل */
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* تحسين الأزرار */
        .btn-group .btn {
            border-radius: 0.25rem;
            margin-left: 2px;
        }

        .btn-group .btn:first-child {
            margin-left: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                margin-left: 0;
                margin-bottom: 5px;
                border-radius: 0.25rem !important;
            }
        }

        /* Badge styling */
        #visa-count,
        #sponsor-count,
        #consulate-count,
        #group-count {
            font-size: 0.75rem;
            vertical-align: top;
        }

        /* ضبط خيارات Select2 المختارة في الداكن */
        body.dark-mode .select2-selection__choice {
            background-color: #3a3a3a;
            /* لون خلفية العنصر */
            border: 1px solid #555;
            /* حدود العنصر */
            color: #e0e0e0;
            /* لون النص */
            padding: 2px 5px;
            margin: 2px 5px 2px 0;
            border-radius: 0.25rem;
            display: inline-flex;
            align-items: center;
        }

        /* زر إزالة العنصر في الداكن */
        body.dark-mode .select2-selection__choice__remove {
            color: #bbb;
            background: transparent;
            border: none;
            font-weight: bold;
            margin-left: 5px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        body.dark-mode .select2-selection__choice__remove:hover {
            color: #ff5c5c;
            /* لون أحمر عند المرور بالفأرة */
        }

        /* نص الخيار المختار */
        body.dark-mode .select2-selection__choice__display {
            color: black;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #121212 !important;
        }
    </style>
@stop

@section('js')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // تفعيل Select2 مع التحسينات
            $('.select2').select2({
                theme: 'default',
                width: '100%',
                allowClear: true,
                dir: "rtl",
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    },
                    searching: function() {
                        return "جاري البحث...";
                    },
                    loadingMore: function() {
                        return "جاري تحميل المزيد...";
                    },
                    inputTooShort: function() {
                        return "يرجى إدخال حرف واحد على الأقل";
                    }
                }
            });

            // تحديث عدادات الاختيارات
            function updateCounts() {
                // عداد التأشيرات
                const visaCount = $('#visa_ids').val() ? $('#visa_ids').val().length : 0;
                $('#visa-count').text(visaCount);

                // عداد الكفلاء
                const sponsorCount = $('#sponsor_ids').val() ? $('#sponsor_ids').val().length : 0;
                $('#sponsor-count').text(sponsorCount);

                // عداد القنصليات
                const consulateCount = $('#consulate_ids').val() ? $('#consulate_ids').val().length : 0;
                $('#consulate-count').text(consulateCount);

                // عداد المجموعات
                const groupCount = $('#group_ids').val() ? $('#group_ids').val().length : 0;
                $('#group-count').text(groupCount);
            }

            // استدعاء العدادات عند التحميل
            updateCounts();

            // عند تغيير أي اختيار
            $('#visa_ids, #sponsor_ids, #consulate_ids, #group_ids').on('change', function() {
                updateCounts();
            });

            // عند تغيير الكفلاء أو القنصليات -> جلب التأشيرات
            $('#sponsor_ids, #consulate_ids').on('change', function() {
                loadVisas();
            });

            // عند تغيير التأشيرات -> جلب المجموعات
            $('#visa_ids').on('change', function() {
                loadGroups();
                updateCounts();
            });

            // دالة جلب التأشيرات مع معالجة أفضل للأخطاء
            function loadVisas() {
                const sponsorIds = $('#sponsor_ids').val() || [];
                const consulateIds = $('#consulate_ids').val() || [];

                // إظهار مؤشر التحميل
                $('#visa_ids').prop('disabled', true);
                const visaSelect = $('#visa_ids');

                // تعيين placeholder للتحميل
                visaSelect.empty().append('<option></option>');
                visaSelect.select2({
                    placeholder: 'جاري تحميل التأشيرات...',
                    theme: 'default',
                    width: '100%',
                    allowClear: true,
                    dir: "rtl"
                });

                // التحقق من وجود بيانات للإرسال
                if (sponsorIds.length === 0 && consulateIds.length === 0) {
                    resetVisaSelect();
                    return;
                }

                // إرسال طلب Ajax
                $.ajax({
                    url: '{{ route('admin.visas.byFilters') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        sponsor_ids: sponsorIds,
                        consulate_ids: consulateIds,
                        _token: '{{ csrf_token() }}'
                    },
                    timeout: 10000,
                    success: function(response) {
                        console.log('Response received:', response); // للتشخيص

                        try {
                            let data = response;

                            // مسح الخيارات الحالية
                            visaSelect.empty();

                            // إضافة التأشيرات الجديدة
                            if (data && Array.isArray(data) && data.length > 0) {
                                data.forEach(function(visa) {
                                    console.log('Adding visa:', visa); // للتشخيص
                                    if (visa && (visa.id || visa.id === 0) && visa.name) {
                                        visaSelect.append(
                                            `<option value="${visa.id}">${visa.name}</option>`
                                        );
                                    }
                                });

                                // إظهار رسالة نجاح
                                if (typeof toastr !== 'undefined') {
                                    toastr.success(`تم تحميل ${data.length} تأشيرة بنجاح`);
                                }

                                console.log(`Added ${data.length} visas to select`);
                            } else {
                                console.log('No visas found in response');
                                // لا توجد تأشيرات
                                if (typeof toastr !== 'undefined') {
                                    toastr.info('لا توجد تأشيرات متاحة للمعايير المحددة');
                                }
                            }

                            resetVisaSelect();

                        } catch (error) {
                            console.error('خطأ في معالجة الاستجابة:', error);
                            handleVisaLoadError('خطأ في معالجة البيانات المستلمة');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('خطأ في Ajax:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });

                        let errorMessage = 'حدث خطأ في تحميل التأشيرات';

                        if (xhr.status === 404) {
                            errorMessage = 'رابط API غير موجود';
                        } else if (xhr.status === 500) {
                            errorMessage = 'خطأ في الخادم';
                        } else if (status === 'timeout') {
                            errorMessage = 'انتهت مهلة الاتصال';
                        } else if (status === 'parsererror') {
                            errorMessage = 'خطأ في تحليل الاستجابة';
                        }

                        handleVisaLoadError(errorMessage);
                    }
                });
            }

            function resetGroupSelect() {
                $('#group_ids').empty().select2({
                    placeholder: 'اختر المجموعات...',
                    theme: 'default',
                    width: '100%',
                    allowClear: true,
                    dir: "rtl",
                    multiple: true
                });
            }

            function handleGroupLoadError(message) {
                $('#group_ids').empty();
                resetGroupSelect();
                if (typeof toastr !== 'undefined') {
                    toastr.error(message);
                } else {
                    alert(message);
                }
            }


            // دالة جلب المجموعات بناءً على التأشيرات المختارة
            function loadGroups() {
                const visaIds = $('#visa_ids').val() || [];

                // تعطيل السيلكت أثناء التحميل
                $('#group_ids').prop('disabled', true);
                const groupSelect = $('#group_ids');

                // تعيين placeholder للتحميل مؤقتًا
                groupSelect.empty().append('<option></option>');
                groupSelect.select2({
                    placeholder: 'جاري تحميل المجموعات...',
                    theme: 'default',
                    width: '100%',
                    allowClear: true,
                    dir: "rtl"
                });

                if (visaIds.length === 0) {
                    resetGroupSelect();
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.groups.byVisas') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        visa_ids: visaIds,
                        _token: '{{ csrf_token() }}'
                    },
                    timeout: 10000,
                    success: function(response) {
                        try {
                            let data = response;

                            // إعادة تهيئة السيلكت (تفريغ وإعادة تهيئة select2)
                            resetGroupSelect();

                            if (data && Array.isArray(data) && data.length > 0) {
                                data.forEach(function(group) {
                                    if (group && (group.id || group.id === 0) && group.name) {
                                        groupSelect.append(
                                            `<option value="${group.id}">${group.name}</option>`
                                        );
                                    }
                                });

                                groupSelect.trigger('change'); // لتحديث عرض select2

                                if (typeof toastr !== 'undefined') {
                                    toastr.success(`تم تحميل ${data.length} مجموعة بنجاح`);
                                }
                            } else {
                                if (typeof toastr !== 'undefined') {
                                    toastr.info('لا توجد مجموعات متاحة للتأشيرات المختارة');
                                }
                            }

                            // إعادة تمكين السيلكت بعد التحميل
                            groupSelect.prop('disabled', false);

                        } catch (error) {
                            console.error('خطأ في معالجة استجابة المجموعات:', error);
                            handleGroupLoadError('خطأ في معالجة بيانات المجموعات');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('خطأ في Ajax المجموعات:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });

                        let errorMessage = 'حدث خطأ في تحميل المجموعات';

                        if (xhr.status === 404) {
                            errorMessage = 'رابط API المجموعات غير موجود';
                        } else if (xhr.status === 500) {
                            errorMessage = 'خطأ في خادم المجموعات';
                        } else if (status === 'timeout') {
                            errorMessage = 'انتهت مهلة اتصال المجموعات';
                        }

                        handleGroupLoadError(errorMessage);
                    }
                });
            }


            // دالة إعادة تعيين select التأشيرات
            function resetVisaSelect() {
                $('#visa_ids').prop('disabled', false);
                $('#visa_ids').select2({
                    placeholder: 'اختر التأشيرات...',
                    theme: 'default',
                    width: '100%',
                    allowClear: true,
                    dir: "rtl",
                    multiple: true
                });
                updateCounts();
            }

            // دالة معالجة أخطاء تحميل التأشيرات
            function handleVisaLoadError(message) {
                $('#visa_ids').empty();
                resetVisaSelect();

                // إظهار رسالة خطأ
                if (typeof toastr !== 'undefined') {
                    toastr.error(message);
                } else {
                    alert(message);
                }
            }

            // إضافة مؤشر تحميل للنموذج
            $('#filterForm').on('submit', function() {
                $('#searchBtn').prop('disabled', true).html(
                    '<span class="loading-spinner"></span> جاري البحث...');
                $('#loadingOverlay').show();

                // إعادة تفعيل الزر بعد 3 ثواني (في حالة عدم إعادة التوجيه)
                setTimeout(function() {
                    $('#searchBtn').prop('disabled', false).html(
                        '<i class="fas fa-search"></i> بحث');
                    $('#loadingOverlay').hide();
                }, 3000);
            });

            // تحسين UX - إخفاء رسائل التحميل تلقائياً
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "3000",
                    "positionClass": "toast-top-left",
                    "rtl": true
                };
            }
        });
    </script>
@stop
