@extends('adminlte::page')

@section('title', 'إدارة بيانات العمال')

@section('content_header')
    <h1>إدارة بيانات العمال</h1>
@stop

@section('content')
<div class="card shadow-lg border-success">
    <div class="card-body">
                <ul class="nav nav-tabs nav-fill" >
    <li class="nav-item"><a class="nav-link active text-success" data-toggle="tab" href="#personalInfo">التفاصيل الشخصية</a></li>
    <li class="nav-item"><a class="nav-link text-success" data-toggle="tab" href="#passportDetails">تفاصيل جواز السفر</a></li>
    <li class="nav-item"><a class="nav-link text-success" data-toggle="tab" href="#attachments">المرفقات</a></li>
    <li class="nav-item"><a class="nav-link text-success" data-toggle="tab" href="#payments">المدفوعات</a></li>
        <li class="nav-item"><a class="nav-link text-success" data-bs-toggle="tab" href="#timelineTab">تقدم العميل</a></li>

</ul>


        <div class="tab-content mt-3">

              <div id="timelineTab" class="tab-pane fade">
     <h2 class="text-success text-center">مخطط تقدم العميل</h2>
    <ul class="timeline" id="timeline">
        <li class="timeline-item">
            <span class="timeline-icon step-1"><i class="fas fa-passport"></i></span>
            <div class="timeline-content">
                <h3>تسجيل البيانات</h3>
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
        <button class="btn btn-success btn-sm mt-3" id="addStep">إضافة خطوة جديدة</button>
    </div>
</div>
            

            <!-- <form action="{{ route('customer.create') }}" method="Post">
                @csrf -->
                <!-- التفاصيل الشخصية -->
            <form id="personalInfo" class="tab-pane fade show active" action="{{ route('customer.create') }}" method="Post">
                @csrf
                        <!-- القسم: المعلومات الأساسية -->
    <div class="section-container">
        <h5 class="text-success fw-bold mb-3">المعلومات الأساسية</h5>
        <div class="row">
            <div class="col-md-6">
                <label class="fw-bold text-success ">الاسم الكامل</label>
                <input type="text" class="form-control border-success bold-input" style="height: 60px;" placeholder="أدخل الاسم الكامل" name="name_ar">
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-success">رقم الهاتف</label>
                <input type="text" class="form-control border-success fw-bold" style="height: 60px;" placeholder="أدخل رقم الهاتف" name="phone">
            </div>
        </div>
    </div>

    <!-- القسم: البيانات الشخصية -->
    <div class="section-container">
        <h5 class="text-success fw-bold mb-3">البيانات الشخصية</h5>
        <div class="row">
            <div class="col-md-6">
                <label class="fw-bold text-success">الرقم القومي</label>
                <input type="text" class="form-control border-success fw-bold" style="height: 60px;" placeholder="أدخل الرقم القومي" name="card_id">
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-success">رقم الرخصة</label>
                <input type="text" class="form-control border-success fw-bold" style="height: 60px;" placeholder="أدخل رقم الرخصة" name="license_id">
            </div>
        </div>
    </div>

    <!-- القسم: معلومات الاتصال -->
    <div class="section-container">
        <h5 class="text-success fw-bold mb-3">معلومات الاتصال</h5>
        <div class="row">
            <div class="col-md-6">
                <label class="fw-bold text-success">رقم هاتف آخر</label>
                <input type="text" class="form-control border-success fw-bold" style="height: 60px;" placeholder="أدخل رقم هاتف آخر" name="phone_two">
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-success">رقم التأشيرة</label>
                <input type="text" class="form-control border-success fw-bold" style="height: 60px;" placeholder="أدخل رقم التأشيرة" name="visa_id">
            </div>
        </div>
    </div>

    <!-- القسم: معلومات العمل -->
    <div class="section-container">
        <h5 class="text-success fw-bold mb-3">معلومات العمل</h5>
        <div class="row">
            <div class="col-md-6">
                <label class="fw-bold text-success">اختر المندوب</label>
                <select class="form-control border-success fw-bold" style="height: 60px;" name="delegate_id">
                    <option value="">اختر المندوب</option>
                    @foreach ($delegates as $delegate )
                    <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-success">اختر المجموعة</label>
                <select class="form-control border-success fw-bold" style="height: 60px;" >
                    <option value="">اختر المجموعة</option>
                    <option value="A">المجموعة A</option>
                    <option value="B">المجموعة B</option>
                </select>
            </div>
        </div>
    </div>

    <!-- القسم: معلومات إضافية -->
    <div class="section-container">
        <h5 class="text-success fw-bold mb-3">معلومات إضافية</h5>
        <div class="row">
            <div class="col-md-6">
                <label class="fw-bold text-success">المؤهل الدراسي</label>
                <input type="text" class="form-control border-success fw-bold" style="height: 60px;" placeholder="أدخل المؤهل الدراسي">
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-success">التقييم</label>
                <input type="number" class="form-control border-success fw-bold" style="height: 60px;" placeholder="أدخل التقييم" min="1" max="10">
            </div>
        </div>
    </div>
    <input class="btn btn-success btn-block mt-3" type="submit" value="حفظ البيانات"/>
</form>

        

            <!-- </form> -->


            <!-- تفاصيل جواز السفر -->
            <div id="passportDetails" class="tab-pane fade">
                <div class="table-wrapper">
                    <div class="form-group">
                        <label class="text-success" for="mrz_input">أدخل بيانات MRZ:</label>
                        <textarea id="mrz_input" class="form-control border-success" rows="2" placeholder="ضع هنا منطقة القراءة الآلية من جواز السفر"></textarea>
                    </div>
                    <button class="btn btn-success" onclick="extractMRZData()">استخراج البيانات</button>

                    <div class="form-group">
                        <label class="text-success" for="passport_number">رقم الجواز:</label>
                        <input type="text" id="passport_number" class="form-control border-success" readonly>
                    </div>
                    <div class="form-group">
                        <label class="text-success" for="full_name">الاسم الكامل:</label>
                        <input type="text" id="full_name" class="form-control border-success" readonly>
                    </div>
                    <div class="form-group">
                        <label class="text-success" for="nationality">الجنسية:</label>
                        <input type="text" id="nationality" class="form-control border-success" readonly>
                    </div>
                    <div class="form-group">
                        <label class="text-success" for="dob">تاريخ الميلاد:</label>
                        <input type="text" id="dob" class="form-control border-success" readonly>
                    </div>
                    <div class="form-group">
                        <label class="text-success" for="expiry_date">تاريخ انتهاء الصلاحية:</label>
                        <input type="text" id="expiry_date" class="form-control border-success" readonly>
                    </div>
                </div>
            </div>

            <!-- المرفقات -->
            <div id="attachments" class="tab-pane fade">
                <h5 class="text-success">إضافة مرفقات</h5>
                <div class="form-group">
                    <label class="text-success">عنوان المرفق</label>
                    <input type="text" class="form-control border-success" id="attachmentTitle" placeholder="مثال: صورة الجواز">
                </div>
                <div class="form-group">
                    <label class="text-success">رفع المرفق</label>
                    <input type="file" class="form-control border-success" id="attachmentFile">
                </div>
                <button type="button" class="btn btn-success btn-sm" id="addAttachment">إضافة مرفق</button>

                <table class="table table-bordered mt-3">
                    <thead class="table-success">
                        <tr>
                            <th>عنوان المرفق</th>
                            <th>المرفق</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="attachmentTable">
                    </tbody>
                </table>
            </div>

            <!-- المدفوعات -->
            <div id="payments" class="tab-pane fade">
                <h5 class="text-success">إضافة مدفوعات</h5>
                <div class="row">
                <div class="col-md-6">
                    <label class="text-success">عنوان الدفع</label>
                    <input type="text" class="form-control border-success" id="paymentTitle" placeholder="مثال: دفعة أولى">
                </div>
                <div class="col-md-6">
                    <label class="text-success">قيمة الدفع</label>
                    <input type="number" class="form-control border-success" id="paymentAmount" placeholder="أدخل المبلغ">
                </div>
                </div>
                
                <button type="button" class="btn btn-success btn-sm" id="addPayment">إضافة دفعة</button>

                <table class="table table-bordered mt-3">
                    <thead class="table-success">
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
        .nav {
        font-weight: 800 !important;
        /* font-size: 18px !important; */
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

            var newRow = `
                <tr>
                    <td>${title}</td>
                    <td>${fileName}</td>
                    <td>
                        <button class="btn btn-danger btn-sm removeAttachment"><i class="fa fa-trash"></i></button>
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
                    <td>${amount}</td>
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

    // let passportNumber = lines[0].substring(44, 53).replace(/</g, "");
    // let nationality = lines[0].substring(54, 57).replace(/</g, "");
    // let birthDate = lines[1].substring(13, 19).replace(/</g, "");
    // let expiryDate = lines[1].substring(21, 27).replace(/</g, "");
    // let nameParts = lines[1].substring(60).split("<<");
    // let fullName = nameParts.reverse().join(" ").replace(/</g, " ");
    
    document.getElementById("passport_number").value = passportNumber;
    document.getElementById("full_name").value = fullName;
    document.getElementById("nationality").value = nationality;
    document.getElementById("dob").value = birthDate;
    document.getElementById("expiry_date").value = expiryDate;
}
</script>
@stop