@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    @if (!empty($group))
        <div class="d-flex justify-content-between">
            <h1>العملاء في مجموعة ({{ $group->title }})</h1>
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
                        <hr>
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
                                <div class="table-responsive">
                                    <table class="table table-hover text-center" id="customersTable">
                                        <thead class="text-white"
                                            style="background: linear-gradient(45deg, #2c3e50, #3498db); border-radius: 10px;">
                                            <tr>
                                                <th width="40px" style="position: relative;">
                                                    <input type="checkbox" id="checkAll"
                                                        class="form-check-input rounded"
                                                        style="position: absolute;
                                                                                            right: 50%;
                                                                                            /* left: 50%; */
                                                                                            top: 50%;
                                                                                            margin: 0;
                                                                                            transform: translate(50%, -50%);">
                                                </th>
                                                <th>كود العميل</th>
                                                <th>اسم العميل</th>
                                                <th>الصورة</th>
                                                <th>الهاتف</th>
                                                <th width="120px">الكشف الطبي</th>
                                                <th width="120px">البصمة</th>
                                                <th width="120px">كشف المعامل</th>
                                                <th width="120px">انجاز</th>
                                                <th width="150px">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $customer)
                                                <tr
                                                    class="{{ $customer->blackList && $customer->blackList->block ? 'bg-light-danger' : 'bg-light' }}">
                                                    <td style="position: relative;">
                                                        <input type="checkbox" class="form-check-input rounded">
                                                    </td>
                                                    <td>#{{ $customer->id }}</td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $customer->image) }}"
                                                            target="blank">
                                                            <img src="{{ asset('storage/' . $customer->image) }}"
                                                                width="40" height="40" class="img-circle"
                                                                alt="صورة">
                                                        </a>
                                                    </td>
                                                    <td class="text-primary">
                                                        <a href="{{ route('customer.add', $customer->id) }}"
                                                            class="text-decoration-none">
                                                            {{ $customer->name_ar }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $customer->phone }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->medical_examination == 'لائق' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->medical_examination == 'لائق' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->finger_print_examination == 'تم تصدير الاكسيل' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->finger_print_examination == 'تم تصدير الاكسيل' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->virus_examination == 'تم اصدار ايصال المعامل' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->virus_examination == 'تم اصدار ايصال المعامل' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->engaz_request == 'تم الحجز' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->engaz_request == 'تم الحجز' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group dropstart">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer.add', $customer->id) }}">
                                                                        <i class="fas fa-edit text-primary me-2"></i> تعديل
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer.show', $customer->id) }}">
                                                                        <i class="fas fa-eye text-info me-2"></i> عرض
                                                                    </a>
                                                                </li>

                                                                @if ($customer->blackList)
                                                                    @if ($customer->blackList->block)
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('customers.unblock', $customer->id) }}">
                                                                                <i
                                                                                    class="fas fa-user-check text-success me-2"></i>
                                                                                إزالة البلوك
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('customers.block', $customer->id) }}">
                                                                                <i
                                                                                    class="fas fa-user-slash text-danger me-2"></i>
                                                                                بلوك
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                @endif

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i
                                                                            class="fas fa-clipboard-list text-warning me-2"></i>
                                                                        الكشوفات
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-globe me-2"></i> حجز
                                                                                نت</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-passport me-2"></i>
                                                                                بيانات التأشيرة</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-virus me-2"></i> كشف
                                                                                الفايرس</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-hospital me-2"></i> نتيجة
                                                                                كشف طبي</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-clinic-medical me-2"></i>
                                                                                نتيجة وبيانات المستشفى</a></li>
                                                                    </ul>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="fas fa-print text-secondary me-2"></i>
                                                                        طباعة
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-file-alt me-2"></i> ملف
                                                                                العميل</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-envelope me-2"></i> خطاب
                                                                                ترشيح</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-history me-2"></i> تاريخ
                                                                                العميل</a></li>
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('clients.print.attachments', $customer->id) }}"><i
                                                                                    class="fas fa-paperclip me-2"></i>
                                                                                مرفقات العميل</a></li>
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('clients.print.payments', $customer->id) }}"><i
                                                                                    class="fas fa-money-bill-wave me-2"></i>
                                                                                عمليات الدفع</a></li>
                                                                    </ul>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="fas fa-paperclip text-info me-2"></i>
                                                                        المرفقات
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-download me-2"></i>
                                                                                تحميل</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-eye me-2"></i> عرض</a>
                                                                        </li>
                                                                    </ul>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="fas fa-file-excel text-success me-2"></i>
                                                                        تصدير لإكسل
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif (!empty($bag))
                                <div class="table-responsive">
                                    <table class="table table-hover text-center" id="customersTable">
                                        <thead class="text-white"
                                            style="background: linear-gradient(45deg, #2c3e50, #3498db); border-radius: 10px;">
                                            <tr>
                                                <th width="40px" style="position: ">
                                                    <input type="checkbox" id="checkAll"
                                                        class="form-check-input rounded"
                                                        style="position: absolute;
                                                                        right: 50%;
                                                                        /* left: 50%; */
                                                                        top: 50%;
                                                                        margin: 0;
                                                                        transform: translate(50%, -50%);">
                                                </th>
                                                <th>كود العميل</th>
                                                <th>اسم العميل</th>
                                                <th>الصورة</th>
                                                <th>الهاتف</th>
                                                <th>الحالة</th>
                                                <th width="120px">الكشف الطبي</th>
                                                <th width="120px">البصمة</th>
                                                <th width="120px">كشف المعامل</th>
                                                <th width="120px">انجاز</th>
                                                <th width="150px">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $customer)
                                                <tr
                                                    class="{{ $customer->blackList && $customer->blackList->block ? 'bg-light-danger' : 'bg-light' }}">
                                                    <td style="position: relative;">
                                                        <input type="checkbox" class="form-check-input rounded">
                                                    </td>
                                                    <td>#{{ $customer->id }}</td>
                                                    <td class="text-primary">
                                                        <a href="{{ route('customer.add', $customer->id) }}"
                                                            class="text-decoration-none">
                                                            {{ $customer->name_ar }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ asset('storage/' . $customer->image) }}"
                                                            target="blank">
                                                            <img src="{{ asset('storage/' . $customer->image) }}"
                                                                width="40" height="40" class="img-circle"
                                                                alt="صورة">
                                                        </a>
                                                    </td>
                                                    <td>{{ $customer->phone }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->status == 'نشط' ? 'primary' : 'secondary' }}">
                                                            {{ $customer->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->medical_examination == 'تم الحجز' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->medical_examination == 'تم الحجز' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->finger_print_examination == 'تم تصدير الاكسيل' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->finger_print_examination == 'تم تصدير الاكسيل' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->virus_examination == 'تم اصدار ايصال المعامل' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->virus_examination == 'تم اصدار ايصال المعامل' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $customer->engaz_request == 'تم الحجز' ? 'success' : 'light text-dark' }}">
                                                            {{ $customer->engaz_request == 'تم الحجز' ? '✓' : '✗' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group dropstart">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer.add', $customer->id) }}">
                                                                        <i class="fas fa-edit text-primary me-2"></i> تعديل
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('customer.show', $customer->id) }}">
                                                                        <i class="fas fa-eye text-info me-2"></i> عرض
                                                                    </a>
                                                                </li>

                                                                @if ($customer->blackList)
                                                                    @if ($customer->blackList->block)
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('customers.unblock', $customer->id) }}">
                                                                                <i
                                                                                    class="fas fa-user-check text-success me-2"></i>
                                                                                إزالة البلوك
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('customers.block', $customer->id) }}">
                                                                                <i
                                                                                    class="fas fa-user-slash text-danger me-2"></i>
                                                                                بلوك
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                @endif

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i
                                                                            class="fas fa-clipboard-list text-warning me-2"></i>
                                                                        الكشوفات
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-globe me-2"></i> حجز
                                                                                نت</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-passport me-2"></i>
                                                                                بيانات التأشيرة</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-virus me-2"></i> كشف
                                                                                الفايرس</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-hospital me-2"></i> نتيجة
                                                                                كشف طبي</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-clinic-medical me-2"></i>
                                                                                نتيجة وبيانات المستشفى</a></li>
                                                                    </ul>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="fas fa-print text-secondary me-2"></i>
                                                                        طباعة
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-file-alt me-2"></i> ملف
                                                                                العميل</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-envelope me-2"></i> خطاب
                                                                                ترشيح</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-history me-2"></i> تاريخ
                                                                                العميل</a></li>
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('clients.print.attachments', $customer->id) }}"><i
                                                                                    class="fas fa-paperclip me-2"></i>
                                                                                مرفقات العميل</a></li>
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('clients.print.payments', $customer->id) }}"><i
                                                                                    class="fas fa-money-bill-wave me-2"></i>
                                                                                عمليات الدفع</a></li>
                                                                    </ul>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="fas fa-paperclip text-info me-2"></i>
                                                                        المرفقات
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-download me-2"></i>
                                                                                تحميل</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i
                                                                                    class="fas fa-eye me-2"></i> عرض</a>
                                                                        </li>
                                                                    </ul>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="fas fa-file-excel text-success me-2"></i>
                                                                        تصدير لإكسل
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
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

        .form-check-input {
            margin: 0 !important;
            position: absolute;
            top: 50%;
            right: 50%;
            transform: translate(50%, -50%);
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

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        .table-light {
            background-color: #f8f9fa;
        }

        .table-danger {
            background-color: #fff5f5;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
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



        // // Enable check all functionality
        // document.getElementById('checkAll').addEventListener('change', function() {
        //     const checkboxes = document.querySelectorAll('.row-checkbox');
        //     checkboxes.forEach(checkbox => {
        //         checkbox.checked = this.checked;
        //     });
        // });
    </script>
@stop
