@extends('adminlte::page')

@section('title', 'أنواع المعاملات المالية')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">أنواع المعاملات المالية</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        <div class="col-md-12 mb-4">
            @if ($paymenEdit->title === '')
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">إضافة معاملة مالية جديدة</h4>
                    <form action="{{ route('payment-type.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">نوع المعاملة </label>
                                <input type="text" class="form-control" name="title" placeholder="أدخل نوع المعاملة"
                                    required>
                            </div>
                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #997a44; color: white;">
                            إضافة معاملة مالية جديد
                        </button>
                    </form>
                </div>
            @else
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">إضافة معاملة مالية جديدة</h4>
                    <form action="{{ route('payment-type.edit', $paymenEdit->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">نوع المعاملة </label>
                                <input type="text" class="form-control" name="title" value="{{ $paymenEdit->title }}"
                                    placeholder="أدخل نوع المعاملة" required>
                            </div>
                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #997a44; color: white;">
                            حفظ التعديلات
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #eae0d5;">
                <h4 class="mb-3 text-dark font-weight-bold">قائمة التقييمات</h4>

                <!-- 🔎 مربع البحث والفلترة -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all"> البحث في جميع الحقول</option>
                            <option value="id"> كود المعاملة</option>
                            <option value="name"> نوع المعاملة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder=" أدخل كلمة البحث..."
                            onkeyup="searchTable()">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="delegatesTable">
                        <thead class="text-white"
                            style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">
                            <tr>
                                <th>كود المعاملة</th>
                                <th>نوع المعاملة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr class="table-light">
                                    <td>#{{ $payment->id }}</td>
                                    <td class="highlight">{{ $payment->title }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('payment-type.index', $payment->id) }}">
                                            <button class="btn btn-sm shadow-sm mx-1"
                                                style="border-color: #997a44; color: #997a44;">
                                                <i class="fas fa-edit"></i> تعديل
                                            </button>
                                        </a>
                                        <form action="{{ route('payment-type.delete', $payment->id) }}" method="POST"
                                            class="mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm shadow-sm"
                                                style="border-color: #997a44; color: #997a44;" type="submit">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                        <button class="btn btn-sm shadow-sm mx-1"
                                            style="border-color: #997a44; color: #997a44;">
                                            <i class="fas fa-users"></i> عرض العملاء
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
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
    <script>
        // ✅ كود البحث داخل الجدول
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("delegatesTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                let rowData = rows[i].getElementsByTagName("td");
                let found = false;
                for (let j = 0; j < rowData.length - 1; j++) {
                    if (rowData[j].textContent.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? "" : "none";
            }
        }
    </script>
@stop
