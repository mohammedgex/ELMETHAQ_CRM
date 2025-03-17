@extends('adminlte::page')

@section('title', ' العملاء المحتملون')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> العملاء المحتملون</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0" style="border-radius: 15px; background-color: #eae0d5;">
                <div class="d-flex align-items-center my-3">
                    <button class="btn btn-sm btn-success shadow-sm mx-1" style="height: 40px;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fas fa-user-plus"></i> إضافة كعميل محتمل
                    </button>
                    <input type="text" class="form-control form-control-sm mx-1" placeholder="بحث عن عميل" style="width: 300px;height: 40px;">
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover text-center" id="example">
                        <thead class="text-white" style="background: linear-gradient(45deg, #997a44, #7c6232);">
                            <tr>
                                <th>كود العميل</th>
                                <th>اسم العميل</th>
                                <th>الصورة الشخصية</th>
                                <th> السن</th>
                                <th> الرقم القومي</th>
                                <th> المحافظة</th>
                                <th> رقم الهاتف</th>
                                <th> نوع الرخصة</th>
                                <th> الحالة</th>
                                <th> موعد التسجيل للاختبار</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-light">
                                <td>#1</td>
                                <td> محمد خالد سيد </td>
                                <td>
                                    <img src="https://media.istockphoto.com/id/1317323736/photo/a-view-up-into-the-trees-direction-sky.jpg?s=612x612&w=0&k=20&c=i4HYO7xhao7CkGy7Zc_8XSNX_iqG0vAwNsrH1ERmw2Q=" alt="محمد خالد سيد" width="45" height="45" style="border-radius: 10px;">
                                </td>
                                <td><span class="badge bg-info text-white">50</span></td>
                                <td> 30406152201193 </td>
                                <td> الجيزة </td>
                                <td> 0105187056 </td>
                                <td> درجة ثانية </td>
                                <td><span class="badge bg-info text-success">ناجح</span></td>
                                <td> 15-06 / 12:15 AM</td>
                                <td>
                                     <a href="">
                                    <button class="btn btn-sm btn-outline-success shadow-sms">
                                        <i class="fas fa-edit"></i> تعديل
                                    </button>
                                </a>                                   
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit" >
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                <button class="btn btn-sm btn-outline-primary shadow-sm mx-1" >
                                    <i class="fas fa-users"></i>  عميل اساسي
                                </button>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
       <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة عميل محتمل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fas fa-times-circle text-danger"></i></button>
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
                    <label class="font-weight-bold"> صورة جواز السفر  </label>
                    <input type="file" class="form-control-file" name="profile_picture">
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">  بطاقة الرقم القومي </label>
                    <input type="file" class="form-control-file" name="profile_picture">
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">  صورة الرخصة </label>
                    <input type="file" class="form-control-file" name="profile_picture">
                </div>


                <div class="mb-3">
                    <label class="font-weight-bold"> نوع الاختبار </label>
                    <select class="form-control fw-bold" name="receiving_user_id">
                        <option value=""> اول اختبار</option>
                        <option value="fgfg">اعادة اختبار </option>
                        <option value="fgfg">قيادة امنة </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold"> التقييم </label>
                    <select class="form-control fw-bold" name="receiving_user_id">
                        <option value=""> مقبول </option>
                        <option value="fgfg"> احتياطي </option>
                        <option value="fgfg">  غير مقبول </option>
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
                <button type="submit" class="btn btn-success">اضافة كعميل محتمل</button>
            </div>
        </form>
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