@extends('adminlte::page')

@section('title', 'إدارة بيانات العمال')

@section('content_header')
    <h1>اضافة بيانات عميل</h1>
@stop

@section('content')
<div class="card shadow-lg border-success">
    <div class="card-body">
    <ul class="nav nav-tabs nav-fill">
            <li class="nav-item"><a class="nav-link active" style="color: #997a44;" data-toggle="tab" href="#personalInfo">التفاصيل الشخصية</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-toggle="tab" href="#passportDetails">تفاصيل جواز السفر</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-toggle="tab" href="#attachments">المرفقات</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-toggle="tab" href="#payments">المدفوعات</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab" href="#timelineTab">تقدم العميل</a></li>
        </ul>


        <div class="tab-content mt-3">

    <div id="timelineTab" class="tab-pane fade">
    <h2 class=" text-center">مخطط تقدم العميل</h2>
    <ul class="timeline" id="timeline">
        <li class="timeline-item">
            <span class="timeline-icon step-1"><i class="fas fa-passport"></i></span>
            <div class="timeline-content">
                <h3 class="bold">تسجيل البيانات</h3>
                <p>تم تسجيل البيانات الأساسية</p>
            </div>
        </li>
        <li class="timeline-item">
            <span class="timeline-icon step-2"><i class="fas fa-plane"></i></span>
            <div class="timeline-content">
                <h3>حجز الكشف الطبي</h3>
                <p>تم حجز الكشف الطبي</p>
            </div>
        </li>
        <li class="timeline-item">
            <span class="timeline-icon step-3"><i class="fas fa-file-alt"></i></span>
            <div class="timeline-content">
                <h3> اصدار نتيجة الكشف الطبي</h3>
                <p> النتيجة ناجح </p>
            </div>
        </li>
    </ul>
    <div class="text-center">
        <button class="btn btn-sm mt-3 text-white" style="background-color: #997a44;" id="addStep">إضافة خطوة جديدة</button>
    </div>
</div>
            

                        <!-- التفاصيل الشخصية -->
            <form id="personalInfo" class="tab-pane fade show active" action="{{ route('customer.create') }}" method="Post">
                @csrf
                <!-- القسم: المعلومات الأساسية -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3" >المعلومات الأساسية</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الاسم الكامل</label>
                            <input type="text" class="form-control fw-bold" style="height: 60px; border-color: #997a44;" placeholder="أدخل الاسم الكامل" name="name_ar">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الرقم القومي</label>
                            <input type="text" class="form-control fw-bold" style="height: 60px; border-color: #997a44;" placeholder="أدخل الرقم القومي" name="card_id">
                        </div>
                        
                    </div>
                    <div class="row my-2">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الجنسية</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر الجنسية</option>
                                <option value="A">مصري</option>
                                <option value="B">غير ذلك</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">الحالة الاجتماعية</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر الحالة الاجتماعية</option>
                                <option value="A">أعزب</option>
                                <option value="B">متزوج</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">المحافظة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر المحافظة</option>
                                <option value="A">القاهرة</option>
                                <option value="B"> اسكندرية</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">السن</label>
                            <input type="text" class="form-control fw-bold" style="height: 60px; border-color: #997a44;" placeholder="أدخل العمر" name="card_id">
                        </div>
                    </div>
                    <div class="col-md-12">
                            <label class="fw-bold" style="color: #997a44;"> المؤهل الدراسي</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر المؤهل</option>
                                <option value="A">محو امية</option>
                                <option value="B">مؤهل متوسط</option>
                            </select>
                        </div>
                </div>

                <!-- القسم: البيانات الشخصية -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3" > بيانات الرخصة</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">نوع الرخصة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر الرخصة</option>
                                <option value="A">درجة أولي</option>
                                <option value="B">درجة ثانية</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">رقم الرخصة</label>
                            <input type="text" class="form-control fw-bold" style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الرخصة" name="license_id">
                        </div>
                    </div>
                </div>

                <!-- القسم: معلومات الاتصال -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">معلومات الاتصال</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">رقم الهاتف</label>
                            <input type="text" class="form-control fw-bold" style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الهاتف" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">رقم هاتف آخر</label>
                            <input type="text" class="form-control fw-bold" style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم هاتف آخر" name="phone_two">
                        </div>
                        
                    </div>
                </div>

                <!-- القسم: معلومات العمل -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3" >معلومات العمل</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">اختر المندوب</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;" name="delegate_id">
                                <option value="">اختر المندوب</option>
                                @foreach ($delegates as $delegate )
                                <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">اختر المجموعة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر المجموعة</option>
                                <option value="A">المجموعة A</option>
                                <option value="B">المجموعة B</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                <div class="col-md-6 my-2">
                            <label class="fw-bold" style="color: #997a44;">اختر الوظيفة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">سائق</option>
                                <option value="A">مهندس</option>
                                <option value="B">ميكانيكي</option>
                            </select>
                        </div>
                    <div class="col-md-6 my-2">
                        <label class="fw-bold" style="color: #997a44;">اختر الكفيل</label>
                        <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                            <option value="">البركة التجارية</option>
                            <option value="A">البركة الدولية</option>
                        </select>
                    </div>        
                </div>
                </div>

                 <!-- القسم: بيانات التأشيرة -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">معلومات تأشيرة السفر</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> التأشيرة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر التأشيرة</option>
                                <option value="A">6 شهور سائق</option>
                                <option value="B">تأشيرة مؤقتة</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;">رقم التأشيرة</label>
                            <input type="text" class="form-control fw-bold" style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم التأشيرة" name="visa_id">
                        </div>
                    </div>
                </div>


                <!-- القسم: معلومات إضافية -->
                <div class="section-container">
                    <h4 class="fw-bold mb-3">معلومات إضافية</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> التقييم</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر التقييم</option>
                                <option value="A">مقبول</option>
                                <option value="B">مرفوض</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold" style="color: #997a44;"> الحالة</label>
                            <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر الحالة</option>
                                <option value="A">جديد</option>
                                <option value="B">ناجح</option>
                                <option value="C">تجهيز الاوراق</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                            <label class="fw-bold" style="color: #997a44;"> ملاحظات</label>
                            <textarea class="form-control fw-bold" style="height: 100px; border-color: #997a44;" placeholder="ملاحظات هنا..." name="phone_two"></textarea>
                        </div>
                </div>

                
                <div class="d-flex justify-content-between mt-3">
                    <!-- زر الحفظ -->
                    <button type="submit" class="btn text-white fw-bold" style="background-color: #997a44; width: 50%;">حفظ البيانات</button>

        <!--------------------------------- تظهر فقط عند اضافة المستخدم او التعديل --------------------------------------->
                    <!-- زر الحذف -->
                    <button type="button" class="btn btn-danger fw-bold" style="width: 20%;">حذف</button>

                    <!-- زر الإضافة إلى قائمة الحظر -->
                    <button type="button" class="btn btn-warning fw-bold" style="width: 25%;">إضافة إلى قائمة الحظر</button>
                </div>            
</form>

            <!----------------------------------------------------------------- تفاصيل جواز السفر ------------------------------------------------------------------------------------------------------------->
                    <div id="passportDetails" class="tab-pane fade">
            <div class="table-wrapper">
                <!-- حقل MRZ -->
                <div class="form-group">
                    <label class="fw-bold" style="color: #997a44;" for="mrz_input">أدخل بيانات MRZ</label>
                    <textarea id="mrz_input" class="form-control fw-bold" style="border-color: #997a44;" rows="2" placeholder="ضع هنا منطقة القراءة الآلية من جواز السفر"></textarea>
                </div>

                <!-- زر استخراج البيانات -->
                <button class="btn text-white fw-bold" style="background-color: #997a44;" onclick="extractMRZData()">استخراج البيانات</button>

                <!-- ترتيب الحقول بحيث يكون كل 2 input جنبًا إلى جنب -->
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;" for="full_name">الاسم الكامل علي الجواز</label>
                            <input type="text" id="full_name" class=" form-control fw-bold" style="height: 60px; border-color: #997a44;" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;" for="passport_number">رقم الجواز</label>
                            <input type="text" id="passport_number" class=" form-control fw-bold" style="height: 60px; border-color: #997a44;" readonly>
                        </div>
                    </div>
                    
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;" for="nationality">الجنسية</label>
                            <input type="text" id="nationality" class=" form-control fw-bold" style="height: 60px; border-color: #997a44;" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;" for="dob">تاريخ الميلاد</label>
                            <input type="text" id="dob" class=" form-control fw-bold" style="height: 60px; border-color: #997a44;" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;" for="expiry_date">تاريخ انتهاء الصلاحية</label>
                            <input type="text" id="expiry_date" class=" form-control fw-bold" style="height: 60px; border-color: #997a44;" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;" for="expiry_date">النوع</label>
                            <input type="text" id="expiry_date" class=" form-control fw-bold" style="height: 60px; border-color: #997a44;" readonly>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <!-- زر الحفظ -->
                    <button type="submit" class="btn text-white fw-bold" style="background-color: #997a44; width: 50%;">حفظ البيانات</button>

        <!--------------------------------- تظهر فقط عند اضافة المستخدم او التعديل --------------------------------------->
                    <!-- زر الحذف -->
                    <button type="button" class="btn btn-danger fw-bold" style="width: 20%;">حذف</button>

                    <!-- زر الإضافة إلى قائمة الحظر -->
                    <button type="button" class="btn btn-warning fw-bold" style="width: 25%;">إضافة إلى قائمة الحظر</button>
                </div>
            </div>
        </div>

                        <!-- المرفقات -->
            <div id="attachments" class="tab-pane fade">
                <h4 class="fw-bold">إضافة مرفقات</h4>

                <div class="row">
                    <!-- حقل عنوان المرفق -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-bold" style="color: #997a44;">عنوان المرفق</label>
                            <select id="attachmentTitle" class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
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
                            <input type="file" class="form-control fw-bold" style="border-color: #997a44; height: 60px;" id="attachmentFile">
                        </div>
                    </div>
                </div>

                <!-- زر إضافة مرفق -->
                <button type="button" class="btn text-white fw-bold mt-2" style="background-color: #997a44;" id="addAttachment">إضافة مرفق</button>

                <!-- جدول المرفقات -->
                <table class="table table-bordered mt-3">
                    <thead style="background-color: #997a44; color: white;">
                        <tr>
                            <th>عنوان المرفق</th>
                            <th>المرفق</th>
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
                <div class="col-md-12">
                    <label style="color: #997a44;">عنوان الدفع</label>
                     <select id="paymentTitle" class="form-control fw-bold" style="height: 60px; border-color: #997a44;">
                                <option value="">اختر نوع المعاملة</option>
                                <option value="دفع كشف طبي"> دفع كشف طبي</option>
                                <option value="دفع حجز نت">دفع حجز نت </option>
                                <option value="C">عملة المكتب</option>
                            </select>   
                </div>
                
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label style="color: #997a44;">قيمة الدفع</label>
                    <input type="number" class="form-control " style="border-color: #997a44; height: 60px;" id="paymentAmount" placeholder="أدخل القيمة">
                </div>
                <div class="col-md-6">
                    <label style="color: #997a44;"> المتبقي</label>
                    <input type="number" class="form-control " style="border-color: #997a44; height: 60px;" id="paymentAmount" value="0" placeholder="أدخل المتبقي">
                </div>
                    </div>
                
                <button type="button" class="btn text-white fw-bold mt-2" style="background-color: #997a44;" id="addPayment">إضافة دفعة</button>


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
        .step-1 { background: #28a745; } /* ناجح */
        .step-2 { background: #007bff; } /* قيد التنفيذ */
        .step-3 { background: #ffc107; } /* بانتظار الموافقة */
        .step-4 { background: #dc3545; } /* مرفوض */
        .section-container {
            background: #f8f9fa; /* لون فاتح */
            padding: 20px;
            border-radius: 10px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
            margin-bottom: 20px; /* تباعد بين الأقسام */
        }
        .nav-tabs {
        font-weight: 800 !important;
    }

</style>

@stop

@section('js')
<script>
     document.getElementById('addStep').addEventListener('click', function () {
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
    

    $(document).ready(function () {
         $('.nav-tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // إضافة مرفق جديد
        $("#addAttachment").click(function () {
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
        $(document).on("click", ".removeAttachment", function () {
            $(this).closest("tr").remove();
        });

        // إضافة دفعة جديدة
        $("#addPayment").click(function () {
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
        $(document).on("click", ".removePayment", function () {
            $(this).closest("tr").remove();
        });
    });

    //استخراج بيانات جواز السفر
    function extractMRZData() {
    // let mrz = "P<EGYFARGHAL<<OMAR<MOHAMED<MOHAMED<<<<<<<<<<\nA240842345EGY8702193M2602084<<<<<<<<04";
    let mrz =document.getElementById("mrz_input").value;
    let lines = mrz.split("\n");
    if (lines.length < 2) {
        alert("يرجى إدخال MRZ صالح");
        return;
    }
    let passportNumber = lines[1].substring(0, 9).replace(/</g, "");  // Passport Number
    let nationality = lines[1].substring(10, 13).replace(/</g, "");   // Nationality
    // Extract raw date strings from MRZ
    let rawBirthDate = lines[1].substring(13, 19).replace(/</g, ""); // YYMMDD
    let rawExpiryDate = lines[1].substring(21, 27).replace(/</g, ""); // YYMMDD

    // Determine the century for birth date
    let birthYear = parseInt(rawBirthDate.substring(0, 2), 10);
    birthYear = birthYear >= 50 ? 1900 + birthYear : 2000 + birthYear; // If >= 50, assume 1900s, else 2000s
    let birthMonth = rawBirthDate.substring(2, 4);
    let birthDay = rawBirthDate.substring(4, 6);
    let birthDate = `${birthDay}/${birthMonth}/${birthYear}`; // Format DD/MM/YYYY

    // Determine the century for expiry date (always 2000+)
    let expiryYear = 2000 + parseInt(rawExpiryDate.substring(0, 2), 10);
    let expiryMonth = rawExpiryDate.substring(2, 4);
    let expiryDay = rawExpiryDate.substring(4, 6);
    let expiryDate = `${expiryDay}/${expiryMonth}/${expiryYear}`; // Format DD/MM/YYYY
        let nameParts = lines[0].substring(5).split("<<"); // Extract surname and given names
    let surname = nameParts[0].replace(/</g, " ");
    let givenNames = nameParts[1].replace(/</g, " ");
    let fullName = givenNames + " " + surname;
    
    document.getElementById("passport_number").value = passportNumber;
    document.getElementById("full_name").value = fullName;
    document.getElementById("nationality").value = nationality;
    document.getElementById("dob").value = birthDate;
    document.getElementById("expiry_date").value = expiryDate;
}
</script>
@stop