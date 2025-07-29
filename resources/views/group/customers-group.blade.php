@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    <h1>العملاء في مجموعة : ({{ $group->title }})</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow border-0">

                    <div class="card-body">
                        <div class="row d-flex justify-content-between">
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
                                            <button data-company='@json($company)'
                                                class="dropdown-item text-primary" id="collectSelected"> طلب
                                                انجاز</button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-success" id="visa">
                                                جلب التاشيرة او طلب الدخول
                                            </button>
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

                        <hr> <!-- Divider -->
                        {{--
                        <div class="d-flex flex-wrap gap-2 mb-4">
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
                                        <th><input type="checkbox" id="checkAll" class="form-check-input cccccccc"></th>
                                        <th>كود العميل</th>
                                        <th>اسم العميل</th>
                                        <th>الصورة</th>
                                        <th>الهاتف</th>
                                        <th width="120px">الكشف الطبي</th>
                                        <th width="120px">البصمة</th>
                                        <th width="120px">كشف المعامل</th>
                                        <th width="120px">انجاز</th>
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
                                                    type="checkbox" id="myCheckbox" class="form-check-input row-checkbox"
                                                    name="customer_id" value="{{ $customer->id }}"
                                                    data-customer='@json($customer)'>
                                            </td>
                                            <td>#{{ $customer->id }}</td>
                                            <td><a
                                                    href="{{ route('customer.add', $customer->id) }}">{{ $customer->name_ar }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $customer->image) }}" target="blank">
                                                    <img src="{{ asset('storage/' . $customer->image) }}" width="40"
                                                        height="40" class="img-circle" alt="صورة">
                                                </a>
                                            </td>
                                            <td>{{ $customer->phone }}</td>
                                            <td
                                                class="{{ $customer->medical_examination === 'لائق' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                                {{ $customer->medical_examination ?? '-' }}
                                            </td>
                                            <td
                                                class="{{ $customer->finger_print_examination === 'تم تصدير الاكسيل' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                                {{ $customer->finger_print_examination ?? '-' }}
                                            </td>
                                            <td
                                                class="{{ $customer->virus_examination === 'موجب' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                                {{ $customer->virus_examination ?? '-' }}
                                            </td>
                                            <td
                                                class="{{ is_null($customer->e_visa_number) ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                                {{ $customer->e_visa_number ?? '-' }}
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
                                                        <li>
                                                            <a class="dropdown-item text-primary"
                                                                href="{{ route('groups.removeCustomer', [$group->id, $customer->id]) }}">
                                                                ازالة من المجموعة
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
                                                                href="{{ $customer->blackList->block ? route('customers.unblock', $customer->id) : route('customers.block', $customer->id) }}">
                                                                <i class="fas fa-users me-1"></i>
                                                                {{ $customer->blackList->block ? 'إزالة البلوك' : 'بلوك' }}
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
                                                                        target="_blank"><i class="fas fa-passport me-1"></i>
                                                                        طباعة طلب
                                                                        دخول</a></li>
                                                                @if ($customer->token_medical)
                                                                    <li>
                                                                        <a href="#" id="checkMedicalStatus"
                                                                            data-customer='{{ json_encode($customer) }}'
                                                                            class="dropdown-item">
                                                                            <i class="fas fa-hospital me-1"></i>

                                                                            تحقق من الحالة الطبية
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                {{-- @if ($customer->token_medical)
                                                                    <li>
                                                                        <a href="{{ route('check.medical.status', $customer->token_medical) }}"
                                                                            class="dropdown-item show-loading">
                                                                            <i class="fas fa-hospital me-1"></i>

                                                                            تحقق من الحالة الطبية
                                                                        </a>
                                                                    </li>
                                                                @endif --}}
                                                                <li>
                                                                    <a href="#" class="dropdown-item"
                                                                        id="check-medical"
                                                                        data-customer='@json($customer)'>
                                                                        <i class="fas fa-hospital me-1"></i>
                                                                        حجز الكشف الطبي
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>

                                                        @if (is_null($customer->archived_at))
                                                            {{-- العميل غير مؤرشف => أظهر زر الأرشفة --}}
                                                            <li>
                                                                <form
                                                                    action="{{ route('customers.archive', $customer->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item">
                                                                        أرشفة
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @else
                                                            {{-- العميل مؤرشف => أظهر زر الاسترجاع --}}
                                                            <li>
                                                                <form
                                                                    action="{{ route('customers.unarchive', $customer->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item">
                                                                        استرجاع
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
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

        // ###################################################################### ارسال رسالة نصية
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
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "حدث خطأ أثناء ارسال الرسالة",
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
        });
        // ###################################################################### الكشف عن التأشيرة أو طلب الدخول
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

        // ###################################################################### طلب انجاز
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
                // تحديد عدد الدخول ومدة الإقامة بناءً على نوع التأشيرة
                let NumberEntryDay;
                let ResidencyInKSA;

                if (customer?.customer_group && customer.customer_group?.visa_type) {
                    const visaPeriod = customer.customer_group.visa_type.visa_peroid?.trim();

                    if (visaPeriod === "تأشيرة العمل المؤقت لخدمات الحج والعمرة") {
                        NumberEntryDay = "90";
                        ResidencyInKSA = "120";
                    } else if (visaPeriod === "عمل") {
                        NumberEntryDay = "90";
                        ResidencyInKSA = "90";
                    } else if (visaPeriod === "عمل مؤقت") {
                        NumberEntryDay = "365";
                        ResidencyInKSA = "90";
                    } else {
                        NumberEntryDay = "90";
                        ResidencyInKSA = "120";
                    }
                } else {
                    console.warn("بيانات التأشيرة غير متوفرة داخل customer.customer_group.visa_type");
                    Swal.fire({
                        icon: "error",
                        title: "خطأ في البيانات",
                        text: "لا توجد معلومات تأشيرة كافية للعميل المحدد"
                    });
                    return;
                }

                const data = {
                    UserName: companyData.engaz_email,
                    Password: companyData.engaz_password,
                    VisaKind: customer.customer_group.visa_type.visa_peroid,
                    DocumentNumber: customer.customer_group?.visa_type?.outgoing_number,
                    NATIONALITY: "EGY",
                    ResidenceCountry: "272",
                    EmbassyCode: customer.customer_group?.visa_type?.embassy?.title,
                    NumberOfEntries: "0",
                    NumberEntryDay: NumberEntryDay,
                    ResidencyInKSA: ResidencyInKSA,
                    imageUrl: `{{ asset('storage') }}/${customer.image}`,
                    AFIRSTNAME: customer.name_ar,
                    AFATHER: name_ar[1] || "",
                    AGRAND: name_ar[2] || "",
                    AFAMILY: name_ar[name_ar.length - 1] || "",
                    EFIRSTNAME: name_en[0] || "",
                    EFATHER: name_en[1] || "",
                    EGRAND: name_en[2] || "",
                    EFAMILY: name_en[name_en.length - 1] || "",
                    PASSPORTnumber: customer.passport_id,
                    PASSPORType: "1",
                    PASSPORT_ISSUE_PLACE: "مصر",
                    PASSPORT_ISSUE_DATE: customer.passport_issuance_date,
                    PASSPORT_EXPIRY_DATE: customer.passport_expire_date,
                    BIRTH_PLACE: customer.governorate_live,
                    BIRTH_DATE: customer.date_birth,
                    PersonId: customer.card_id,
                    DEGREE: "-",
                    DEGREE_SOURCE: "-",
                    ADDRESS_HOME: "بحره",
                    Personal_Email: "moha@gmail.com",
                    SPONSER_NAME: customer.customer_group?.visa_type?.sponser?.name,
                    SPONSER_NUMBER: customer.customer_group?.visa_type?.sponser?.id_number,
                    SPONSER_ADDRESS: customer.customer_group?.visa_type?.sponser.address,
                    SPONSER_PHONE: customer.customer_group?.visa_type?.sponser?.phone,
                    COMING_THROUGH: "2",
                    ENTRY_POINT: "1",
                    ExpectedEntryDate: new Date(new Date().setMonth(new Date().getMonth() + 2))
                        .toLocaleDateString('en-GB'),
                    porpose: customer.customer_group?.visa_type?.porpose,
                    car_number: "SV123",
                    RELIGION: "1",
                    SOCIAL_STATUS: "2",
                    Sex: "1",
                    JOB_OR_RELATION_Id: customer.customer_group?.visa_profession?.job
                };
                const requiredFields = {
                    UserName: "اسم المستخدم",
                    Password: "كلمة المرور",
                    VisaKind: "نوع التأشيرة",
                    DocumentNumber: "رقم المستند",
                    EmbassyCode: "السفارة",
                    imageUrl: "الصورة الشخصية",
                    AFIRSTNAME: "الاسم الأول بالعربية",
                    AFAMILY: "اسم العائلة بالعربية",
                    EFIRSTNAME: "الاسم الأول بالإنجليزية",
                    EFAMILY: "اسم العائلة بالإنجليزية",
                    PASSPORTnumber: "رقم الجواز",
                    PASSPORT_EXPIRY_DATE: "تاريخ انتهاء الجواز",
                    BIRTH_DATE: "تاريخ الميلاد",
                    PersonId: "رقم الهوية",
                    SPONSER_NAME: "اسم الكفيل",
                    SPONSER_NUMBER: "رقم هوية الكفيل",
                    SPONSER_ADDRESS: "عنوان الكفيل",
                    SPONSER_PHONE: "هاتف الكفيل",
                    ExpectedEntryDate: "تاريخ الدخول المتوقع",
                    porpose: "الغرض من التأشيرة",
                    JOB_OR_RELATION_Id: "المهنة"
                };

                // تحقق من النواقص
                const missingFields = [];

                for (const field in requiredFields) {
                    if (
                        data[field] === null ||
                        data[field] === undefined ||
                        data[field] === ''
                    ) {
                        missingFields.push(requiredFields[field]);
                    }
                }

                console.log(missingFields);
                // لو في نواقص، أوقف العملية وأظهرها
                if (missingFields.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'يرجى استكمال البيانات',
                        html: `<ul style="text-align:right; direction:rtl;">` +
                            missingFields.map(f => `<li>${f}</li>`).join('') +
                            `</ul>`,
                        confirmButtonText: 'حسناً'
                    });

                    return; // أوقف الاستمرار في المعالجة
                }

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

        // ###################################################################### الكشف الطبي
        document.getElementById('check-medical').addEventListener('click', async function() {
            const btn = document.getElementById('collectSelected');
            const companyData = JSON.parse(btn.getAttribute('data-company'));

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
            console.log();

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
                $('#loading-overlay').fadeOut();
                if (result.success) {
                    $('#loading-overlay').fadeOut();
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحجز',
                        text: 'تم إرسال البيانات بنجاح.',
                    });
                } else {
                    $('#loading-overlay').fadeOut();
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء الاتصال بالخادم.',
                    });
                }

            } catch (error) {
                console.error('Fetch error:', error);
                $('#loading-overlay').fadeOut();

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
                if (!fullName) return '';
                const parts = fullName.trim().split(/\s+/); // يفصل على أساس المسافات
                return parts[parts.length - 1]; // يأخذ آخر كلمة
            }
        });

        // ###################################################################### الكشف الطبي
        document.getElementById('checkMedicalStatus').addEventListener('click', async function() {
            const customer = JSON.parse(this.getAttribute('data-customer'));

            const token = customer.token_medical;
            const email = "{{ auth()->user()->email }}"; // أو ضعها من `data-email` إذا لم تكن في blade

            if (!token || !email) {
                Swal.fire({
                    icon: 'error',
                    title: 'بيانات ناقصة',
                    text: 'لا يمكن فتح الرابط بدون التوكن أو الإيميل.',
                });
                return;
            }

            const url = `http://localhost:3000/check-medical/${token}/${email}`;
            Swal.fire({
                title: 'جارٍ التحقق...',
                text: 'يرجى الانتظار قليلاً',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });

            try {
                const response = await fetch(url);
                const result = await response.json();

                Swal.close();
                console.log(response);

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحقق',
                        html: `
                    <b>الحالة الطبية:</b> ${result.status}<br>
                    <b>اسم المستشفى:</b> ${result.hospitalName}<br>
                    <b>العنوان:</b> ${result.address}
                `
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'فشل التحقق',
                        text: 'حدث خطأ في البيانات أو الرابط.',
                    });
                }

            } catch (error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ في الاتصال',
                    text: error.message || 'فشل الاتصال بالسيرفر.',
                });
            }
        });
    </script>
@stop
