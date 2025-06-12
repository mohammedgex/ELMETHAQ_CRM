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
                                    placeholder="أدخل اسم العميل" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>الوظيفة المقدم عليها</label>
                                <select name="job_title_id" class="form-control" required>
                                    <option value="">اختر الوظيفة</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job->id }}">{{ $job->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>السن</label>
                                <input type="text" name="age" id="age" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>رقم هاتف آخر</label>
                                <input type="text" name="phone_two" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label>المندوب</label>
                                <select name="delegate_id" class="form-control" required>
                                    <option value="">اختر المندوب</option>
                                    @foreach ($delegates as $delegate)
                                        <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label>الرقم القومي</label>
                                <input type="text" name="card_id" id="card_id" class="form-control" required>
                                @if ($errors->has('card_id'))
                                    <div class="text-danger">
                                        {{ $errors->first('card_id') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label>نوع الرخصة</label>
                                <select name="licence_type" class="form-control" required>
                                    <option value="">اختر النوع</option>
                                    <option value="درجة أولي">درجة أولي</option>
                                    <option value="درجة ثانية">درجة ثانية</option>
                                    <option value="درجة ثالثة">درجة ثالثة</option>
                                    <option value="رخصة خاصة">رخصة خاصة</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>التقييم</label>
                                <select name="evaluation" class="form-control" required>
                                    <option value="">اختر التقييم</option>
                                    <option value="مقبول">مقبول</option>
                                    <option value="جارى المعالجة">جاري المعالجة</option>
                                    <option value="احتياطي">احتياطي</option>
                                    <option value="غير مقبول">غير مقبول</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>نوع الاختبار</label>
                                <select name="test_type" class="form-control" required>
                                    <option value="">اختر النوع</option>
                                    <option value="اول اختبار">اول اختبار</option>
                                    <option value="اعادة اختبار">اعادة اختبار</option>
                                    <option value="قيادة امنة">قيادة امنة</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>المحافظة</label>
                                <select name="governorate" id="governorate" class="form-control" required>
                                    <option value="">اختر المحافظة</option>
                                    @foreach ($governorates as $gov)
                                        <option value="{{ $gov }}">{{ $gov }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label>موعد التسجيل</label>
                                <input type="date" name="registration_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- صور -->
                    <div class="col-md-4">
                        @php
                            $images = [
                                ['name' => 'passport_photo', 'label' => 'صورة جواز السفر', 'id' => 'passportInput'],
                                ['name' => 'image', 'label' => 'الصورة الشخصية', 'id' => 'dd'],
                                ['name' => 'img_national_id_card', 'label' => 'بطاقة الرقم القومي', 'id' => 'ss'],
                                ['name' => 'license_photo', 'label' => 'صورة الرخصة', 'id' => 'aa'],
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
                                            style="padding: 8px 20px; background-color: #997a44; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                            فك البيانات
                                        </button>

                                        <div id="{{ $img['id'] }}_loader" class="loader"
                                            style="display: none; border: 4px solid #f3f3f3; border-top: 4px solid #997a44; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite;">
                                        </div>

                                        <div id="{{ $img['id'] }}_loader_text" class="loading-text"
                                            style="display: none; font-size: 14px; color: #997a44;">
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">العملاء المحتملين</h3>

                <!-- زر العمليات -->
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
                            <th>السن</th>
                            <th>الهاتف</th>
                            <th>المحافظة</th>
                            <th>الرخصة</th>
                            <th>الحالة</th>
                            <th>المندوب</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leads as $lead)
                            <tr>
                                <td>
                                    <input type="checkbox" class="lead-checkbox" name="lead_ids[]"
                                        value="{{ $lead->id }}">
                                </td>
                                <td>#{{ $lead->id }}</td>
                                <td>{{ $lead->name }}</td>
                                <td><img src="{{ asset('storage/' . $lead->image) }}" width="40" height="40"
                                        class="img-circle" alt="صورة"></td>
                                <td>{{ $lead->age }}</td>
                                <td>{{ $lead->phone }}</td>
                                <td>{{ $lead->governorate }}</td>
                                <td>{{ $lead->licence_type }}</td>
                                <td data-status="{{ $lead->status }}" class="lead-status">
                                    <span
                                        class="badge 
                                        @if ($lead->status == 'عميل محتمل') bg-warning 
                                        @elseif ($lead->status == 'عميل اساسي') bg-success 
                                        @else bg-secondary @endif">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td>{{ $lead->delegate->name ?? '-' }}</td>
                                <td>{{ $lead->registration_date }}</td>
                                <td>
                                    <a href="{{ route('leads-customers.show', $lead->id) }}"
                                        class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('leads-customers.update', $lead->id) }}"
                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('leads-customers.delete', $lead->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('تأكيد الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
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
                    <form id="assignGroupForm" action="{{ route('customer.leadToCustomer') }}" method="POST">
                        @csrf
                        <input type="hidden" name="leads" id="selectedLeadsInput">
                        <!-- هنا هتتحط الـ IDs -->

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
                alert("يرجى اختيار صورة جواز السفر.");
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
"age"
}
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
                            document.getElementById("age").value = data.age;
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
                            document.getElementById("passportInput_loader").style.display = "none";
                            document.getElementById("passportInput_loader_text").style.display = "none";
                            alert("The passport photo is not clear.");
                        }

                        console.log(data);
                    } catch (error) {
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
                alert("يرجى اختيار عميل واحد على الأقل.");
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
                alert("يوجد عميل أساسي بالفعل ضمن العملاء المحددين.");
                return;
            }

            // تعبئة hidden input بقائمة الـ IDs
            document.getElementById('selectedLeadsInput').value = JSON.stringify(selectedIds);

            // إرسال الفورم
            this.submit();
        });
    </script>


@stop
