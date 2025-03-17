@extends('adminlte::page')

@section('title', ' العملاء المحتملون')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> تعديل العميل ()</h1>
@stop

@section('content')
    <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" 
    style="border-radius: 15px; background-color: #f8f9fa;">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- اسم العميل -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> اسم العميل </label>
                <input type="text" class="form-control" name="name" placeholder="أدخل اسم العميل..." required>
            </div>

            <!-- الوظيفة المقدم عليها -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> الوظيفة المقدم عليها </label>
                <select class="form-control fw-bold" name="job_title_id">
                    <option value=""> اختر الوظيفة</option>
                   
                    <option value="سبلبل"> لبلب</option>
                </select>
            </div>

            <!-- السن -->
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold"> السن </label>
                <input type="number" class="form-control" name="age" placeholder="أدخل السن" required>
            </div>

            <!-- رقم الهاتف -->
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold"> رقم الهاتف </label>
                <input type="text" class="form-control" name="phone" placeholder="أدخل رقم الهاتف" required>
            </div>

            <!-- الرقم القومي -->
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold"> الرقم القومي </label>
                <input type="text" class="form-control" name="card_id" placeholder="أدخل الرقم القومي" required>
            </div>

            <!-- المندوب -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> المندوب </label>
                <select class="form-control fw-bold" name="delegate_id">
                    <option value=""> اختر المندوب</option>
                   
                    <option value="بلالا"> الال</option>
                </select>
            </div>

            <!-- نوع الرخصة -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> نوع الرخصة </label>
                <select class="form-control fw-bold" name="licence_type">
                    <option value="">اختر نوع الرخصة</option>
                    <option value="درجة أولي"> درجة أولي</option>
                    <option value="درجة ثانية">درجة ثانية</option>
                    <option value="درجة ثالثة">درجة ثالثة</option>
                    <option value="رخصة خاصة">رخصة خاصة</option>
                </select>
            </div>
           <section class="card shadow-sm p-4 border-0 mt-4" style="border-radius: 15px; background-color: #ffffff;">
                <h4 class="mb-3 text-dark font-weight-bold text-center"> تحميل الملفات</h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="font-weight-bold"> الصورة الشخصية</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="font-weight-bold"> صورة جواز السفر</label>
                            <input type="file" class="form-control" name="passport_photo">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="font-weight-bold"> بطاقة الرقم القومي</label>
                            <input type="file" class="form-control" name="img_national_id_card">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="font-weight-bold"> صورة الرخصة</label>
                            <input type="file" class="form-control" name="license_photo">
                        </div>
                    </div>
                </div>
            </section>

            <!-- نوع الاختبار -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> نوع الاختبار </label>
                <select class="form-control fw-bold" name="test_type">
                    <option value="">اختر نوع الاختبار </option>
                    <option value="اول اختبار"> اول اختبار</option>
                    <option value="اعادة اختبار">اعادة اختبار </option>
                    <option value="قيادة امنة">قيادة امنة </option>
                </select>
            </div>

            <!-- التقييم -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> التقييم </label>
                <select class="form-control fw-bold" name="evaluation">
                    <option value="">اختر التقييم </option>
                    <option value="مقبول"> مقبول </option>
                    <option value="احتياطي"> احتياطي </option>
                    <option value="غير مقبول"> غير مقبول </option>
                </select>
            </div>

            <!-- المحافظة -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> المحافظة </label>
                <select class="form-control fw-bold" name="governorate">
                    <option value="">اختر المحافظة</option>
                    <option value="القاهرة">القاهرة</option>
                    <option value="الجيزة">الجيزة</option>
                    <option value="الإسكندرية">الإسكندرية</option>
                    <option value="الدقهلية">الدقهلية</option>
                    <option value="البحر الأحمر">البحر الأحمر</option>
                    <option value="البحيرة">البحيرة</option>
                    <option value="الفيوم">الفيوم</option>
                    <option value="الغربية">الغربية</option>
                    <option value="الإسماعيلية">الإسماعيلية</option>
                    <option value="كفر الشيخ">كفر الشيخ</option>
                    <option value="المنوفية">المنوفية</option>
                    <option value="المنيا">المنيا</option>
                    <option value="القليوبية">القليوبية</option>
                    <option value="الوادي الجديد">الوادي الجديد</option>
                    <option value="السويس">السويس</option>
                    <option value="أسوان">أسوان</option>
                    <option value="أسيوط">أسيوط</option>
                    <option value="بني سويف">بني سويف</option>
                    <option value="بورسعيد">بورسعيد</option>
                    <option value="دمياط">دمياط</option>
                    <option value="جنوب سيناء">جنوب سيناء</option>
                    <option value="شمال سيناء">شمال سيناء</option>
                    <option value="الشرقية">الشرقية</option>
                    <option value="سوهاج">سوهاج</option>
                    <option value="قنا">قنا</option>
                    <option value="مطروح">مطروح</option>
                    <option value="الأقصر">الأقصر</option>
                    <option value="حلوان">حلوان</option>
                    <option value="6 أكتوبر">6 أكتوبر</option>
                </select>
            </div>

            <!-- موعد التسجيل -->
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold"> موعد التسجيل </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-alt" style="color:#7c6232;"></i></span>
                    <input type="date" class="form-control" name="registration_date" required>
                </div>
            </div>
        </div>

        <!-- زر الإضافة -->
        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100" 
            style="background-color: #997a44; color: white;">
            إضافة كعميل محتمل
        </button>
    </form>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .dt-buttons {
        margin-bottom: 10px;
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
    .dataTables_filter {
        text-align: left !important;
        margin-bottom: 15px;
    }
    .dataTables_filter input {
        width: 250px;
    }
      /* ✅ تحسين إدخال البيانات */
        .form-control {
            border-radius: 10px;
            padding: 12px;
            height: 50px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #997a44;
            box-shadow: 0 0 8px rgba(153, 122, 68, 0.3);
        }

        /* ✅ تحسين الجدول */
        .table-hover tbody tr:hover {
            background-color: #f1ede5;
            transition: 0.3s ease-in-out;
        }

        /* ✅ تحسين الأزرار */
        .btn {
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* ✅ تحسين تقسيم الأقسام */
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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
        $('#example').DataTable({
        dom: 'Bfrtip', // تخصيص ترتيب العناصر
        buttons: [
            {
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
                customize: function (win) {
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
        searching:false,
        pageLength: 10,
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "الكل"] ],
    });
        </script>

@stop