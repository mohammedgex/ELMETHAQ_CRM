@extends('adminlte::page')

@section('title', 'إدارة بيانات العمال')

@section('content_header')
<h1>اضافة بيانات عميل</h1>
@stop

@section('content')
<div class="card shadow-lg border-success">
    <div class="card-body">
        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item"><a class="nav-link active" style="color: #997a44;" data-toggle="tab"
                    href="#personalInfo">التفاصيل الشخصية</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-toggle="tab"
                    href="#passportDetails">تفاصيل جواز السفر</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-toggle="tab"
                    href="#attachments">المرفقات</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-toggle="tab"
                    href="#payments">المدفوعات</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab"
                    href="#timelineTab">تقدم العميل</a></li>
        </ul>


        <div class="tab-content mt-3">

            <div id="timelineTab" class="tab-pane fade">
                <h2 class=" text-center"> تاريخ العميل</h2>
                <ul class="timeline" id="timeline">
                    <li class="timeline-item">
                        <span class="timeline-icon step-1"></i></span>
                        <div class="timeline-content">
                            <div class="timeline-header row justify-content-between">
                                <span class="d-block text-start"><i class="fas fa-user" style="color: #997a44;"></i> الموظف: <strong>أحمد محمد</strong></span>
                                <span class="timestamp"><i class="fas fa-calendar-alt" style="color: #997a44;"></i> التاريخ: <strong>2025-03-24 14:30</strong></span>
                            </div>
                            <h3 class="bold mt-4">تسجيل البيانات</h3>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <span class="timeline-icon step-1"></i></span>
                        <div class="timeline-content">
                            <div class="timeline-header row justify-content-between">
                                <span class="d-block text-start"><i class="fas fa-user" style="color: #997a44;"></i> الموظف: <strong>أحمد محمد</strong></span>
                                <span class="timestamp"><i class="fas fa-calendar-alt" style="color: #997a44;"></i> التاريخ: <strong>2025-03-24 14:30</strong></span>
                            </div>
                            <h3 class="bold mt-4">تسجيل البيانات</h3>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <span class="timeline-icon step-1"></i></span>
                        <div class="timeline-content">
                            <div class="timeline-header row justify-content-between">
                                <span class="d-block text-start"><i class="fas fa-user" style="color: #997a44;"></i> الموظف: <strong>أحمد محمد</strong></span>
                                <span class="timestamp"><i class="fas fa-calendar-alt" style="color: #997a44;"></i> التاريخ: <strong>2025-03-24 14:30</strong></span>
                            </div>
                            <h3 class="bold mt-4">تسجيل البيانات</h3>
                        </div>
                    </li>
                </ul>
                <div class="text-center">
                    <button class="btn btn-sm mt-3 text-white" style="background-color: #997a44;" id="addHistory" data-bs-toggle="modal" data-bs-target="#stepModal">
                        إضافة جديد
                    </button>
                </div>
            </div>

            <div class="modal fade" id="stepModal" tabindex="-1" aria-labelledby="stepModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="stepModalLabel">إضافة جديد</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="stepDescription" class="form-label">الوصف</label>
                                    <textarea class="form-control" id="historyDescription" rows="5" placeholder="أدخل الوصف"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="stepDate" class="form-label">التاريخ</label>
                                    <input type="datetime-local" class="form-control" id="historyDate">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="button" class="btn btn-primary">حفظ</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- التفاصيل الشخصية -->
            <form id="personalInfo" class="tab-pane fade show active" action="{{ route('customer.basicDetails') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="section-container">
                    <h4>الصورة الشخصية</h4>
                    <div class="col-md-12 d-flex align-items-center justify-content-center">
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input type="file" class="form-control fw-bold" id="attachmentFile" name="image"
                                    accept="image/*" onchange="previewImage(event)">
                                <img id="imagePreview" src="" alt="معاينة"
                                    style="display: none; width: 200px; height: 150px; object-fit: cover; margin-right: 30px; border-radius: 6px; border: 2px solid #997a44;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- القسم: المعلومات الأساسية -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">المعلومات الأساسية</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الاسم الكامل</label>
                            <input type="text" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" placeholder="أدخل الاسم الكامل"
                                name="name_ar">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الرقم القومي</label>
                            <input type="text" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" placeholder="أدخل الرقم القومي"
                                name="card_id">
                        </div>

                    </div>

                    <div class="row my-2">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">محافظة الاقامة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="governorate_live">
                                <option value="">اختر المحافظة</option>
                                <option value="القاهرة">القاهرة</option>
                                <option value="اسكندرية"> اسكندرية</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">السن</label>
                            <input type="text" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" placeholder="أدخل العمر" name="age">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> التقييم</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="evalution_id">
                                <option value="">اختر التقييم</option>
                                @foreach ($evalutions as $evalution)
                                <option value="{{ $evalution->id }}">{{ $evalution->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> الحالة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="status">
                                <option value="">اختر الحالة</option>
                                <option value="جديد">جديد</option>
                                <option value="ناجح">ناجح</option>
                                <option value="تجهيز الاوراق">تجهيز الاوراق</option>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- القسم: معلومات العمل -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">معلومات العمل</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">اختر المندوب</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="delegate_id">
                                <option value="">اختر المندوب</option>
                                @foreach ($delegates as $delegate)
                                <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">اختر المجموعة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="customer_group_id">
                                <option value="">اختر المجموعة</option>
                                @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 my-2">
                            <label class="fw-bold" style="color: #997a44;">اختر الوظيفة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="job_title_id">
                                <option value="">اختر الوظيفة</option>
                                @foreach ($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 my-2">
                            <label class="fw-bold" style="color: #997a44;">اختر الكفيل</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="sponser_id">
                                <option value=""> اختر الكفيل</option>
                                @foreach ($sponsers as $sponser)
                                <option value="{{ $sponser->id }}">{{ $sponser->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- القسم: البيانات الشخصية -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3"> بيانات الرخصة</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="fw-bold" style="color: #997a44;">نوع الرخصة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="license_type">
                                <option value="">اختر الرخصة</option>
                                <option value="درجة أولي">درجة أولي</option>
                                <option value="درجة ثانية">درجة ثانية</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="fw-bold" style="color: #997a44;">تاريخ انتهاء</label>
                            <input type="date" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الرخصة"
                                name="license_expire_date">
                        </div>

                        <div class="col-md-4">
                            <label class="fw-bold" style="color: #997a44;">حالة الرخصة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="license_status">
                                <option value="">حالة الرخصة</option>
                                <option value="سارية"> سارية</option>
                                <option value="منتهية">منتهية </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- القسم: معلومات الاتصال -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">معلومات الاتصال</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">رقم الهاتف</label>
                            <input type="text" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الهاتف"
                                name="phone">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">رقم هاتف آخر</label>
                            <input type="text" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم هاتف آخر"
                                name="phone_two">
                        </div>

                    </div>
                </div>



                <!-- القسم: بيانات التأشيرة -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">معلومات تأشيرة السفر</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> التأشيرة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="visa_type_id">
                                <option value="">اختر التأشيرة</option>
                                @foreach ($visas as $visa)
                                <option value="{{ $visa->id }}">{{ $visa->outgoing_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">رقم طلب التأشيرة</label>
                            <input type="text" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم التأشيرة"
                                name="e_visa_number">
                        </div>
                    </div>
                </div>

                <!-- المراحل -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3"> المراحل </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> الكشف الطبي </label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="medical_examination">
                                <option value="">اختر المرحلة</option>
                                <option value="في انتظار الحجز">في انتظار الحجز</option>
                                <option value="تم الحجز">تم الحجز</option>
                                <option value="لائق">لائق</option>
                                <option value="غير لائق">غير لائق</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> البصمة </label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="finger_print_examination">
                                <option value="">اختر المرحلة</option>
                                <option value="في انتظار الحجز">في انتظار الحجز</option>
                                <option value="تم تصدير الاكسيل"> تم تصدير الاكسيل </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> كشف الفايرس </label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="virus_examination">
                                <option value="">اختر المرحلة</option>
                                <option value="بأنتظار ايصال المعامل"> بأنتظار ايصال المعامل </option>
                                <option value="تم اصدار ايصال المعامل"> تم اصدار ايصال المعامل</option>
                                <option value="سالب"> سالب </option>
                                <option value="موجب"> موجب </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> حجز النت </label>
                            <select name="engaz_request" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;">
                                <option value="">اختر المرحلة</option>
                                <option value="في انتظار الطلب">في انتظار الطلب </option>
                                <option value="تم الحجز">تم الحجز </option>
                                <option value="تم اصدار التأشيرة">تم اصدار التأشيرة </option>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- القسم: معلومات إضافية -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">معلومات إضافية</h4>

                    <div class="row my-2">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الجنسية</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="nationality">
                                <option value="">اختر الجنسية</option>
                                <option value="مصري">مصري</option>
                                <option value="غير ذلك">غير ذلك</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الحالة الاجتماعية</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                name="marital_status">
                                <option value="">اختر الحالة الاجتماعية</option>
                                <option value="أعزب">أعزب</option>
                                <option value="متزوج">متزوج</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="fw-bold" style="color: #997a44;"> المؤهل الدراسي</label>
                        <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                            name="education">
                            <option value="">اختر المؤهل</option>
                            <option value="محو امية">محو امية</option>
                            <option value="مؤهل متوسط">مؤهل متوسط</option>
                        </select>
                    </div>
                    <div class="col-md-12 my-2">
                        <label class="fw-bold" style="color: #997a44;"> ملاحظات</label>
                        <textarea class="form-control fw-bold" style="height: 100px; border-color: #997a44;" placeholder="ملاحظات هنا..."
                            name="notes"></textarea>
                    </div>
                </div>


                <div class="d-flex justify-content-between mt-3">
                    <!-- زر الحفظ -->
                    <button type="submit" class="btn text-white fw-bold"
                        style="background-color: #997a44; width: 50%;">حفظ البيانات</button>

                    <!--------------------------------- تظهر فقط عند اضافة المستخدم او التعديل --------------------------------------->
                    <!-- زر الحذف -->
                    <button type="button" class="btn btn-danger fw-bold" style="width: 20%;">حذف</button>

                    <!-- زر الإضافة إلى قائمة الحظر -->
                    <button type="button" class="btn btn-warning fw-bold" style="width: 25%;">إضافة إلى قائمة
                        الحظر</button>
                </div>
            </form>

            <!----------------------------------------------------------------- تفاصيل جواز السفر ------------------------------------------------------------------------------------------------------------->
            <div id="passportDetails" class="tab-pane fade">
                <form action="{{ route('customer.mrz', 6) }}" method="POST" class="table-wrapper">
                    <!-- حقل MRZ -->
                    <div class="form-group">
                        <label class="fw-bold" style="color: #997a44;" for="mrz_input">أدخل بيانات MRZ</label>
                        <textarea id="mrz_input" name="mrz" class="form-control fw-bold" style="border-color: #997a44;" rows="2"
                            placeholder="ضع هنا منطقة القراءة الآلية من جواز السفر"></textarea>
                    </div>

                    <!-- زر استخراج البيانات -->
                    <button type="button" class="btn text-white fw-bold" style="background-color: #997a44;"
                        onclick="extractMRZData()">
                        استخراج البيانات
                    </button>

                    <!-- ترتيب الحقول بحيث يكون كل 2 input جنبًا إلى جنب -->
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #997a44;" for="full_name">الاسم الكامل علي
                                    الجواز</label>
                                <div class="input-group rounded">
                                    <input type="text" id="full_name" name="name_en_mrz"
                                        class=" form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        readonly>
                                    <button class="btn btn-primary copy-btn ml-1" onclick="copyText()"
                                        title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #997a44;" for="passport_number">رقم
                                    الجواز</label>
                                <div class="input-group rounded">
                                    <input type="text" id="passport_number" name="passport_id"
                                        class=" form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        readonly>
                                    <button class="btn btn-primary copy-btn ml-1" onclick="copyText()"
                                        title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #997a44;" for="nationality">الجنسية</label>
                                <div class="input-group rounded">
                                    <input type="text" id="nationality" name="nationality"
                                        class=" form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        readonly>
                                    <button class="btn btn-primary copy-btn ml-1" onclick="copyText()"
                                        title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #997a44;" for="dob">تاريخ
                                    الميلاد</label>
                                <div class="input-group rounded">
                                    <input type="text" id="dob" name="date_birth"
                                        class=" form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        readonly>
                                    <button class="btn btn-primary copy-btn ml-1" onclick="copyText()"
                                        title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #997a44;" for="expiry_date">تاريخ انتهاء
                                    الصلاحية</label>
                                <div class="input-group rounded">
                                    <input type="text" id="expiry_date" name="passport_expire_date"
                                        class=" form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        readonly>
                                    <button class="btn btn-primary copy-btn ml-1" onclick="copyText()"
                                        title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #997a44;" for="gender">النوع</label>
                                <div class="input-group rounded">
                                    <input type="text" name="gender" id="gender"
                                        class=" form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        readonly>
                                    <button class="btn btn-primary copy-btn ml-1" onclick="copyText()"
                                        title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">السن</label>
                            <div class="input-group rounded">
                                <input type="text" id="age" class="form-control fw-bold"
                                    style="height: 60px; border-color: #997a44;" name="age" readonly>
                                <button class="btn btn-primary copy-btn ml-1" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">جهة الاصدار</label>
                            <div class="input-group rounded">
                                <input type="text" class="form-control fw-bold"
                                    style="height: 60px; border-color: #997a44;" name="issue_place" id="eg_code" readonly>
                                <button class="btn btn-primary copy-btn ml-1" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <!-- زر الحفظ -->
                        <button type="submit" class="btn text-white fw-bold"
                            style="background-color: #997a44; width: 50%;">حفظ البيانات</button>

                        <!--------------------------------- تظهر فقط عند اضافة المستخدم او التعديل --------------------------------------->
                        <!-- زر الحذف -->
                        <button type="button" class="btn btn-danger fw-bold" style="width: 20%;">حذف</button>

                        <!-- زر الإضافة إلى قائمة الحظر -->
                        <button type="button" class="btn btn-warning fw-bold" style="width: 25%;">إضافة إلى
                            قائمة
                            الحظر</button>
                    </div>
                </form>
            </div>

            <!-- المرفقات -->
            <div id="attachments" class="tab-pane fade">
                <h4 class="fw-bold">إضافة مرفقات</h4>

                <div class="row">
                    <!-- حقل عنوان المرفق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">عنوان المرفق</label>
                            <select id="attachmentTitle" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;">
                                <option value="">اختر نوع المستند</option>
                                <option value="جواز سفر">جواز سفر</option>
                                <option value="رخصة">رخصة</option>
                                <option value="تأشيرة">تأشيرة</option>
                            </select>
                            <!-- <input type="text" class="form-control fw-bold" style="border-color: #997a44; height: 60px;" id="attachmentTitle" placeholder="مثال: صورة الجواز"> -->
                        </div>
                    </div>

                    <!-- حقل رفع المرفق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">رفع المرفق</label>
                            <input type="file" class="form-control fw-bold"
                                style="border-color: #997a44; height: 60px;" id="attachmentFile">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">حالة المرفق</label>
                            <select id="attachmentTitle" class="form-control fw-bold"
                                style="height: 60px; border-color: #997a44;">
                                <option value="">اختر حالة المرفق</option>
                                <option value="جواز سفر"> لا يوجد بالمكتب </option>
                                <option value="رخصة">موجود بالمكتب</option>
                            </select>
                            <!-- <input type="text" class="form-control fw-bold" style="border-color: #997a44; height: 60px;" id="attachmentTitle" placeholder="مثال: صورة الجواز"> -->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">ملحوظة </label>
                            <input type="text" class="form-control fw-bold"
                                style="border-color: #997a44; height: 60px;" id="attachmentFile">
                        </div>
                    </div>
                </div>

                <!-- زر إضافة مرفق -->
                <button type="button" class="btn text-white fw-bold mt-2" style="background-color: #997a44;"
                    id="addAttachment">إضافة مرفق</button>

                <!-- جدول المرفقات -->
                <table class="table table-bordered mt-3">
                    <thead style="background-color: #997a44; color: white;">
                        <tr>
                            <th>عنوان المرفق</th>
                            <th>المرفق</th>
                            <th>حالة المرفق</th>
                            <th>ملحوظة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="attachmentTable">
                        <!-- بيانات المرفقات ستتم إضافتها هنا -->
                    </tbody>
                </table>
            </div>

            <!-- المدفوعات -->
            <div id="payments" class="tab-pane fade">
                <h4>إضافة مدفوعات</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label style="color: #997a44;">عنوان الدفع</label>
                        <select id="paymentTitle" class="form-control fw-bold"
                            style="height: 60px; border-color: #997a44;">
                            <option value="">اختر نوع المعاملة</option>
                            <option value="دفع كشف طبي"> دفع كشف طبي</option>
                            <option value="دفع حجز نت">دفع حجز نت </option>
                            <option value="C">عملة المكتب</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label style="color: #997a44;">قيمة الدفع</label>
                        <input type="number" class="form-control " style="border-color: #997a44; height: 60px;"
                            id="paymentAmount" placeholder="أدخل القيمة">
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label style="color: #997a44;">قيمة الدفع</label>
                        <input type="number" class="form-control " style="border-color: #997a44; height: 60px;"
                            id="paymentAmount" placeholder="أدخل القيمة">
                    </div>
                    <div class="col-md-6">
                        <label style="color: #997a44;"> المتبقي</label>
                        <input type="number" class="form-control " style="border-color: #997a44; height: 60px;"
                            id="paymentAmount" value="0" placeholder="أدخل المتبقي">
                    </div>
                </div>

                <button type="button" class="btn text-white fw-bold mt-2" style="background-color: #997a44;"
                    id="addPayment">إضافة دفعة</button>


                <table class="table table-bordered mt-3">
                    <thead style="background-color: #997a44; color: white;">
                        <tr>
                            <th>عنوان الدفع</th>
                            <th>المبلغ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="paymentTable">
                    </tbody>
                </table>
            </div>

            <div id="timelineTab" class="tab-pane fade">
                <h5 class="text-success">مخطط التقدم</h5>
                <ul class="timeline" id="timeline">
                    <li class="timeline-item">
                        <span class="timeline-icon bg-success"></span>
                        <div class="timeline-content">
                            <h6>الخطوة الأولى</h6>
                            <p>تم تسجيل البيانات الأساسية</p>
                        </div>
                    </li>
                </ul>
                <button class="btn btn-success btn-sm mt-3" id="addStep">إضافة خطوة جديدة</button>
            </div>
        </div>

        <!-- <button class="btn btn-success btn-block mt-3">حفظ البيانات</button> -->
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .timeline {
        position: relative;
        list-style: none;
        padding: 20px 0;
        margin: 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        width: 4px;
        height: 100%;
        background: #6c757d;
        transform: translateX(50%);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    .timeline-content {
        width: 45%;
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
        text-align: right;
    }

    .timeline-item:nth-child(even) .timeline-content {
        margin-right: auto;
        text-align: right;
    }

    .timeline-icon {
        position: absolute;
        top: 50%;
        right: 50%;
        transform: translate(50%, -50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .step-1 {
        background: #28a745;
    }

    /* ناجح */
    .step-2 {
        background: #007bff;
    }

    /* قيد التنفيذ */
    .step-3 {
        background: #ffc107;
    }

    /* بانتظار الموافقة */
    .step-4 {
        background: #dc3545;
    }

    /* مرفوض */
    .section-container {
        background: #f8f9fa;
        /* لون فاتح */
        padding: 20px;
        border-radius: 10px;
        /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
        margin-bottom: 20px;
        /* تباعد بين الأقسام */
    }

    .nav-tabs {
        font-weight: 800 !important;
    }

    #attachmentFile {
        border: 1px solid #997a44;
        border-radius: 8px;
        height: 55px;
        font-weight: bold;
        color: #333;
        background-color: #f9f5f0;
        transition: all 0.3s ease-in-out;
        padding: 10px;
    }

    #attachmentFile:hover {
        border-color: #b38f5e;
        background-color: #f1ebe5;
    }

    #attachmentFile:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(153, 122, 68, 0.5);
        border-color: #b38f5e;
    }

    .fw-bold {
        font-size: 16px;
    }

    label.fw-bold {
        display: block;
        margin-bottom: 8px;
        font-size: 18px;
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
    document.getElementById('addStep').addEventListener('click', function() {
        const timeline = document.getElementById('timeline');
        const stepNumber = timeline.children.length + 1;
        const icons = ['fa-passport', 'fa-plane', 'fa-file-alt', 'fa-times-circle'];
        const texts = ['تم تقديم الطلب', 'تمت الموافقة على الطلب', 'تم إصدار التأشيرة', 'تم رفض الطلب'];
        const colors = ['step-1', 'step-2', 'step-3', 'step-4'];

        const newStep = document.createElement('li');
        newStep.classList.add('timeline-item');
        newStep.innerHTML = `
            <span class="timeline-icon ${colors[stepNumber % 4]}"><i class="fas ${icons[stepNumber % 4]}"></i></span>
            <div class="timeline-content">
                <h4> تم اصدار تأشيرة السفر</h4>
                <p>${texts[stepNumber % 4]}</p>
            </div>
        `;
        timeline.appendChild(newStep);
    });

    $(document).ready(function() {
        $('.nav-tabs a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // إضافة مرفق جديد
        $("#addAttachment").click(function() {
            var title = $("#attachmentTitle").val();
            var fileInput = $("#attachmentFile")[0];

            if (title.trim() === "" || fileInput.files.length === 0) {
                alert("يرجى إدخال عنوان المرفق واختيار ملف.");
                return;
            }

            var file = fileInput.files[0];
            var fileName = file.name;
            newRow = `
                <tr>
                    <td>${title}</td>
                    <td>${fileName}</td>
                    <td>
                        <button class="btn btn-sm text-white" style="background-color: #997a44;" onclick="downloadFile('${fileName}')">
                            <i class="fas fa-download"></i> تحميل
                        </button>
                        <button class="btn btn-sm text-white" style="background-color: blue;" onclick="downloadFile('${fileName}')">
                            <i class="fas fa-delete"></i> عرض
                        </button>
                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;


            $("#attachmentTable").append(newRow);
            $("#attachmentTitle").val("");
            $("#attachmentFile").val("");
        });

        // حذف مرفق
        $(document).on("click", ".removeAttachment", function() {
            $(this).closest("tr").remove();
        });

        // إضافة دفعة جديدة
        $("#addPayment").click(function() {
            var title = $("#paymentTitle").val();
            var amount = $("#paymentAmount").val();

            if (title.trim() === "" || amount.trim() === "") {
                alert("يرجى إدخال عنوان الدفع والمبلغ.");
                return;
            }

            var newRow = `
                <tr>
                    <td>${title}</td>
                    <td>${amount} جنية</td>
                    <td>
                        <button class="btn btn-danger btn-sm removePayment"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;

            $("#paymentTable").append(newRow);
            $("#paymentTitle").val("");
            $("#paymentAmount").val("");
        });

        // حذف دفعة
        $(document).on("click", ".removePayment", function() {
            $(this).closest("tr").remove();
        });
    });

    //استخراج بيانات جواز السفر
    function extractMRZData() {
        let mrz = document.getElementById("mrz_input").value;
        let lines = mrz.split("\n");
        if (lines.length < 2) {
            alert("يرجى إدخال MRZ صالح");
            return;
        }

        let passportNumber = lines[1].substring(0, 9).replace(/</g, ""); // رقم الجواز
        let nationality = lines[1].substring(10, 13).replace(/</g, ""); // الجنسية

        // استخراج تاريخ الميلاد
        let rawBirthDate = lines[1].substring(13, 19).replace(/</g, ""); // YYMMDD
        let birthYear = parseInt(rawBirthDate.substring(0, 2), 10);
        birthYear = birthYear >= 50 ? 1900 + birthYear : 2000 + birthYear;
        let birthMonth = rawBirthDate.substring(2, 4);
        let birthDay = rawBirthDate.substring(4, 6);
        let birthDate = `${birthDay}/${birthMonth}/${birthYear}`;

        // استخراج النوع (M/F)
        let genderChar = lines[1].charAt(20);
        let gender = genderChar === "M" ? "ذكر" : genderChar === "F" ? "انثي" : "غير معروف";

        // حساب العمر
        let today = new Date();
        let age = today.getFullYear() - birthYear;
        if (
            today.getMonth() + 1 < parseInt(birthMonth) ||
            (today.getMonth() + 1 === parseInt(birthMonth) && today.getDate() < parseInt(birthDay))
        ) {
            age--; // تقليل العمر إذا لم يصل الشخص إلى عيد ميلاده بعد هذا العام
        }

        // استخراج تاريخ انتهاء الصلاحية
        let rawExpiryDate = lines[1].substring(21, 27).replace(/</g, ""); // YYMMDD
        let expiryYear = 2000 + parseInt(rawExpiryDate.substring(0, 2), 10);
        let expiryMonth = rawExpiryDate.substring(2, 4);
        let expiryDay = rawExpiryDate.substring(4, 6);
        let expiryDate = `${expiryDay}/${expiryMonth}/${expiryYear}`;

        // استخراج الاسم
        let nameParts = lines[0].substring(5).split("<<");
        let surname = nameParts[0].replace(/</g, " ");
        let givenNames = nameParts[1].replace(/</g, " ");
        let fullName = givenNames + " " + surname;

        // استخراج كود الدولة من آخر رقم في MRZ
        let countryCode = lines[1].slice(-1); // آخر رقم في السطر الثاني من MRZ

        // تعبئة الحقول
        document.getElementById("passport_number").value = passportNumber;
        document.getElementById("full_name").value = fullName;
        document.getElementById("nationality").value = "مصري";
        document.getElementById("dob").value = birthDate;
        document.getElementById("expiry_date").value = expiryDate;
        document.getElementById("age").value = age;
        document.getElementById("eg_code").value = countryCode;
        document.getElementById("gender").value = gender;
        console.log("Birth Date:", birthDate);
        console.log("Gender:", gender);
        console.log("Age:", age);
        console.log("Issue Place:", countryCode);


    }

    // عرض الصورة بعد رفعها
    function previewImage(event) {
        const input = event.target;
        const file = input.files[0];
        const preview = document.getElementById("imagePreview");

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function() {
            let text = this.previousElementSibling.innerText;
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'تم النسخ!',
                    text: text,
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
    });

    // التاريخ والوقت الحالي
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("stepModal").addEventListener("show.bs.modal", function() {
            let now = new Date();
            let year = now.getFullYear();
            let month = String(now.getMonth() + 1).padStart(2, '0');
            let day = String(now.getDate()).padStart(2, '0');
            let hours = String(now.getHours()).padStart(2, '0');
            let minutes = String(now.getMinutes()).padStart(2, '0');

            let currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById("historyDate").value = currentDateTime;
        });
    });
</script>
@stop