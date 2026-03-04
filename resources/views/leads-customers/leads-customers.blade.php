@extends('adminlte::page')

@section('title', ' العملاء المحتملون')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> العملاء المحتملون</h1>
@stop

@section('content')
    <!-- نموذج إضافة عميل محتمل -->

    <div class="card card-outline card-primary shadow">
        <div class="card-header bg-light d-flex align-items-center">
            <h3 class="card-title font-weight-bold text-primary mb-0">
                <i class="fas fa-user-plus ml-2"></i> إضافة عميل جديد
            </h3>
        </div>

        @if ($errors->any())
            <script>
                let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;
                Swal.fire({
                    icon: 'error',
                    title: 'حدثت أخطاء في الإدخال:',
                    html: errorMessages,
                    confirmButtonText: 'حسناً'
                });
            </script>
        @endif

        <form action="{{ route('leads-customers.create') }}" id="add" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body bg-custom-canvas">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-info card-outline shadow-sm border-0">
                            <div class="card-header">
                                <h5 class="card-title text-sm font-weight-bold">البيانات الأساسية</h5>
                            </div>
                            <div class="card-body row">

                                <div class="col-md-12 mb-4">
                                    <div
                                        class="p-3 rounded border bg-light d-flex align-items-center flex-wrap flex-md-nowrap">
                                        <div id="preview_image"
                                            class="border rounded bg-white shadow-sm d-flex align-items-center justify-content-center mr-md-3 mb-2 mb-md-0"
                                            style="width: 120px; height: 120px; overflow: hidden; flex-shrink: 0;">
                                            <img src="https://via.placeholder.com/100x100?text=Profile" class="img-fluid"
                                                style="display: none;" alt="Preview">
                                            <i class="fas fa-user fa-3x text-muted placeholder-icon"></i>
                                        </div>
                                        <div class="flex-grow-1 mr-3 text-right">
                                            <label class="font-weight-bold">الصورة الشخصية <span
                                                    class="text-danger">*</span></label>
                                            <div class="custom-file mb-2">
                                                <input type="file" name="image"
                                                    class="custom-file-input preview-image-input"
                                                    data-preview="#preview_image" id="dd" required>
                                                <label class="custom-file-label">اختر الملف...</label>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm crop-image-btn"
                                                data-input="#dd" data-preview="#preview_image">
                                                <i class="fas fa-crop-alt"></i> اقتصاص وتأكيد
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">اسم العميل بالكامل</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text bg-white"><i
                                                    class="fas fa-user"></i></span></div>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="أدخل اسم العميل كما في البطاقة" required
                                            value="{{ old('name') }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm">الوظيفة المقدم عليها</label>
                                    <select name="job_title_id" class="form-control custom-select" required>
                                        <option value="">اختر الوظيفة...</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ old('job_title_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm">المندوب المسئول</label>
                                    <select name="delegate_id" class="form-control custom-select" required>
                                        <option value="">اختر المندوب...</option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{ $delegate->id }}"
                                                {{ old('delegate_id') == $delegate->id ? 'selected' : '' }}>
                                                {{ $delegate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-sm">السن</label>
                                    <input type="number" name="age" id="age" class="form-control" required
                                        placeholder="00" value="{{ old('age') }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-sm text-success">رقم الهاتف (أساسي)</label>
                                    <input type="text" name="phone" id="phone" class="form-control border-success"
                                        required placeholder="01xxxxxxxxx" value="{{ old('phone') }}" pattern="\d{11}">
                                    <div id="phone-error" class="text-danger small"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-sm">رقم هاتف إضافي</label>
                                    <input type="text" name="phone_two" class="form-control" placeholder="اختياري"
                                        value="{{ old('phone_two') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm">الرقم القومي (14 رقم)</label>
                                    <input type="text" name="card_id" id="card_id"
                                        class="form-control font-weight-bold" required placeholder="290xxxxxxxxxxx"
                                        value="{{ old('card_id') }}" maxlength="14"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <div id="card-error" class="text-danger small"></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm">رقم الجواز</label>
                                    <input type="text" name="passport_numder" id="passport_numder"
                                        class="form-control font-weight-bold text-uppercase" required
                                        placeholder="A00000000" value="{{ old('passport_numder') }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm text-primary">نوع المعاملة المالية (المسمى
                                        المالي)</label>
                                    <select name="payment_title_id"
                                        class="form-control custom-select border-info shadow-sm">
                                        <option value="">اختر نوع المعاملة...</option>

                                        @foreach ($paymentTitles as $title)
                                            <option value="{{ $title->id }}"
                                                {{ old('payment_title_id') == $title->id || (isset($edit) && $edit->payment_title_id == $title->id) ? 'selected' : '' }}>
                                                {{ $title->title }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('payment_title_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm">المحافظة</label>
                                    <select name="governorate" id="governorate" class="form-control custom-select"
                                        required>
                                        <option value="">اختر المحافظة...</option>
                                        @foreach ($governorates as $gov)
                                            <option value="{{ $gov }}"
                                                {{ old('governorate') == $gov ? 'selected' : '' }}>{{ $gov }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm">تاريخ الميلاد</label>
                                    <input id="date_of_birth" type="date" name="date_of_birth" class="form-control"
                                        required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-sm text-muted">موعد التسجيل</label>
                                    <input type="date" name="registration_date" class="form-control bg-light"
                                        value="{{ date('Y-m-d') }}" required readonly>
                                </div>

                                <div class="col-md-12 mt-3" id="job-questions-container">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h5 class="font-weight-bold text-secondary text-sm mb-3">الوثائق والمستندات</h5>

                        @php
                            $images = [
                                [
                                    'name' => 'passport_photo',
                                    'label' => 'جواز السفر',
                                    'id' => 'passportInput',
                                    'icon' => 'fa-passport',
                                ],
                                [
                                    'name' => 'img_national_id_card',
                                    'label' => 'البطاقة (أمام)',
                                    'id' => 'ss',
                                    'icon' => 'fa-id-card',
                                ],
                                [
                                    'name' => 'img_national_id_card_back',
                                    'label' => 'البطاقة (خلف)',
                                    'id' => 'aa',
                                    'icon' => 'fa-id-card',
                                ],
                                [
                                    'name' => 'license_photo',
                                    'label' => 'إثبات المهنة',
                                    'id' => 'ff',
                                    'icon' => 'fa-certificate',
                                ],
                            ];
                        @endphp

                        @foreach ($images as $img)
                            <div class="card card-light mb-3 border shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="mb-0 font-weight-bold text-sm"><i
                                                class="fas {{ $img['icon'] }} ml-1"></i> {{ $img['label'] }}</label>
                                        @if ($img['name'] == 'passport_photo')
                                            <span class="badge badge-success-soft" id="analyzeBtn"
                                                style="cursor: pointer;">
                                                <i class="fas fa-magic"></i> فك البيانات
                                            </span>
                                        @endif
                                    </div>

                                    <div class="custom-file mb-2">
                                        <input type="file" name="{{ $img['name'] }}"
                                            class="custom-file-input preview-image-input"
                                            data-preview="#preview_{{ $img['name'] }}" id="{{ $img['id'] }}"
                                            required>
                                        <label class="custom-file-label">اختر الملف...</label>
                                    </div>

                                    <div id="preview_{{ $img['name'] }}"
                                        class="border rounded p-1 text-center bg-white shadow-inner"
                                        style="height: 100px; position: relative; overflow: hidden;">
                                        <img src="https://via.placeholder.com/150x100?text=Scan"
                                            class="h-100 img-thumbnail border-0" style="display: none;" alt="Preview">
                                        <div class="mt-4 text-muted small no-img-placeholder"><i
                                                class="fas fa-camera fa-2x"></i></div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <button type="button" class="btn btn-xs btn-primary crop-image-btn"
                                            data-input="#{{ $img['id'] }}"
                                            data-preview="#preview_{{ $img['name'] }}">
                                            اقتصاص
                                        </button>

                                        @if ($img['name'] == 'passport_photo')
                                            <div class="d-flex align-items-center">
                                                <div id="{{ $img['id'] }}_loader"
                                                    class="spinner-border spinner-border-sm text-primary mr-2"
                                                    role="status" style="display: none;"></div>
                                                <span id="{{ $img['id'] }}_loader_text" class="text-xs text-primary"
                                                    style="display: none;">جاري التحليل...</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white border-top py-3">
                <div class="container text-center">
                    <button type="submit" id="submitBtn" class="btn btn-success btn-lg shadow px-5">
                        <i class="fas fa-save ml-1"></i> حفظ بيانات العميل (F2)
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        /* تحسينات التصميم ودعم الوضع الليلي */
        .bg-custom-canvas {
            background-color: #f4f6f9;
        }

        .dark-mode .bg-custom-canvas {
            background-color: #343a40;
        }

        .card-outline.card-primary {
            border-top: 3px solid #007bff;
        }

        .shadow-inner {
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
        }

        .custom-file-label::after {
            content: "تصفح";
        }

        /* مظهر الأزرار والـ Badges */
        .badge-success-soft {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 11px;
            transition: 0.3s;
        }

        .badge-success-soft:hover {
            background-color: #28a745;
            color: white;
        }

        .dark-mode .card-light {
            background-color: #3f474e !important;
            color: white;
            border: 1px solid #4b545c !important;
        }

        .dark-mode .bg-white {
            background-color: #343a40 !important;
            color: white;
        }

        .dark-mode .input-group-text {
            background-color: #4b545c !important;
            color: #fff;
            border: 1px solid #6c757d;
        }

        .dark-mode .form-control {
            background-color: #3f474e;
            color: #fff;
            border: 1px solid #6c757d;
        }

        .dark-mode .form-control:focus {
            background-color: #454d55;
            color: #fff;
        }

        /* تأثيرات الصور */
        .img-thumbnail {
            border-radius: 8px;
            max-height: 100%;
            object-fit: contain;
        }

        .placeholder-icon {
            opacity: 0.3;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>


    <!-- جدول عرض العملاء المحتملين -->
    @if (auth()->user()?->permissions->contains('permission', 'show-leads') || auth()->user()?->role == 'admin')
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center py-3">
                <h3 class="card-title text-white mb-0 fs-5">
                    <i class="fas fa-users-cog me-2"></i> إدارة العملاء المحتملين
                </h3>
            </div>

            <div class="card-body bg-light border-bottom">
                <div class="row g-3 align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        <form method="GET" id="leadForm" action="{{ route('leads-customers.search') }}">
                            @csrf
                            <div class="input-group">
                                <select class="form-select border-primary" style="max-width: 130px;" id="searchBy"
                                    name="searchBy">
                                    <option value="id" {{ request('searchBy') == 'id' ? 'selected' : '' }}>الكود
                                    </option>
                                    <option value="name" {{ request('searchBy') == 'name' ? 'selected' : '' }}>الاسم
                                    </option>
                                    <option value="card_id" {{ request('searchBy') == 'card_id' ? 'selected' : '' }}>الرقم
                                        القومي</option>
                                    <option value="age" {{ request('searchBy') == 'age' ? 'selected' : '' }}>السن
                                    </option>
                                    <option value="phone" {{ request('searchBy') == 'phone' ? 'selected' : '' }}>الهاتف
                                    </option>
                                    <option value="governorate"
                                        {{ request('searchBy') == 'governorate' ? 'selected' : '' }}>المحافظة</option>
                                    <option value="status" {{ request('searchBy') == 'status' ? 'selected' : '' }}>الحالة
                                    </option>
                                    <option value="delegate_name"
                                        {{ request('searchBy') == 'delegate_name' ? 'selected' : '' }}>المندوب</option>
                                    <option value="registration_date"
                                        {{ request('searchBy') == 'registration_date' ? 'selected' : '' }}>تاريخ التسجيل
                                    </option>
                                </select>
                                <input type="text" class="form-control border-primary" id="searchInput"
                                    name="searchInput" value="{{ request('searchInput') }}" placeholder="اكتب للبحث...">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-7 col-lg-6 d-flex justify-content-lg-end gap-2 flex-wrap">
                        <div
                            class="badge bg-white text-primary border border-primary d-flex align-items-center px-3 shadow-sm">
                            <span class="text-dark">المحددين:</span>
                            <strong id="selected-count" class="ms-2 fs-6">0</strong>
                        </div>

                        <a href="{{ route('jop.filter') }}" class="btn btn-outline-success shadow-sm">
                            <i class="fas fa-filter"></i> فلتر متقدم
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle shadow-sm" type="button"
                                id="operationsDropdown" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-bolt me-1"></i> العمليات
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow border-0"
                                aria-labelledby="operationsDropdown">
                                <button class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#groupModal">
                                    <i class="fas fa-vial text-success me-2"></i> تعيين اختبار
                                </button>
                                <button class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#testModal">
                                    <i class="fas fa-layer-group text-primary me-2"></i> تعيين مجموعة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table id="example" class="table table-hover text-center align-middle mb-0">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th class="py-3">رقم</th>
                            <th style="position: relative"><input type="checkbox" style="left: 50%;top: 50%;"
                                    class="form-check-input" id="select-all"></th>
                            <th>كود</th>
                            <th>الاسم</th>
                            <th>صورة</th>
                            <th>السن</th>
                            <th>الهاتف</th>
                            <th>المحافظة</th>
                            <th>الحالة</th>
                            <th>المندوب</th>
                            <th>الاختبارات</th>
                            <th>الوظيفة</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leads as $lead)
                            <tr class="{{ $lead->evaluation == 'جارى المعالجة' ? 'bg-warning-light' : '' }}">
                                <td>{{ $leads->firstItem() + $loop->index }}</td>
                                <td>
                                    <input type="checkbox" class="lead-checkbox form-check-input" name="lead_ids[]"
                                        value="{{ $lead->id }}">
                                </td>
                                <td class="fw-bold">#{{ $lead->id }}</td>
                                <td>
                                    <a href="{{ route('leads-customers.show', $lead->id) }}"
                                        class="text-decoration-none fw-bold text-primary">
                                        {{ $lead->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $lead->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $lead->image) }}" width="45" height="45"
                                            class="rounded-circle border shadow-sm" alt="صورة العميل" loading="lazy">
                                    </a>
                                </td>
                                <td>{{ $lead->age }}</td>
                                <td class="text-nowrap">{{ $lead->phone }}</td>
                                <td>{{ $lead->governorate }}</td>
                                <td data-status="{{ $lead->status }}" class="lead-status">
                                    <span
                                        class="badge {{ $lead->status == 'عميل محتمل' ? 'bg-secondary' : 'bg-success' }} px-3 py-2">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td><span class="text-muted">{{ $lead->delegate->name ?? '-' }}</span></td>
                                <td>
                                    @if ($lead->tests->count())
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-info dropdown-toggle px-3"
                                                type="button" data-toggle="dropdown">
                                                {{ $lead->tests->count() }}
                                            </button>
                                            <div class="dropdown-menu shadow border-0">
                                                @foreach ($lead->tests as $test)
                                                    <a class="dropdown-item small"
                                                        href="{{ route('test.leads', $test->id) }}">
                                                        <i class="fas fa-file-alt me-1 text-muted"></i>
                                                        {{ $test->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $lead->jobTitle->title }}</span></td>
                                <td class="small">{{ $lead->registration_date }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('leads-customers.update', $lead->id) }}"
                                            class="btn btn-sm btn-primary shadow-sm" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('leads-customer.cv', $lead->id) }}"
                                            class="btn btn-sm btn-info text-white shadow-sm" title="السيرة الذاتية">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        @if (auth()->user()->role == 'admin')
                                            <form action="{{ route('leads-customers.delete', $lead->id) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger shadow-sm" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="py-5 text-muted">لا توجد بيانات متاحة حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white">
                <div class="d-flex justify-content-center mt-2">
                    {{ $leads->links() }}
                </div>
            </div>
        </div>
    @endif
    <style>
        /* لون الصفوف التي تحت المعالجة */
        .bg-warning-light {
            background-color: #fff3cd !important;
            /* لون أصفر فاتح مريح للعين */
        }

        /* إذا كنت تستخدم DataTables، هذا يمنع تداخل لون odd/even */
        table.dataTable tbody tr.bg-warning-light {
            background-color: #fff3cd !important;
            color: #000 !important;
        }

        /* --- الوضع الفاتح (Light Mode) الحالي --- */
        .bg-warning-light {
            background-color: #fff3cd !important;
            color: #000000 !important;
            /* نص بني غامق يتناسب مع الأصفر */
        }

        /* --- الوضع الداكن (Dark Mode) أحمر خفيف --- */
        /* إذا كان موقعك يستخدم كلاس .dark-mode في الـ body */
        .dark-mode .bg-warning-light {
            background-color: #442727 !important;
            /* أحمر داكن مكتوم */
            color: #000000 !important;
            /* نص أحمر فاتح جداً للوضوح */
            border-right: 4px solid #dc3545 !important;
            /* تمييز جانبي أحمر */
        }

        /* أو باستخدام خاصية النظام التلقائية */
        @media (prefers-color-scheme: dark) {
            .bg-warning-light {
                background-color: #442727 !important;
                color: white !important;
            }
        }

        /* لضمان التوافق مع DataTables في الدارك مود */
        .dark-mode table.dataTable tbody tr.bg-warning-light,
        .dark-mode table.dataTable tbody tr.bg-warning-light.odd,
        .dark-mode table.dataTable tbody tr.bg-warning-light.even {
            background-color: #442727 !important;
        }
    </style>
    <div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="fas fa-vial me-2 fs-4"></i> تعيين اختبار للعملاء المحددين
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>

                <form id="assignGroupForm" action="{{ route('tests.addCustomer') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" name="leads" id="selectedLeadsInput">

                        <div class="alert alert-info border-0 shadow-sm mb-4 small">
                            <i class="fas fa-info-circle me-1"></i> سيتم تطبيق هذا الاختبار على جميع العملاء الذين قمت
                            بتحديدهم من الجدول.
                        </div>

                        <div class="form-group">
                            <label for="groupSelect" class="form-label fw-bold mb-2">اختر الاختبار المستهدف</label>
                            <select class="form-select form-select-lg border-2 shadow-sm" id="groupSelect" name="test_id"
                                required>
                                <option value="" disabled selected>-- قائمة الاختبارات المتاحة --</option>
                                @foreach ($tests as $test)
                                    <option value="{{ $test->id }}">📌 {{ $test->id }}: {{ $test->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 rounded-bottom-4 py-3">
                        <button type="button" class="btn btn-outline-secondary px-4 shadow-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> إلغاء
                        </button>
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> حفظ وتعيين
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4 py-3">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="fas fa-layer-group me-2 fs-4"></i> نقل العملاء إلى مجموعة
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>

                <form id="assignTestForm" action="{{ route('customer.leadToCustomer') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" name="leads" id="selectedLeadsInputGroup">

                        <div class="form-group">
                            <label for="testSelect" class="form-label fw-bold mb-2 text-primary">المجموعة
                                المستهدفة</label>
                            <select class="form-select form-select-lg border-2 shadow-sm" id="testSelect" name="group_id"
                                required>
                                <option value="" disabled selected>-- اختر المجموعة --</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">📁 {{ $group->id }}: {{ $group->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-0 rounded-bottom-4 py-3">
                        <button type="button" class="btn btn-outline-secondary px-4 shadow-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> تراجع
                        </button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> تأكيد النقل
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="loading-overlay"
        style="display: none; position: fixed; z-index: 9999; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
            <div class="spinner-grow text-primary" role="status" style="width: 4rem; height: 4rem;"></div>
            <h5 class="text-white mt-3 fw-light">جارٍ تنفيذ العملية، يرجى الانتظار...</h5>
        </div>
    </div>

    <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg bg-dark rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-dark text-white py-3">
                    <h5 class="modal-title"><i class="fas fa-crop-alt me-2 text-warning"></i> تحرير واقتصاص الصورة</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>

                <div class="modal-body p-0"
                    style="height: 65vh; background-image: radial-gradient(#333 10%, transparent 10%); background-size: 20px 20px;">
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                        <img id="cropperImage" style="max-width:100%; max-height:100%; display:block;">
                    </div>
                </div>

                <div class="modal-footer border-0 bg-dark d-flex justify-content-between py-3">
                    <div class="btn-group shadow-sm">
                        <button type="button" class="btn btn-outline-light px-3" id="zoomIn" title="تكبير"><i
                                class="fas fa-search-plus"></i></button>
                        <button type="button" class="btn btn-outline-light px-3" id="zoomOut" title="تصغير"><i
                                class="fas fa-search-minus"></i></button>
                        <button type="button" class="btn btn-outline-light px-3" id="rotateLeft" title="تدوير"><i
                                class="fas fa-sync-alt"></i></button>
                        <button type="button" class="btn btn-outline-light px-3" id="reset" title="إعادة ضبط"><i
                                class="fas fa-undo"></i></button>
                    </div>
                    <button type="button" id="cropConfirm" class="btn btn-success btn-lg px-5 shadow">
                        <i class="fas fa-crop me-1"></i> تطبيق الاقتصاص
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">
    <style>
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

        .ccccc::after {
            display: none;
        }

        .dropdown-item {
            max-width: 250px;
            /* العرض الأقصى */
            white-space: nowrap;
            /* يمنع نزول النص لسطر جديد */
            overflow: hidden;
            /* يخفي الجزء الزائد */
            text-overflow: ellipsis;
            /* يضيف ... عند الزيادة */
        }

        /* Warning Row Styling - Light Mode */
        .table tbody tr.bg-warning {
            background: linear-gradient(135deg, #f2db89 0%, #f0ca30 100%) !important;
            color: #b7950b !important;
            border-left: 4px solid #f39c12;
            box-shadow: 0 2px 4px rgba(243, 156, 18, 0.1);
        }

        .table tbody tr.bg-warning td {
            color: #000000 !important;
        }

        .table tbody tr.bg-warning:hover {
            background: linear-gradient(135deg, #f3d56a 0%, #eeca37 100%) !important;
            box-shadow: 0 4px 8px rgba(243, 156, 18, 0.15);
        }

        /* Warning Row Styling - Dark Mode */
        body.dark-mode .table tbody tr.bg-warning {
            background: linear-gradient(135deg, #3e2723 0%, #4e342e 100%) !important;
            color: #ffb74d !important;
            border-left: 4px solid #ff9800;
            box-shadow: 0 2px 4px rgba(255, 152, 0, 0.2);
        }

        body.dark-mode .table tbody tr.bg-warning td {
            color: #ffb74d !important;
        }

        body.dark-mode .table tbody tr.bg-warning:hover {
            background: linear-gradient(135deg, #4e342e 0%, #5d4037 100%) !important;
            box-shadow: 0 4px 8px rgba(255, 152, 0, 0.25);
        }

        /* تأثير عند السحب */
        #preview_passport_photo.border-primary,
        [id^="preview_"].border-primary {
            border: 2px dashed #007bff !important;
            background: #f0f8ff;
            transition: 0.2s;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Bootstrap (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CropperJS -->
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F2') {
                event.preventDefault(); // منع السلوك الافتراضي لـ F2
                document.getElementById('submitBtn').click(); // الضغط على زر الإضافة
            }
        });
        ['assignGroupForm', 'leadForm', "delete", "add"].forEach(function(formId) {
            var form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function() {
                    document.getElementById('loading-overlay').style.display = 'block';
                });
            }
        });
        // تحديث العداد
        function updateSelectedCount() {
            let count = document.querySelectorAll('.lead-checkbox:checked').length;
            document.getElementById('selected-count').textContent = count;
        }

        // تحديد الكل
        document.getElementById('select-all').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.lead-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelectedCount(); // تحديث العداد بعد التحديد الكلي
        });

        // عند تغيير أي checkbox فرعي
        document.querySelectorAll('.lead-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedCount);
        });
        $('#example').DataTable({
            paging: false, // إلغاء ترقيم الصفحات
            searching: false, // إلغاء البحث
            info: false, // إلغاء النص "إظهار من كذا إلى كذا"
            ordering: false, // إلغاء الترتيب
            lengthChange: false, // إلغاء قائمة تغيير عدد الصفوف
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.preview-image-input').forEach(function(input) {
                input.addEventListener('change', function(e) {
                    const previewId = e.target.getAttribute('data-preview');
                    const previewBox = document.querySelector(previewId);
                    const file = e.target.files[0];

                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            previewBox.innerHTML =
                                `<img src="${evt.target.result}" class="img-thumbnail" style="max-width: 100px;" alt="Preview">`;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewBox.innerHTML =
                            `<img src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail" style="display:block; max-width: 100px;" alt="Preview">`;
                    }
                });
            });
        });
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

        document.getElementById("analyzeBtn").addEventListener("click", async () => {
            document.getElementById("passportInput_loader").style.display = "block";
            document.getElementById("passportInput_loader_text").style.display = "block";
            const fileInput = document.getElementById("passportInput");
            const file = fileInput.files[0];
            const resultBox = document.getElementById("resultBox");

            if (!file) {
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
                const base64Image = await fileToBase64(file);
                const model = genAI.getGenerativeModel({
                    model: "gemini-2.0-flash",
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
                                    mimeType: file.type,
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



        document.getElementById('assignGroupForm').addEventListener('submit', function(e) {
            e.preventDefault(); // منع الريفريش

            // جلب كل الـ checkboxes المختارة
            const checkboxes = Array.from(document.querySelectorAll('.lead-checkbox:checked'));
            if (checkboxes.length === 0) {
                Swal.fire({
                    title: "الرجاء اختيار عميل واحد على الأقل.",
                    icon: "error",
                    draggable: true
                });
                return;
            }

            const selectedIds = [];
            let hasExistingCustomer = false;

            // فحص كل تشيك بوكس
            checkboxes.forEach(cb => {
                const leadId = parseInt(cb.value);
                const row = cb.closest('tr');

                selectedIds.push(leadId);
            });

            // تعبئة hidden input بقائمة الـ IDs
            document.getElementById('selectedLeadsInput').value = JSON.stringify(selectedIds);

            // إرسال الفورم
            this.submit();
        });


        document.getElementById('assignTestForm').addEventListener('submit', function(e) {
            e.preventDefault(); // منع الريفريش

            // جلب كل الـ checkboxes المختارة
            const checkboxes = Array.from(document.querySelectorAll('.lead-checkbox:checked'));
            if (checkboxes.length === 0) {
                Swal.fire({
                    title: "الرجاء اختيار عميل واحد على الأقل.",
                    icon: "error",
                    draggable: true
                });
                return;
            }

            const selectedIds = [];
            let hasExistingCustomer = false;

            // فحص كل تشيك بوكس
            // checkboxes.forEach(cb => {
            //     const leadId = parseInt(cb.value);
            //     const row = cb.closest('tr');

            //     selectedIds.push(leadId);
            // });

            checkboxes.forEach(cb => {
                const leadId = parseInt(cb.value);
                const row = cb.closest('tr');

                selectedIds.push(leadId);

                // 🔥 قراءة حالة العميل من الـ <td data-status="..">
                const status = row.querySelector('.lead-status').getAttribute('data-status');

                if (status === 'عميل اساسي') {
                    hasExistingCustomer = true;
                }
            });

            // 🔥 إذا يوجد عميل أساسي → منع الإرسال وإظهار Swal
            if (hasExistingCustomer) {
                Swal.fire({
                    title: "لا يمكن تعيين مجموعة لعميل أساسي!",
                    text: "يرجى الذهاب الي العملاء الاسايين والبحث عنه",
                    icon: "warning"
                });
                return;
            }

            // تعبئة hidden input بقائمة الـ IDs
            document.getElementById('selectedLeadsInputGroup').value = JSON.stringify(selectedIds);

            // إرسال الفورم
            this.submit();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const ageFilter = document.getElementById('filter-age');
            const govFilter = document.getElementById('filter-governorate');
            const statusFilter = document.getElementById('filter-status');
            const dateFilter = document.getElementById('filter-date');
            const tableRows = document.querySelectorAll('tbody tr');

            function filterTable() {
                const selectedAge = ageFilter.value;
                const selectedGov = govFilter.value.toLowerCase();
                const selectedStatus = statusFilter.value.toLowerCase();
                const selectedDate = dateFilter.value;

                tableRows.forEach(row => {
                    const age = row.cells[5]?.textContent.trim(); // السن
                    const gov = row.cells[7]?.textContent.trim().toLowerCase(); // المحافظة
                    const status = row.cells[8]?.textContent.trim().toLowerCase(); // الحالة
                    // const date = row.cells[12]?.textContent.trim(); // تاريخ التسجيل

                    const matchesAge = !selectedAge || age === selectedAge;
                    const matchesGov = !selectedGov || gov === selectedGov;
                    const matchesStatus = !selectedStatus || status === selectedStatus;
                    // const matchesDate = !selectedDate || date === selectedDate;

                    if (matchesAge && matchesGov && matchesStatus) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            ageFilter.addEventListener('change', filterTable);
            govFilter.addEventListener('change', filterTable);
            statusFilter.addEventListener('change', filterTable);
            // dateFilter.addEventListener('change', filterTable);
        });
        // سسسسسسسسسسسسسسسسسسسسسسسسسسسسسسسسسسسسسس
    </script>

    <script>
        let cropper;
        let currentInputFile = null;
        let currentPreviewId = null;
        const cropperModal = document.getElementById("cropperModal");
        const cropperImage = document.getElementById("cropperImage");

        // اختيار صورة
        document.querySelectorAll(".crop-image-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const inputSelector = this.getAttribute("data-input");
                const previewSelector = this.getAttribute("data-preview");

                currentInputFile = document.querySelector(inputSelector);
                currentPreviewId = previewSelector;

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

                    // فتح المودال
                    const modal = new bootstrap.Modal(cropperModal);
                    modal.show();
                };
                reader.readAsDataURL(currentInputFile.files[0]);
            });
        });


        // بعد ما المودال يظهر فعليًا
        cropperModal.addEventListener("shown.bs.modal", function() {
            if (cropper) cropper.destroy();

            cropper = new Cropper(cropperImage, {
                aspectRatio: NaN,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
                ready() {
                    // نخلي الصورة تملأ المساحة من أول مرة
                    const containerData = cropper.getContainerData();
                    const imageData = cropper.getImageData();

                    let scaleX = containerData.width / imageData.width;
                    let scaleY = containerData.height / imageData.height;
                    let scale = Math.min(scaleX, scaleY);

                    cropper.zoomTo(scale);
                }
            });
        });

        // زر تأكيد الاقتصاص
        document.getElementById("cropConfirm").addEventListener("click", function() {
            if (cropper && currentPreviewId && currentInputFile) {
                cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                }).toBlob(function(blob) {
                    const file = new File([blob], "cropped.jpg", {
                        type: "image/jpeg"
                    });

                    // نغير ملف input نفسه
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentInputFile.files = dataTransfer.files;

                    // نعرض الصورة في preview
                    const previewDiv = document.querySelector(currentPreviewId + " img");
                    previewDiv.src = URL.createObjectURL(file);
                    previewDiv.style.display = "block";

                    // إغلاق المودال
                    const modal = bootstrap.Modal.getInstance(cropperModal);
                    modal.hide();
                }, "image/jpeg");
            }
        });

        // أدوات التحكم
        document.getElementById("zoomIn").addEventListener("click", function() {
            if (cropper) cropper.zoom(0.1);
        });

        document.getElementById("zoomOut").addEventListener("click", function() {
            if (cropper) cropper.zoom(-0.1);
        });

        document.getElementById("rotateLeft").addEventListener("click", function() {
            if (cropper) cropper.rotate(-90);
        });

        document.getElementById("reset").addEventListener("click", function() {
            if (cropper) {
                cropper.reset();

                // نخلي الصورة تملأ تاني
                const containerData = cropper.getContainerData();
                const imageData = cropper.getImageData();

                let scaleX = containerData.width / imageData.width;
                let scaleY = containerData.height / imageData.height;
                let scale = Math.min(scaleX, scaleY);

                cropper.zoomTo(scale);
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
                    dropArea.querySelector(".placeholder-text")?.remove(); // إزالة النصوص الافتراضية لو موجودة
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // أي div للمعاينة عندك
            document.querySelectorAll("[id^='preview_']").forEach(previewDiv => {
                previewDiv.addEventListener("paste", function(e) {
                    const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                    for (let i = 0; i < items.length; i++) {
                        if (items[i].type.indexOf("image") === 0) {
                            const file = items[i].getAsFile();
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                // عرض الصورة في الـ preview
                                let img = previewDiv.querySelector("img");
                                img.src = event.target.result;
                                img.style.display = "block";
                            };
                            reader.readAsDataURL(file);

                            // لو عايز تبعتها مع الفورم
                            let input = document.querySelector(
                                "input[data-preview='#" + previewDiv.id + "']"
                            );

                            // نحول الصورة لملف داخل الـ input[type=file]
                            let dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            input.files = dataTransfer.files;

                            e.preventDefault();
                            break;
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).on("blur", "#phone", function() {
            let phone = $(this).val();
            if (phone.length === 11) {
                $.post("{{ route('check.phone') }}", {
                    _token: "{{ csrf_token() }}",
                    phone: phone
                }, function(data) {
                    if (data.exists) {
                        $("#phone-error").text("⚠️ رقم الهاتف مسجل من قبل!");
                    } else {
                        $("#phone-error").text("");
                    }
                });
            }
        });

        $(document).on("blur", "#card_id", function() {
            let card_id = $(this).val();
            if (card_id.length === 14) {
                $.post("{{ route('check.card') }}", {
                    _token: "{{ csrf_token() }}",
                    card_id: card_id
                }, function(data) {
                    if (data.exists) {
                        $("#card-error").text("⚠️ الرقم القومي مسجل من قبل!");
                    } else {
                        $("#card-error").text("");
                    }
                });
            }
        });
    </script>

    <script>
        function detectDevTools() {
            const start = performance.now();
            debugger; // لو DevTools مفتوح هيتأخر هنا
            const end = performance.now();

            if (end - start > 100) { // فرق زمني كبير يعني DevTools مفتوح
                document.body.innerHTML = `
    <h1 style="color:red; text-align:center; margin-top:20%; font-size:50px;">
        🚨 تم كشف فتح أدوات المطور 🚨
    </h1>
    <h2 style="text-align:center; font-size:30px;">
        لا تحاول العبث في الكود، هذا قد يؤدي إلى حظر حسابك!
    </h2>
    @if (auth()->user())
        <h3 style="text-align:center; font-size:20px;">
        من فضلك يا {{ auth()->user()->name }} اغلق وضع المطور وقم بعمل ريفريش
    </h3>
    @endif
    `;
            }
        }

        setInterval(detectDevTools, 1000);

        document.addEventListener('DOMContentLoaded', function() {
            const jobSelect = document.querySelector('select[name="job_title_id"]');
            const questionsContainer = document.getElementById('job-questions-container');

            jobSelect.addEventListener('change', function() {
                const jobId = this.value;
                questionsContainer.innerHTML = ''; // تنظيف الحقول

                if (jobId) {
                    let url = "{{ route('job.questions', ':id') }}";
                    url = url.replace(':id', jobId);
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status && data.questions.length > 0) {
                                data.questions.forEach(q => {
                                    let field = '';

                                    switch (q.type) {
                                        case 'text':
                                            field = `
            <input type="text" 
                   name="questions[${q.id}]" 
                   class="form-control" 
                   placeholder="أدخل الإجابة"  />`;
                                            break;

                                        case 'textarea':
                                            field = `
            <textarea name="questions[${q.id}]" 
                      class="form-control" 
                      rows="3" 
                      placeholder="أدخل الإجابة" ></textarea>`;
                                            break;

                                        case 'number':
                                            field = `
            <input type="number" 
                   name="questions[${q.id}]" 
                   class="form-control" 
                   placeholder="أدخل رقم" />`;
                                            break;

                                        case 'date':
                                            field = `
            <input type="date" 
                   name="questions[${q.id}]" 
                   class="form-control" />`;
                                            break;

                                        case 'select':
                                            if (q.options) {
                                                let opts = JSON.parse(q.options)
                                                    .map(opt =>
                                                        `<option value="${opt}">${opt}</option>`
                                                    )
                                                    .join('');
                                                field = `
                <select name="questions[${q.id}]" class="form-control">
                    <option value="">-- اختر --</option>
                    ${opts}
                </select>`;
                                            }
                                            break;

                                        case 'radio':
                                            if (q.options) {
                                                let radios = JSON.parse(q.options)
                                                    .map(opt => `
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" 
                           name="questions[${q.id}]" 
                           value="${opt}">
                    <label class="form-check-label">${opt}</label>
                </div>
            `).join('');
                                                field =
                                                    `<div class="d-flex flex-wrap gap-3">${radios}</div>`;
                                            }
                                            break;

                                        case 'checkbox':
                                            if (q.options) {
                                                let checks = JSON.parse(q.options)
                                                    .map(opt => `
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" 
                           name="questions[${q.id}][]" 
                           value="${opt}">
                    <label class="form-check-label">${opt}</label>
                </div>
            `).join('');
                                                field =
                                                    `<div class="d-flex flex-wrap gap-3">${checks}</div>`;
                                            }
                                            break;

                                    }


                                    questionsContainer.innerHTML += `
                                <div class="form-group mt-2">
                                    <label>${q.question}</label>
                                    ${field}
                                </div>
                            `;
                                });
                            }
                        })
                        .catch(err => console.error(err));
                }
            });
        });
    </script>
@stop
