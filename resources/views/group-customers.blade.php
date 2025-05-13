@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    @if (!empty($group))
        <div class="d-flex justify-content-between">
            <h1>العملاء في مجموعة ({{ $group->title }})</h1>
            <button id="openPopupBtn"
                style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">اضافة
                عميل</button>
        </div>
    @elseif (!empty($bag))
        <h1>العملاء في حقيبة ({{ $bag->name }})</h1>
    @endif

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow border-0">

                    <div class="card-body">

                        <hr> <!-- Divider -->
                        @if (!empty($group))
                            <div class="row g-2 mb-4">

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                    <button class="btn btn-outline-primary active">الكل</button>
                                </form>
                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="status" value="جديد">
                                    <button type="submit" class="btn btn-outline-success">جديد</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="medical_examination" value="تم الحجز">
                                    <button class="btn btn-outline-info">تم حجز الكشف الطبي</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="finger_print_examination" value="تم تصدير الاكسيل">
                                    <button class="btn btn-outline-info">تم عمل البصمة</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="virus_examination" value="تم اصدار ايصال المعامل">
                                    <button class="btn btn-outline-info">تم أصدر كشف المعامل</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="engaz_request" value="تم الحجز">
                                    <button class="btn btn-outline-info">تم أصدر طلب انجاز</button>
                                </form>
                                <div class="col-auto">
                                    <button class="btn btn-outline-success"> المؤهلون للقنصلية </button>
                                </div>
                                <div class="col-auto">
                                    <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                    <button class="btn btn-outline-primary">تم أصدار التأشيرة</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-outline-success">تم السفر</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-outline-dark">أرشيف</button>
                                </div>
                            </div>
                        @else
                            <div class="row g-2 mb-4">

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="bag_id" value="{{ $bag->id }}">
                                    <button class="btn btn-outline-primary active">الكل</button>
                                </form>
                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="bag_id" value="{{ $bag->id }}">
                                    <input type="hidden" name="status" value="جديد">
                                    <button type="submit" class="btn btn-outline-success">جديد</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="bag_id" value="{{ $bag->id }}">
                                    <input type="hidden" name="medical_examination" value="تم الحجز">
                                    <button class="btn btn-outline-info">تم حجز الكشف الطبي</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="bag_id" value="{{ $bag->id }}">
                                    <input type="hidden" name="finger_print_examination" value="تم تصدير الاكسيل">
                                    <button class="btn btn-outline-info">تم عمل البصمة</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="bag_id" value="{{ $bag->id }}">
                                    <input type="hidden" name="virus_examination" value="تم اصدار ايصال المعامل">
                                    <button class="btn btn-outline-info">تم أصدر كشف المعامل</button>
                                </form>

                                <form id="filterForm" class="col-auto" method="POST"
                                    action="{{ route('filterGroupAndBag') }}">
                                    @csrf
                                    <input type="hidden" name="bag_id" value="{{ $bag->id }}">
                                    <input type="hidden" name="engaz_request" value="تم الحجز">
                                    <button class="btn btn-outline-info">تم أصدر طلب انجاز</button>
                                </form>
                                <div class="col-auto">
                                    <button class="btn btn-outline-success"> المؤهلون للقنصلية </button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-outline-primary">تم أصدار التأشيرة</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-outline-success">تم السفر</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-outline-dark">أرشيف</button>
                                </div>
                            </div>
                        @endif



                        <div class="table-responsive">
                            @if (!empty($group))
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
                                            <th>الرقم القومي</th>
                                            <th>الحالة</th>
                                            <th>الكشف الطبي</th>
                                            <th>البصمة</th>
                                            <th>كشف المعامل</th>
                                            <th>انجاز</th>
                                            <th> الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            {{-- <tr class="table-light"> --}}
                                            <tr
                                                class="{{ $customer->blackList && $customer->blackList->block ? 'table-danger' : 'table-light' }}">
                                                <td>
                                                    <input type="checkbox" id="myCheckbox"
                                                        class="row-checkbox form-check-input rounded">
                                                </td>
                                                <td>#{{ $customer->id }}</td>
                                                <td class="highlight"><a
                                                        href="{{ route('customer.add', $customer->id) }}">{{ $customer->name_ar }}</a>
                                                </td>

                                                <td class="highlight">{{ $customer->card_id }}</td>
                                                <td class="highlight">{{ $customer->status }}</td>
                                                <td class="highlight">
                                                    @if ($customer->medical_examination == 'تم الحجز')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>

                                                <td class="highlight">
                                                    @if ($customer->finger_print_examination == 'تم تصدير الاكسيل')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>
                                                <td class="highlight">
                                                    @if ($customer->virus_examination == 'تم اصدار ايصال المعامل')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>
                                                <td class="highlight">
                                                    @if ($customer->engaz_request == 'تم الحجز')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <button
                                                            class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
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
                                                                            href="#"><i class="fas fa-globe"></i>
                                                                            حجز
                                                                            نت</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light"
                                                                            href="#"><i class="fas fa-passport"></i>
                                                                            بيانات التأشيرة</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light"
                                                                            href="#"><i class="fas fa-virus"></i>
                                                                            كشف
                                                                            الفايرس</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light check-medical-status"
                                                                            href="#"><i class="fas fa-hospital"></i>
                                                                            نتيجة كشف طبي</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light check-medical-hospital"
                                                                            href="#"><i
                                                                                class="fas fa-clinic-medical"></i>
                                                                            نتيجة
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
                                                                            href="#"><i class="fas fa-file-alt"></i>
                                                                            ملف
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
                                                                    <li><a class="dropdown-item text-dark hover:bg-light "
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
                                                                            href="#"><i class="fas fa-eye"></i> عرض
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>


                                                            <!-- تصدير إلى إكسل -->
                                                            <li><a class="dropdown-item text-success" href="#"><i
                                                                        class="fas fa-file-excel"></i> تصدير العميل
                                                                    إكسيل</a>
                                                            </li>

                                                            <!-- إضافة العميل إلى القائمة السوداء -->

                                                        </ul>
                                                    </div>
                                                </td>



                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif (!empty($bag))
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
                                            <th>الرقم القومي</th>
                                            <th>الحالة</th>
                                            <th>الكشف الطبي</th>
                                            <th>البصمة</th>
                                            <th>كشف المعامل</th>
                                            <th>انجاز</th>
                                            <th> الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            {{-- <tr class="table-light"> --}}
                                            <tr
                                                class="{{ $customer->blackList && $customer->blackList->block ? 'table-danger' : 'table-light' }}">
                                                <td>
                                                    <input type="checkbox" id="myCheckbox"
                                                        class="row-checkbox form-check-input rounded">
                                                </td>
                                                <td>#{{ $customer->id }}</td>
                                                <td class="highlight"><a
                                                        href="{{ route('customer.add', $customer->id) }}">{{ $customer->name_ar }}</a>
                                                </td>

                                                <td class="highlight">{{ $customer->card_id }}</td>
                                                <td class="highlight">{{ $customer->status }}</td>
                                                <td class="highlight">
                                                    @if ($customer->medical_examination == 'تم الحجز')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>

                                                <td class="highlight">
                                                    @if ($customer->finger_print_examination == 'تم تصدير الاكسيل')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>
                                                <td class="highlight">
                                                    @if ($customer->virus_examination == 'تم اصدار ايصال المعامل')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>
                                                <td class="highlight">
                                                    @if ($customer->engaz_request == 'تم الحجز')
                                                        <span style="color: green; font-size: 24px;">&#10004;</span>
                                                    @else
                                                        <span style="color: red; font-size: 24px;">&#10006;</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <button
                                                            class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
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
                                                                            href="#"><i class="fas fa-globe"></i>
                                                                            حجز
                                                                            نت</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light"
                                                                            href="#"><i class="fas fa-passport"></i>
                                                                            بيانات التأشيرة</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light"
                                                                            href="#"><i class="fas fa-virus"></i>
                                                                            كشف
                                                                            الفايرس</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light check-medical-status"
                                                                            href="#"><i class="fas fa-hospital"></i>
                                                                            نتيجة كشف طبي</a></li>
                                                                    <li><a class="dropdown-item text-dark hover:bg-light check-medical-hospital"
                                                                            href="#"><i
                                                                                class="fas fa-clinic-medical"></i>
                                                                            نتيجة
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
                                                                            href="#"><i class="fas fa-file-alt"></i>
                                                                            ملف
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
                                                                    <li><a class="dropdown-item text-dark hover:bg-light "
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
                                                                            href="#"><i class="fas fa-eye"></i> عرض
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>


                                                            <!-- تصدير إلى إكسل -->
                                                            <li><a class="dropdown-item text-success" href="#"><i
                                                                        class="fas fa-file-excel"></i> تصدير العميل
                                                                    إكسيل</a>
                                                            </li>

                                                            <!-- إضافة العميل إلى القائمة السوداء -->

                                                        </ul>
                                                    </div>
                                                </td>



                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div> <!-- End card-body -->
                </div> <!-- End card -->
            </div>
        </div>
    </div>
    @if (!empty($group))

        <!-- النافذة المنبثقة -->
        <!-- Popup Container -->
        <form action="{{ route('group.addToGroup', $group->id) }}" method="post" id="popup"
            style="
    display: none; 
    position: fixed; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%);
    background-color: #fff; 
    padding: 30px 35px; 
    border-radius: 12px; 
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15); 
    z-index: 1000; 
    width: 400px; 
    font-family: 'Arial', sans-serif;
">
            @csrf

            <!-- Title -->
            <h3
                style="
        text-align: center; 
        margin-bottom: 25px; 
        color: #2196F3; 
        font-size: 22px;
    ">
                اختـر العـميل</h3>

            <!-- Select Dropdown -->
            <select id="options" class="select2" name="customer_id"
                style="
        width: 100%; 
        padding: 12px 15px; 
        font-size: 16px; 
        border: 1px solid #ccc; 
        border-radius: 8px; 
        background-color: #f7f7f7;
    ">
                <option value="all">🔍 البحث في جميع الحقول</option>
                @foreach ($all as $cu)
                    <option value="{{ $cu->id }}">
                        {{ $cu->id }} : {{ explode(' ', $cu->name_ar)[0] }} : {{ $cu->card_id }}
                    </option>
                @endforeach
            </select>

            <!-- Close Button -->
            <div style="text-align: center; margin-top: 25px;">
                <button id="closePopupBtn"
                    style="
            padding: 12px 25px; 
            background-color: #e91e63; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 16px; 
            width: 100%;
        "
                    type="submit">اضافة</button>
            </div>
        </form>

        <!-- الخلفية المظللة -->
        <div id="overlay"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.3); z-index: 999;">
        </div>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            // فتح النافذة المنبثقة
            document.getElementById("openPopupBtn").addEventListener("click", function() {
                document.getElementById("popup").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            });

            // إغلاق النافذة المنبثقة
            document.getElementById("closePopupBtn").addEventListener("click", function() {
                document.getElementById("popup").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            });

            // إغلاق النافذة عند النقر على الخلفية
            document.getElementById("overlay").addEventListener("click", function() {
                document.getElementById("popup").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            });
            $(document).ready(function() {
                $('#options').select2({
                    dir: "rtl",
                    placeholder: 'اختر العميل...',
                    dropdownParent: $('#popup'),
                    language: {
                        noResults: function() {
                            return "لا توجد نتائج";
                        }
                    }
                });

                $('#closePopupBtn').click(function() {
                    $('#popup').hide();
                });
            });
        </script>
    @endif

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
                    console.log(mrzCode);

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

            document.querySelectorAll(".check-medical-hospital").forEach(button => {
                button.addEventListener("click", async function(event) {
                    let phone = this.getAttribute("data-phone");
                    console.log(phone);

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
                            recipient: `2${phone}`,
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
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel"></i> تصدير إلى Excel',
                    className: 'buttons-excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], // Ignore the checkbox column (start from 1)
                        rows: function(idx, data, node) {
                            // Only export rows where the checkbox is checked
                            return $(node).find('.row-checkbox').is(':checked');
                        }
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-file-pdf"></i> طباعة',
                    className: 'buttons-pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], // Ignore the checkbox column
                        rows: function(idx, data, node) {
                            return $(node).find('.row-checkbox').is(':checked');
                        }
                    },
                    customize: function(win) {
                        $(win.document.body).css('direction', 'rtl');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', '12px');
                    }
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            },
            searching: false,
            pageLength: 100,
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
