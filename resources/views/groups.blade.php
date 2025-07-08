@extends('adminlte::page')

@section('title', 'المجموعات')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">المجموعات</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        @if ($groupEdit->title === '')
            <div class="col-md-12 mb-4">
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">إضافة مجموعة جديدة</h4>
                    <form action="{{ route('customer-groups.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">اسم المجموعة</label>
                                <input type="text" class="form-control" name="title" placeholder="أدخل اسم المجموعة"
                                    required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">التاشيرة</label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="visa_type_id">
                                    <option value="">اختر التاشيرة</option>
                                    @foreach ($visas as $visa)
                                        <option value="{{ $visa->id }}">{{ $visa->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #28a745; color: white;">
                            إضافة مجموعة جديدة
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="col-md-12 mb-4">
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">التعديل علي "{{ $groupEdit->title }}"</h4>
                    <form action="{{ route('customer-groups.edit', $groupEdit->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">اسم المجموعة</label>
                                <input type="text" class="form-control" name="title" value="{{ $groupEdit->title }}"
                                    placeholder="أدخل اسم المجموعة" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">التاشيرة</label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="visa_type_id">
                                    <option value="">اختر التاشيرة</option>
                                    @foreach ($visas as $visa)
                                        <option value="{{ $visa->id }}"
                                            {{ old('visa_type_id', $groupEdit->visa_type_id ?? '') == $visa->id ? 'selected' : '' }}>
                                            {{ $visa->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #28a745; color: white;">
                            حفظ التعديلات
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #ccc;">
                <h4 class="mb-3" style="color: #343a40; font-weight: bold;">قائمة المجموعات</h4>

                <!-- 🔎 Search and Filter Box -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all">البحث في جميع الحقول</option>
                            <option value="id">كود المجموعة</option>
                            <option value="name">اسم المجموعة</option>
                            <option value="visa">نوع التأشيرة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder="أدخل كلمة البحث..."
                            onkeyup="searchTable()">
                    </div>
                </div>

                @if (Session::has('success'))
                    <script>
                        Swal.fire({
                            title: "{{ Session::get('success') }}",
                            icon: "success",
                            confirmButtonText: "تم",
                            draggable: true
                        });
                    </script>
                @endif

                @if (Session::has('edit_success'))
                    <script>
                        Swal.fire({
                            title: "تم تعديل '{{ Session::get('edit_success') }}' بنجاح",
                            icon: "success",
                            confirmButtonText: "تم",
                            draggable: true
                        });
                    </script>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="delegatesTable">
                        <thead style="background-color: #343a40; color: white;">
                            <tr>
                                <th>كود المجموعة</th>
                                <th>اسم المجموعة</th>
                                <th>نوع التأشيرة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr class="table-light">
                                    <td>#{{ $group->id }}</td>
                                    <td>{{ $group->title }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $group->visaType->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center gap-1">
                                        <a href="{{ route('customer-groups.index', $group->id) }}"
                                            class="btn btn-sm btn-outline-success shadow-sm" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('customer-groups.delete', $group->id) }}" method="POST"
                                            class="mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit"
                                                title="حذف" onsubmit="confirmDelete(event)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('customers.filter') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="customer_group_id" value="{{ $group->id }}">
                                            <button class="btn btn-sm btn-outline-primary shadow-sm" title="عرض العملاء">
                                                <i class="fas fa-users"></i>
                                            </button>
                                        </form>

                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item text-primary"
                                                        href="{{ route('customer-groups.index', $group->id) }}">
                                                        <i class="fas fa-info-circle"></i> التفاصيل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-warning" href="#">
                                                        <i class="fas fa-print"></i> طباعة التقرير
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-success" href="#">
                                                        <i class="fas fa-file-export"></i> تصدير البيانات
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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

        function confirmDelete(event) {
            event.preventDefault(); // Prevent form submission
            Swal.fire({
                title: "هل أنت متأكد من الحذف؟",
                text: "سيتم حذف البيانات بالكامل ، هل أنت متأكد ؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "حذف",
                cancelButtonText: "الغاء",
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Submit the form if confirmed
                    Swal.fire({
                        title: "تم الحذف",
                        text: "تم الحذف بنجاح!",
                        confirmButtonText: "تم",
                        icon: "success"
                    });
                }
            });
        }
    </script>
@stop
