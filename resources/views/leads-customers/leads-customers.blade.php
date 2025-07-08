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

        <form action="{{ route('leads-customers.create') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                <div class="row">
                    <!-- الحقول الرئيسية -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>اسم العميل</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="أدخل اسم العميل" required value="{{ old('name') }}">
                            </div>
                            <div class="form-group col-md-12">
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

                            <div class="form-group col-md-4">
                                <label>السن</label>
                                <input type="text" name="age" id="age" class="form-control" required
                                    placeholder="أدخل السن" value="{{ old('age') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control" required
                                    placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}">
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

                            <div class="form-group col-md-12">
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

                            <div class="form-group col-md-12">
                                <label>الرقم القومي</label>
                                <input type="text" name="card_id" id="card_id" class="form-control" required
                                    placeholder="أدخل الرقم القومي" value="{{ old('card_id') }}">
                                @if ($errors->has('card_id'))
                                    <div class="text-danger">
                                        {{ $errors->first('card_id') }}
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
                        </div>
                    </div>

                    <!-- صور -->
                    <div class="col-md-4">
                        @php
                            $images = [
                                ['name' => 'passport_photo', 'label' => 'صورة جواز السفر', 'id' => 'passportInput'],
                                ['name' => 'image', 'label' => 'الصورة الشخصية', 'id' => 'dd'],
                                [
                                    'name' => 'img_national_id_card',
                                    'label' => ' بطاقة الرقم القومي من الامام',
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

                        @foreach ($images as $img)
                            <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm">
                                <label for="{{ $img['name'] }}">{{ $img['label'] }}</label>

                                <div class="custom-file mb-2">
                                    <input type="file" name="{{ $img['name'] }}"
                                        class="custom-file-input preview-image-input"
                                        data-preview="#preview_{{ $img['name'] }}" id="{{ $img['id'] }}" required>
                                    <label class="custom-file-label">اختر صورة</label>
                                </div>

                                <div id="preview_{{ $img['name'] }}" class="border rounded p-2 text-center bg-light"
                                    style="min-height: 130px;">
                                    <img src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail"
                                        style="max-width: 100px; display: none;" alt="Preview">
                                </div>

                                @if ($img['name'] == 'passport_photo')
                                    <div class="mt-3 d-flex align-items-center gap-3 flex-wrap justify-content-between">
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
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-success" style="width: 250px">
                    <i class="fas fa-plus-circle"></i> إضافة
                </button>
            </div>
        </form>
    </div>


    <!-- جدول عرض العملاء المحتملين -->
    <div class="card mt-4">
        <div class="card-header bg-dark">
            <h3 class="card-title text-white">العملاء المحتملين</h3>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center ccccc" style="">

                <form method="GET" action="{{ route('leads-customers.search') }}" class="d-flex mb-3">
                    @csrf

                    <select class="form-select w-auto me-2" id="searchBy" name="searchBy">
                        <option value="id" {{ request('searchBy') == 'id' ? 'selected' : '' }}>الكود</option>
                        <option value="name" {{ request('searchBy') == 'name' ? 'selected' : '' }}>الاسم</option>
                        <option value="card_id" {{ request('searchBy') == 'card_id' ? 'selected' : '' }}>الرقم القومي
                        </option>
                        <option value="age" {{ request('searchBy') == 'age' ? 'selected' : '' }}>السن</option>
                        <option value="phone" {{ request('searchBy') == 'phone' ? 'selected' : '' }}>الهاتف</option>
                        <option value="governorate" {{ request('searchBy') == 'governorate' ? 'selected' : '' }}>المحافظة
                        </option>
                        <option value="licence_type" {{ request('searchBy') == 'licence_type' ? 'selected' : '' }}>الرخصة
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

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="operationsDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        العمليات
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="operationsDropdown">
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#groupModal">
                            <i class="fas fa-plus text-success"></i> تحويل كعميل أساسي
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-center">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>كود</th>
                            <th>الاسم</th>
                            <th>صورة</th>
                            <th>الرقم القومي</th>
                            <th>السن</th>
                            <th>الهاتف</th>
                            <th>المحافظة</th>
                            <th>الحالة</th>
                            <th>المندوب</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leads as $lead)
                            <tr class="{{ $lead->evaluation == 'جارى المعالجة' ? 'bg-warning text-dark' : '' }}">
                                <td>
                                    <input type="checkbox" class="lead-checkbox" name="lead_ids[]"
                                        value="{{ $lead->id }}">
                                </td>
                                <td>#{{ $lead->id }}</td>
                                <td>{{ $lead->name }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $lead->image) }}" target="blank">
                                        <img src="{{ asset('storage/' . $lead->image) }}" width="40" height="40"
                                            class="img-circle" alt="صورة">
                                    </a>
                                </td>
                                <td>{{ $lead->card_id }}</td>
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
                                <td>{{ $lead->registration_date }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1 flex-nowrap">
                                        <a href="{{ route('leads-customers.show', $lead->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-star"></i>
                                        </a>
                                        <a href="{{ route('leads-customers.update', $lead->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('leads-customers.delete', $lead->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">لا يوجد بيانات حالياً.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-users mr-2"></i> تعيين مجموعة للعملاء المحددين
                    </h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="assignGroupForm" action="{{ route('customer.leadToCustomer') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="leads" id="selectedLeadsInput">

                        <div class="form-group">
                            <label for="groupSelect">اختر المجموعة</label>
                            <select class="form-control" id="groupSelect" name="group_id" required>
                                <option value="" disabled selected>-- اختر المجموعة --</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->id }}: {{ $group->title }}
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



@stop


@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
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
        document.getElementById('select-all').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.lead-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
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

                const prompt = `
Extract all data from this passport in English. Convert the national ID to English digits if it's in Arabic. Return response as clean JSON only with these keys:
{
"passport_type",
"country_code",
"passport_number",
"full_name_arabic",
"full_name_english",
"date_of_birth",
"place_of_birth_ar",
"nationality_ar",
"sex_ar",
"date_of_issue",
"date_of_expiry",
"issuing_office",
"national_id",
"profession",
"military_status",
"address",
"full_mrz",
}

If the image is not clear, send me a JSON with error. The image is not clear.
    `;

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
                            const govSelect = document.getElementById('governorate');
                            if (data.place_of_birth_ar) {
                                const valueToSelect = data.place_of_birth_ar.trim();
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
                            alert("The passport photo is not clear.");
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
                const status = row.querySelector('.lead-status')?.dataset.status;
                if (status === 'عميل اساسي') {
                    hasExistingCustomer = true;
                }

                selectedIds.push(leadId);
            });

            if (hasExistingCustomer) {
                Swal.fire({
                    title: "يوجد عميل أساسي بالفعل في الاختيارات.",
                    icon: "error",
                    draggable: true
                });
                return;
            }

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
                    const status = row.cells[8]?.textContent.trim().toLowerCase(); // الحالة
                    const date = row.cells[10]?.textContent.trim(); // تاريخ التسجيل

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
    </script>


@stop
