@extends('adminlte::page')

@section('title', 'مستخدمو لوحة التحكم')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">مستخدمو لوحة التحكم</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0" style="border-radius: 15px; background-color: #eae0d5;">
                <div class="d-flex align-items-center my-3">
                    <button class="btn btn-sm btn-success shadow-sm mx-1" style="height: 40px;" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-user-plus"></i> إضافة مستخدم
                    </button>
                    <input type="text" class="form-control form-control-sm mx-1" placeholder="بحث عن مستخدم" style="width: 300px;height: 40px;">
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover text-center" id="usersTable">
                        <thead class="text-white" style="background: linear-gradient(45deg, #997a44, #7c6232);">
                            <tr>
                                <th>كود المستخدم</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الدور</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-light">
                                <td>#1</td>
                                <td>أحمد محمد</td>
                                <td>ahmed@example.com</td>
                                <td><span class="badge bg-info text-white">مدير</span></td>
                                <td><span class="badge bg-success">نشط</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success shadow-sm"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="btn btn-sm btn-outline-danger shadow-sm"><i class="fas fa-trash"></i> حذف</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">إضافة مستخدم جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label class="font-weight-bold">الاسم</label>
                        <input type="text" class="form-control" name="name" placeholder="أدخل اسم المستخدم" required>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">البريد الإلكتروني</label>
                        <input type="email" class="form-control" name="email" placeholder="أدخل البريد الإلكتروني" required>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">كلمة المرور</label>
                        <input type="password" class="form-control" name="password" placeholder="أدخل كلمة المرور" required>
                    </div>
                    <div class="mb-3">
                        <label class="font-weight-bold">الدور</label>
                        <select class="form-control" name="role">
                            <option value="admin">مدير</option>
                            <option value="editor">محرر</option>
                            <option value="user">مستخدم عادي</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">إضافة المستخدم</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .dt-buttons { margin-bottom: 10px; }
    .dt-button { padding: 8px 15px; margin: 5px; font-size: 14px; font-weight: bold; border-radius: 5px; cursor: pointer; }
    .buttons-excel { background-color: #28a745 !important; color: white !important; }
    .buttons-pdf { background-color: #dc3545 !important; color: white !important; }
</style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script>
    $('#usersTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: '<i class="fa fa-file-excel"></i> تصدير إلى Excel', className: 'buttons-excel' },
            { extend: 'print', text: '<i class="fa fa-print"></i> طباعة', className: 'buttons-pdf' }
        ],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json" },
        pageLength: 10,
    });
</script>
@stop