@extends('adminlte::page')

@section('title', 'إدارة المستخدمين')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-4 pt-3">
            <div class="col-sm-6">
                <h1 class="font-weight-bold page-main-title">إدارة المستخدمين</h1>
                <p class="text-muted small">يمكنك إضافة، تعديل ومراقبة صلاحيات المستخدمين من هنا.</p>
            </div>
            <div class="col-sm-6 text-left d-flex align-items-center justify-content-end">
                <a href="{{ route('user.index') }}"
                    class="btn btn-primary-gradient px-4 py-2 shadow-lg rounded-pill d-inline-flex align-items-center justify-content-center">
                    <i class="fas fa-plus-circle ml-2"></i>
                    <span>إضافة مستخدم جديد</span>
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card main-table-card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-borderless table-hover mb-0 custom-modern-table" id="usersTable">
                    <thead>
                        <tr>
                            <th>المستخدم</th>
                            <th>البريد الإلكتروني</th>
                            <th>المستوى</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle mr-3 bg-soft-primary text-primary">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('users.history', $user->id) }}" class="user-name-link">
                                                {{ $user->name ?? 'غير معروف' }}
                                            </a>
                                            <div class="small text-muted">ID: #{{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-muted">{{ $user->email }}</td>
                                <td class="align-middle">
                                    <span class="modern-badge badge-{{ $user->role }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-sm"
                                            data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                            <a class="dropdown-item" href="{{ route('user.permissions', $user->id) }}">
                                                <i class="fas fa-shield-alt text-success mr-2"></i> الصلاحيات
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('user.changePasswordUser', $user->id) }}">
                                                <i class="fas fa-edit text-info mr-2"></i> تعديل البيانات
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 modern-modal">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">مستخدم جديد</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label class="small font-weight-bold">الاسم الكامل</label>
                            <input type="text" class="form-control modern-input" name="name"
                                placeholder="مثال: أحمد محمد" required>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">البريد الإلكتروني</label>
                            <input type="email" class="form-control modern-input" name="email"
                                placeholder="email@example.com" required>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">كلمة المرور</label>
                            <input type="password" class="form-control modern-input" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 rounded-lg shadow">تأكيد
                            الإضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* المتغيرات والأساسيات */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --soft-primary: #eef2ff;
        }

        body {
            background-color: #f8fafc;
            color: #334155;
        }

        .dark-mode body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        /* تحسين شكل الكارد */
        .main-table-card {
            border-radius: 20px !important;
            transition: all 0.3s ease;
        }

        .dark-mode .main-table-card {
            background: #1e293b !important;
        }

        /* ستايل الجدول العصري */
        .custom-modern-table thead th {
            background-color: #f1f5f9;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 20px;
            border: none;
        }

        .dark-mode .custom-modern-table thead th {
            background-color: #334155;
            color: #94a3b8;
        }

        .custom-modern-table tbody td {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: 0.2s;
        }

        .dark-mode .custom-modern-table tbody td {
            border-bottom: 1px solid #334155;
        }

        .custom-modern-table tbody tr:hover td {
            background-color: rgba(102, 126, 234, 0.03);
            cursor: pointer;
        }

        /* الأفاتار الصغير */
        .avatar-circle {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .bg-soft-primary {
            background: var(--soft-primary);
        }

        /* اسم المستخدم */
        .user-name-link {
            font-weight: 600;
            color: #1e293b;
            transition: 0.2s;
        }

        .dark-mode .user-name-link {
            color: #f1f5f9;
        }

        .user-name-link:hover {
            color: #667eea;
            text-decoration: none;
        }

        /* البادج العصري */
        .modern-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-admin {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-editor {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-user {
            background: #dcfce7;
            color: #16a34a;
        }

        /* زر التدرج اللوني */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            transition: 0.3s;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            opacity: 0.9;
            color: white;
        }

        /* المدخلات (Inputs) */
        .modern-input {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
            transition: 0.3s;
        }

        .modern-input:focus {
            background: #fff;
            border-color: #667eea;
            box-shadow: none;
        }

        .dark-mode .modern-input {
            background: #334155;
            border-color: #475569;
            color: #fff;
        }

        .modern-modal {
            border-radius: 25px;
        }

        .dark-mode .modern-modal {
            background: #1e293b;
            color: #fff;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                dom: '<"p-3 d-flex justify-content-between align-items-center"fB>rt<"p-3"p>',
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-sm btn-outline-success mx-1 rounded-pill'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-outline-dark mx-1 rounded-pill'
                    }
                ]
            });
        });
    </script>
@stop
