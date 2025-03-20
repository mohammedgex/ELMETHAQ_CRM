@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    <h1>العملاء</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow border-0">
                
                <div class="card-body">
                    <div class="row d-flex justify-content-between">
                        <div class="mb-3 d-flex ">
                            <a href="{{ route('customer.indes') }}">
                                <button class="btn btn-success me-2 mx-2" >اضافة عميل جديد</button>
                            </a>
                            <!-- زر تصفية -->
                            <button class="btn btn-warning" onclick="filterTable()">تصفية</button>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="mb-3 me-2 mx-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    عمليات
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item" onclick="sendSMS('option1')">إرسال إلى فرد</button></li>
                                    <li><button class="dropdown-item" onclick="sendSMS('option2')">إرسال إلى مجموعة</button></li>
                                    <li><button class="dropdown-item" onclick="sendSMS('option3')">إرسال مخصص</button></li>
                                </ul>
                            </div>                            
                            <button class="btn btn-danger" onclick="deleteRows()">حذف المحدد</button>
                        </div>

                        </div>

                            <hr> <!-- Divider -->

                    
                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="example">
                        <thead class="text-white"
                            style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">
                            <tr>
                                <th>
                                    <input type="checkbox" id="checkAll" class="rounded">
                                </th>
                                <th>كود العميل</th>
                                <th>اسم العميل</th>
                                <th> الوظيفة </th>
                                <th>الرقم القومي</th>
                                <th>رقم الهاتف</th>
                                <th>السن</th>
                                 <th>المندوب</th>
                                <th>المجموعة</th>
                                <th>نوع الرخصة</th>
                                <th>نوع التأشيرة</th>
                                <th>الحالة </th>
                                <th>رقم جواز السفر</th>
                                <th>عدد المرفقات</th>
                                <th>عدد المدفوعات</th>  
                                <th>المرحلة</th>
                                <th> تاريخ التسجيل</th>
                                <th>اخر تعديل</th>
                                <th>الرقم القومي</th>
                                <th> الإجراءات</th>

                            </tr>
                        </thead>
                        <tbody>
                                <tr class="table-light">
                                    <td>
                                        <input type="checkbox" id="myCheckbox" class="form-check-input rounded">
                                    </td>
                                    <td>#5</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight"><span class="badge bg-success text-white"> عميل</span></td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight"><a href="#">قطب احمد</a></td>
                                    <td class="highlight"><a href="#">سائقن مجموعة 545</a></td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td class="highlight">لبلبل</td>
                                    <td>
                                                    <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                            href="">
                                                            <i class="fas fa-edit"></i> تصدير العميل اكسيل
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-warning"
                                                            href="">
                                                            <i class="fas fa-edit"></i> طباعة ملف العميل
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-warning"
                                                            href="">
                                                            <i class="fas fa-edit"></i> حجز نت
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-warning"
                                                            href="">
                                                            <i class="fas fa-edit"></i> بيانات التأشيرة
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-warning check-medical-status" href="#" data-mrz="P<EGYABDOU<<FAYEZ<ABDELSATTAR<FAYEZ<<<<<<<<<
                                                        A268118145EGY9005156M2701312<<<<<<<<<<<<<<04">
                                                            <i class="fas fa-edit"></i> نتيجة كشف طبي
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-warning check-medical-hopital" href="#">
                                                            <i class="fas fa-edit"></i> نتيجة وبيانات المستشفي
                                                        </a>
                                                    </li>

                                                    
                                                    <li>
                                                        <button class="dropdown-item text-danger send-sms">
                                                            <i class="fas fa-users"></i> بلاك ليست
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                </div> <!-- End card-body -->
            </div> <!-- End card -->
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
        .content-wrapper{
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
            accent-color: #dc3545; /* لون أحمر */
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
   document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".check-medical-status").forEach(button => {
        button.addEventListener("click", async function (event) {
            event.preventDefault();

            let mrzCode = this.getAttribute("data-mrz");

            try {
                let response = await fetch("http://localhost:3000/check-status", { // Use 127.0.0.1 instead of localhost
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ mrzCode: mrzCode })
                });

                if (!response.ok) throw new Error(`HTTP Error! Status: ${response.status}`);

                let result = await response.json();

                if (result.status === "success") {
                    Swal.fire({
                        title: "تم اصدار نتيجة الكشف الطبي بنجاح",
                        icon: "success",
                        confirmButtonText: "تم",
                        showCancelButton: true,
                        cancelButtonText: "عرض النتيجة",
                        didOpen: () => {
                            const cancelButton = document.querySelector(".swal2-cancel");
                            if (cancelButton) {
                                cancelButton.addEventListener("click", () => {
                                    window.open(result.pdf_url, "_blank"); // Replace with actual PDF link
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

   document.querySelectorAll(".check-medical-hopital").forEach(button => {
    button.addEventListener("click", async function (event) {
        event.preventDefault();

        try {
            // إرسال الطلب لجلب بيانات المستشفى
            let response = await fetch("http://localhost:3000/get-hospital", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ passport: "A23294560", nationality: "Egyptian" })
            });

            if (!response.ok) throw new Error(`HTTP Error! Status: ${response.status}`);

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
                    if (swalResult.dismiss === Swal.DismissReason.cancel) {
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
                recipient: "201222540002",
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
    button.addEventListener("click", async function (event) {
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
                    "address":"sfddfdf",
                    "phone":"5455"
                    })
                });

                let smsResult = await smsResponse.json();

                if (smsResult['status']=='success') {
                    Swal.fire({
                        title: "✅ تم إرسال الرسالة بنجاح",
                        text: "تم إرسال بيانات المستشفى عبر الرسائل القصيرة.",
                        icon: "success",
                        confirmButtonText: "حسناً"
                    });
                } 
                else {
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
     })});


     // check all
      document.getElementById("checkAll").addEventListener("change", function() {
        let checkboxes = document.querySelectorAll(".form-check-input");
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
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
</script>
@stop
