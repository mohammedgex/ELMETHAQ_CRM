@extends('adminlte::page')

@section('title', 'الاختبارات')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">إدارة الاختبارات</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم الإضافة فقط -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #f8f9fa;">
                <h4 class="mb-3 text-dark font-weight-bold">إضافة اختبار جديد</h4>

                <form action="{{ route('test.create') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">اسم الاختبار</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>

                            @error('title')
                                <div class="text-danger mt-2" style="font-size: 14px;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                        style="background-color: #28a745; color: white;">
                        إضافة
                    </button>
                </form>
            </div>
        </div>

        <!-- ✅ إشعار النجاح -->
        @if (Session::has('success'))
            <script>
                Swal.fire({
                    title: "تم الحفظ بنجاح",
                    icon: "success",
                    confirmButtonText: "تم"
                });
            </script>
        @endif

        <!-- ✅ جدول عرض الاختبارات -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #ccc;">
                <h4 class="mb-3" style="color: #343a40; font-weight: bold;">قائمة الاختبارات</h4>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all">البحث في جميع الحقول</option>
                            <option value="id">كود</option>
                            <option value="name">اسم الاختبار</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder=" أدخل كلمة البحث..."
                            onkeyup="searchTable()">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="testsTable">
                        <thead style="background-color: #343a40; color: white;">
                            <tr>
                                <th>الكود</th>
                                <th>اسم الاختبار</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tests as $test)
                                <tr class="table-light">
                                    <td>#{{ $test->id }}</td>
                                    <td>{{ $test->title }}</td>
                                    <td class="d-flex justify-content-center align-items-center gap-1">
                                        {{-- <form action="{{ route('test.delete', $test->id) }}" method="POST"
                                            onsubmit="confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm"
                                                title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form> --}}
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

        .table-hover tbody tr:hover {
            background-color: #f1ede5;
            transition: 0.3s ease-in-out;
        }

        .btn {
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@stop

@section('js')
    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("testsTable");
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
            event.preventDefault();
            Swal.fire({
                title: "هل أنت متأكد من الحذف؟",
                text: "سيتم حذف الاختبار نهائيًا.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، احذف",
                cancelButtonText: "إلغاء",
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                    Swal.fire({
                        title: "تم الحذف",
                        text: "تم حذف الاختبار بنجاح!",
                        icon: "success",
                        confirmButtonText: "تم"
                    });
                }
            });
        }
    </script>
@stop
