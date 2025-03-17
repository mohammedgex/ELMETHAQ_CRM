@extends('adminlte::page')

@section('title', ' العملاء المحتملون')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> العملاء المحتملون</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-ls p-4 border-0" style="border-radius: 15px; background-color: #eae0d5;">
                <form action="" method="POST" class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل عميل محمد سيد</h5>
            </div>
            <div class="modal-body">
                @csrf

                <div class="mb-3">
                    <label class="font-weight-bold"> اسم العميل </label>
                    <input type="text" class="form-control" name="description" placeholder="أدخل اسم العميل..." required>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> الوظيفة المقدم عليها </label>
                    <select class="form-control fw-bold" name="receiving_user_id">
                        <option value=""> سائق</option>
                        <option value="fgfg"> محاسب </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> السن </label>
                    <input type="text" class="form-control" name="description" placeholder="أدخل السن هنا" required>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">  رقم الهاتف </label>
                    <input type="text" class="form-control" name="description" placeholder="أدخل رقم الهاتف" required>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> المندوب </label>
                    <select class="form-control fw-bold" name="receiving_user_id">
                        <option value=""> سائق</option>
                        <option value="fgfg"> محاسب </option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="font-weight-bold"> الرقم القومي </label>
                    <input type="text" class="form-control" name="description" placeholder="أدخل الرقم القومي" required>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> نوع الرخصة </label>
                    <select class="form-control fw-bold" name="receiving_user_id">
                        <option value=""> درجة أولي</option>
                        <option value="fgfg">درجة ثانية</option>
                        <option value="fgfg">درجة ثالثة</option>
                        <option value="fgfg">رخصة خاصة</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> الصورة الشخصية </label>
                    <input type="file" class="form-control-file" name="profile_picture">
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> الحالة </label>
                    <select class="form-control fw-bold" name="receiving_user_id">
                        <option value=""> ناجح بالاختبارات</option>
                        <option value="fgfg">راسب بالاختبارات</option>
                        <option value="fgfg"> اعادة الاختبار </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> موعد التسجيل </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt" style="color:#7c6232;"></i></span>
                        <input type="date" class="form-control" name="description" required>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"> تعديل العميل </button>
                                <button type="submit" class="btn btn-warning"> عودة </button>

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
    /* تنسيق أزرار التصدير */
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

    /* تحسين حقل البحث */
    .dataTables_filter {
        text-align: left !important;
        margin-bottom: 15px;
    }
    .dataTables_filter input {
        width: 250px;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
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