@extends('adminlte::page')

@section('title', ' العملاء المحتملون')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> العملاء المحتملون</h1>
@stop

@section('content')
    <!-- نموذج إضافة عميل محتمل -->

    <div class="card card-primary ">
        <div class="card-header bg-secondary">
            <h3 class="card-title">إضافة عميل جديد</h3>
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

            <div class="card-body">
                <div class="row">
                    <!-- الحقول الرئيسية -->
                    <div class="col-md-8">
                        <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm">
                            <label for="image">الصورة الشخصية</label>

                            <div class="custom-file mb-2">
                                <input type="file" name="image" class="custom-file-input preview-image-input"
                                    data-preview="#preview_image" id="dd" required>
                                <label class="custom-file-label">اختر صورة</label>
                            </div>

                            <div id="preview_image" class="border rounded p-2 text-center bg-light"
                                style="min-height: 130px;">
                                <img src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail"
                                    style="max-width: 100px; display: none;" alt="Preview">
                            </div>
                            <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn" data-input="#dd"
                                data-preview="#preview_image">
                                اقتصاص
                            </button>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>اسم العميل</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="أدخل اسم العميل" required value="{{ old('name') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>الوظيفة المقدم عليها</label>
                                <select name="job_title_id" class="form-control" required>
                                    <option value="">اختر الوظيفة</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job->id }}"
                                            {{ old('job_title_id') == $job->id ? 'selected' : '' }}>
                                            {{ $job->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>المندوب</label>
                                <select name="delegate_id" class="form-control" required>
                                    <option value="">اختر المندوب</option>
                                    @foreach ($delegates as $delegate)
                                        <option value="{{ $delegate->id }}"
                                            {{ old('delegate_id') == $delegate->id ? 'selected' : '' }}>
                                            {{ $delegate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>السن</label>
                                <input type="text" name="age" id="age" class="form-control" required
                                    placeholder="أدخل السن" value="{{ old('age') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control" required
                                    placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}" pattern="\d{11}"
                                    title="يجب أن يكون رقم الهاتف مكونًا من 11 رقمًا">
                                @if ($errors->has('phone'))
                                    <div class="text-danger">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label>رقم هاتف آخر</label>
                                <input type="text" name="phone_two" class="form-control"
                                    placeholder="أدخل رقم الهاتف الآخر" value="{{ old('phone_two') }}">
                                @if ($errors->has('phone_two'))
                                    <div class="text-danger">
                                        {{ $errors->first('phone_two') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label>الرقم القومي</label>
                                <input type="text" name="card_id" id="card_id" class="form-control" required
                                    placeholder="أدخل الرقم القومي" value="{{ old('card_id') }}" pattern="\d{14}"
                                    maxlength="14" title="يجب أن يكون الرقم القومي مكونًا من 14 رقمًا"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @if ($errors->has('card_id'))
                                    <div class="text-danger">
                                        {{ $errors->first('card_id') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>رقم الجواز</label>
                                <input type="text" name="passport_numder" id="passport_numder" class="form-control"
                                    required placeholder="ادخل رقم الجواز" value="{{ old('passport_numder') }}">
                                @if ($errors->has('passport_numder'))
                                    <div class="text-danger">
                                        {{ $errors->first('passport_numder') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label>نوع الاختبار</label>
                                <select name="test_type" class="form-control" required>
                                    <option value="">اختر النوع</option>
                                    <option value="اول اختبار" {{ old('test_type') == 'اول اختبار' ? 'selected' : '' }}>اول
                                        اختبار</option>
                                    <option value="اعادة اختبار"
                                        {{ old('test_type') == 'اعادة اختبار' ? 'selected' : '' }}>اعادة اختبار</option>
                                    <option value="قيادة امنة" {{ old('test_type') == 'قيادة امنة' ? 'selected' : '' }}>
                                        قيادة امنة</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>المحافظة</label>
                                <select name="governorate" id="governorate" class="form-control" required>
                                    <option value="">اختر المحافظة</option>
                                    @foreach ($governorates as $gov)
                                        <option value="{{ $gov }}"
                                            {{ old('governorate') == $gov ? 'selected' : '' }}>{{ $gov }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>موعد التسجيل</label>
                                <input type="date" name="registration_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>تاريخ الميلاد</label>
                                <input id="date_of_birth" type="date" name="date_of_birth" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- صور -->
                    <div class="col-md-4">
                        @php
                            $images = [
                                ['name' => 'passport_photo', 'label' => 'صورة جواز السفر', 'id' => 'passportInput'],
                                // ['name' => 'image', 'label' => 'الصورة الشخصية', 'id' => 'dd'],
                                [
                                    'name' => 'img_national_id_card',
                                    'label' => 'بطاقة الرقم القومي من الامام',
                                    'id' => 'ss',
                                ],
                                [
                                    'name' => 'img_national_id_card_back',
                                    'label' => 'بطاقة الرقم القومي من الخلف',
                                    'id' => 'aa',
                                ],
                                ['name' => 'license_photo', 'label' => 'اثبات مهنة (رخصة او شهادة)', 'id' => 'ff'],
                            ];
                        @endphp

                        @foreach ($images as $index => $img)
                            {{-- إذا كنا عند صورة البطاقة من الأمام، نبدأ div العرض الجانبي --}}
                            @if ($img['name'] == 'img_national_id_card')
                                <div class="d-flex flex-wrap gap-3">
                            @endif

                            {{-- إذا كنا داخل صور البطاقة الشخصية (أمام أو خلف) --}}
                            @if (in_array($img['name'], ['img_national_id_card', 'img_national_id_card_back']))
                                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm" style="flex: 1 1 48%;">
                                    <label for="{{ $img['name'] }}">{{ $img['label'] }}</label>

                                    <div class="custom-file mb-2">
                                        <input type="file" name="{{ $img['name'] }}"
                                            class="custom-file-input preview-image-input"
                                            data-preview="#preview_{{ $img['name'] }}" id="{{ $img['id'] }}"
                                            data-input="#{{ $img['id'] }}" required>
                                        <label class="custom-file-label">اختر صورة</label>
                                    </div>

                                    <div id="preview_{{ $img['name'] }}" class="border rounded p-2 text-center bg-light"
                                        style="min-height: 130px;">
                                        <img src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail"
                                            style="max-width: 100px; display: none;" alt="Preview">
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                        data-input="#{{ $img['id'] }}" data-preview="#preview_{{ $img['name'] }}">
                                        اقتصاص
                                    </button>
                                </div>
                            @else
                                {{-- باقي الصور (كل واحدة في صف مستقل) --}}
                                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm">
                                    <label for="{{ $img['name'] }}">{{ $img['label'] }}</label>

                                    <div class="custom-file mb-2">
                                        <input type="file" name="{{ $img['name'] }}"
                                            class="custom-file-input preview-image-input"
                                            data-preview="#preview_{{ $img['name'] }}" id="{{ $img['id'] }}"
                                            required>
                                        <label class="custom-file-label">اختر صورة</label>
                                    </div>

                                    <div id="preview_{{ $img['name'] }}" class="border rounded p-2 text-center bg-light"
                                        style="min-height: 130px;">
                                        <img src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail"
                                            style="max-width: 100px; display: none;" alt="Preview">
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                        data-input="#{{ $img['id'] }}" data-preview="#preview_{{ $img['name'] }}">
                                        اقتصاص
                                    </button>

                                    @if ($img['name'] == 'passport_photo')
                                        <div
                                            class="mt-3 d-flex align-items-center gap-3 flex-wrap justify-content-between">
                                            <button type="button" id="analyzeBtn"
                                                style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                فك البيانات
                                            </button>

                                            <div id="{{ $img['id'] }}_loader" class="loader"
                                                style="display: none; border: 4px solid #f3f3f3; border-top: 4px solid #007bff; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite;">
                                            </div>

                                            <div id="{{ $img['id'] }}_loader_text" class="loading-text"
                                                style="display: none; font-size: 14px; color: #007bff;">
                                                الرجاء الانتظار...
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- إذا كنا عند آخر صورة من البطاقة الشخصية، نغلق div --}}
                            @if ($img['name'] == 'img_national_id_card_back')
                    </div>
                    @endif
                    @endforeach

                </div>
            </div>
    </div>

    <div class="card-footer text-center">
        <button type="submit" id="submitBtn" class="btn btn-success" style="width: 250px">
            <i class="fas fa-plus-circle"></i> إضافة (f2)
        </button>
    </div>
    </form>
    </div>


    <!-- جدول عرض العملاء المحتملين -->
    @if (auth()->user()?->permissions->contains('permission', 'show-leads') || auth()->user()?->role == 'admin')
        <div class="card mt-4">
            <div class="card-header bg-dark">
                <h3 class="card-title text-white">العملاء المحتملين</h3>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center ccccc" style="">

                    <form method="GET" id="leadForm" action="{{ route('leads-customers.search') }}"
                        class="d-flex mb-3">
                        @csrf

                        <select class="form-select w-auto me-2" id="searchBy" name="searchBy">
                            <option value="id" {{ request('searchBy') == 'id' ? 'selected' : '' }}>الكود</option>
                            <option value="name" {{ request('searchBy') == 'name' ? 'selected' : '' }}>الاسم</option>
                            <option value="card_id" {{ request('searchBy') == 'card_id' ? 'selected' : '' }}>الرقم القومي
                            </option>
                            <option value="age" {{ request('searchBy') == 'age' ? 'selected' : '' }}>السن</option>
                            <option value="phone" {{ request('searchBy') == 'phone' ? 'selected' : '' }}>الهاتف</option>
                            <option value="governorate" {{ request('searchBy') == 'governorate' ? 'selected' : '' }}>
                                المحافظة
                            </option>
                            <option value="status" {{ request('searchBy') == 'status' ? 'selected' : '' }}>الحالة</option>
                            <option value="delegate_name" {{ request('searchBy') == 'delegate_name' ? 'selected' : '' }}>
                                المندوب</option>
                            <option value="registration_date"
                                {{ request('searchBy') == 'registration_date' ? 'selected' : '' }}>تاريخ التسجيل</option>
                        </select>

                        <input type="text" class="form-control me-2" id="searchInput" name="searchInput"
                            value="{{ request('searchInput') }}" placeholder="اكتب هنا للبحث">

                        <button type="submit" class="btn btn-primary">بحث</button>
                    </form>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <select id="filter-age" class="form-control">
                                <option value="">كل الأعمار</option>
                                @foreach ($leads->pluck('age')->unique() as $age)
                                    <option value="{{ $age }}">{{ $age }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter-governorate" class="form-control">
                                <option value="">كل المحافظات</option>
                                @foreach ($leads->pluck('governorate')->unique() as $gov)
                                    <option value="{{ $gov }}">{{ $gov }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter-status" class="form-control">
                                <option value="">كل الحالات</option>
                                @foreach ($leads->pluck('status')->unique() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="date" id="filter-date" class="form-control" placeholder="تاريخ التسجيل">
                        </div>
                    </div>
                    <div>
                        عدد المحددين: <span id="selected-count">0</span>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="operationsDropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            العمليات
                        </button>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="operationsDropdown">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#groupModal">
                                <i class="fas fa-plus text-success"></i> تعيين اختبار
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table id="example" class="table table-hover text-center">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>رقم</th>
                                <th>
                                    <input type="checkbox" class="width-input" id="select-all">
                                </th>
                                <th>كود</th>
                                <th>الاسم</th>
                                <th>صورة</th>
                                <th>السن</th>
                                <th>الهاتف</th>
                                <th>المحافظة</th>
                                <th>الحالة</th>
                                <th>المندوب</th>
                                <th>الاختبارات</th>
                                <th>تاريخ التسجيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr class="{{ $lead->evaluation == 'جارى المعالجة' ? 'bg-warning text-dark' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <input type="checkbox" class="lead-checkbox width-input" name="lead_ids[]"
                                            value="{{ $lead->id }}">
                                    </td>
                                    <td>#{{ $lead->id }}</td>
                                    <td>
                                        <a href="{{ route('leads-customers.show', $lead->id) }}" class="">
                                            {{ $lead->name }} </a>
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $lead->image) }}" target="blank">
                                            <img src="{{ asset('storage/' . $lead->image) }}" width="40"
                                                height="40" class="img-circle" alt="صورة" loading="lazy">
                                        </a>
                                    </td>
                                    <td>{{ $lead->age }}</td>
                                    <td>{{ $lead->phone }}</td>
                                    <td>{{ $lead->governorate }}</td>
                                    <td data-status="{{ $lead->status }}" class="lead-status">
                                        <span
                                            class="badge
                                        @if ($lead->status == 'عميل محتمل') bg-secondary
                                        @elseif ($lead->status == 'عميل اساسي') bg-success @endif">
                                            {{ $lead->status }}
                                        </span>
                                    </td>
                                    <td>{{ $lead->delegate->name ?? '-' }}</td>
                                    <td>
                                        @if ($lead->tests->count())
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    {{ $lead->tests->count() }}
                                                </a>
                                                <div class="dropdown-menu">
                                                    @foreach ($lead->tests as $test)
                                                        <a class="dropdown-item" title="{{ $test->title }}"
                                                            href="{{ route('test.leads', $test->id) }}">
                                                            {{ $test->title }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $lead->registration_date }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1 flex-nowrap">
                                            <a href="{{ route('leads-customers.update', $lead->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if (auth()->user()->role == 'admin')
                                                <form id="delete"
                                                    action="{{ route('leads-customers.delete', $lead->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- <tr>
                                <td colspan="12">لا يوجد بيانات حالياً.</td>
                            </tr> --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-users mr-2"></i> تعيين اختبار للعملاء المحددين
                    </h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="assignGroupForm" action="{{ route('tests.addCustomer') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="leads" id="selectedLeadsInput">

                        <div class="form-group">
                            <label for="groupSelect">اختر الاختبار</label>
                            <select class="form-control" id="groupSelect" name="test_id" required>
                                <option value="" disabled selected>-- اختر الاختبار --</option>
                                @foreach ($tests as $test)
                                    <option value="{{ $test->id }}">{{ $test->id }}: {{ $test->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times-circle mr-1"></i> إلغاء
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> حفظ التغييرات
                        </button>
                    </div>
                </form>
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
    {{-- تعديل الصور --}}
    <!-- نافذة الاقتصاص -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 70vw; height: 70vh;">
            <div class="modal-content" style="height: 100%;">

                <div class="modal-header">
                    <h5 class="modal-title">اقتصاص الصورة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>

                <!-- جسم المودال (الصورة تاخد كل المساحة المتاحة) -->
                <div class="modal-body bg-dark p-0" style="height: calc(100% - 120px);">
                    <div class="w-100 h-100">
                        <img id="cropperImage" style="width:100%; height:100%; object-fit:contain; display:block;">
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" id="zoomIn">تكبير +</button>
                        <button type="button" class="btn btn-secondary" id="zoomOut">تصغير -</button>
                        <button type="button" class="btn btn-secondary" id="rotateLeft">↺ تدوير</button>
                        <button type="button" class="btn btn-secondary" id="reset">إعادة ضبط</button>
                    </div>
                    <button type="button" id="cropConfirm" class="btn btn-success">تأكيد الاقتصاص</button>
                </div>

            </div>
        </div>
    </div>
@stop


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" rel="stylesheet" />
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            dom: 'ltp', // l = lengthMenu (قائمة تغيير عدد الصفوف), t = الجدول, p = ترقيم الصفحات
            pageLength: 20, // القيمة الافتراضية
            lengthMenu: [
                [10, 20, 50, -1],
                [10, 25, 50, 100, 250, 500, 'الكل']
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            },
            searching: false,
            ordering: true
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

        const genAI = new GoogleGenerativeAI("AIzaSyDjk68-pr2IRQ5oJOb6AkAZe219EpJAHh4");

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
                    model: "gemini-2.0-flash"
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
                    const age = row.cells[4]?.textContent.trim(); // السن
                    const gov = row.cells[6]?.textContent.trim().toLowerCase(); // المحافظة
                    const status = row.cells[7]?.textContent.trim().toLowerCase(); // الحالة
                    const date = row.cells[9]?.textContent.trim(); // تاريخ التسجيل

                    const matchesAge = !selectedAge || age === selectedAge;
                    const matchesGov = !selectedGov || gov === selectedGov;
                    const matchesStatus = !selectedStatus || status === selectedStatus;
                    const matchesDate = !selectedDate || date === selectedDate;

                    if (matchesAge && matchesGov && matchesStatus && matchesDate) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            ageFilter.addEventListener('change', filterTable);
            govFilter.addEventListener('change', filterTable);
            statusFilter.addEventListener('change', filterTable);
            dateFilter.addEventListener('change', filterTable);
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

@stop
