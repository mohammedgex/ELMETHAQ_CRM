@extends('adminlte::page')

@section('title', 'تعريف التققيمات')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تعريف التقييمات</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        <div class="col-md-12 mb-4">
            @if ($evaluationEdit->title === '')
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">إضافة تقييم جديدة</h4>
                    <form action="{{ route('evaluation.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">اسم التقييم</label>
                                <input type="text" class="form-control" name="title" placeholder="أدخل اسم التقييم"
                                    required>
                            </div>
                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #997a44; color: white;">
                            إضافة تقييم جديدة
                        </button>
                    </form>
                </div>
            @else
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">التعديل علي "{{ $evaluationEdit->title }}"</h4>
                    <form action="{{ route('evaluation.edit', $evaluationEdit->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">اسم التقييم</label>
                                <input type="text" class="form-control" name="title"
                                    value="{{ $evaluationEdit->title }}" placeholder="أدخل اسم التقييم" required>
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

         @if (Session::has('success'))
        <script>
                Swal.fire({
                title: "{{Session::get('success')}}",
                icon: "success",
                  confirmButtonText: "تم",
                draggable: true
                });
            </script>
        
        @endif

        @if (Session::has('edit_success'))
        <script>
                Swal.fire({
                title: "تم تعديل '{{Session::get('edit_success')}}' بنجاح",
                icon: "success",
                  confirmButtonText: "تم",
                draggable: true
                });
            </script>
        
        @endif

        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #eae0d5;">
                <h4 class="mb-3 text-dark font-weight-bold">قائمة التقييمات <span class="text-success">({{ $evaluations->count() }})</span></h4>

                <!-- 🔎 مربع البحث والفلترة -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all"> البحث في جميع الحقول</option>
                            <option value="id"> كود التقييم</option>
                            <option value="name"> اسم التقييم</option>
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
                                <th>كود التقييم</th>
                                <th>اسم التقييم</th>
                                <th>عدد العملاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evaluations as $evaluation)
                                <tr class="table-light">
                                    <td>#{{ $evaluation->id }}</td>
                                    <td class="highlight">{{ $evaluation->title }}</td>
                                    <td class="highlight"><span class="badge bg-success text-white">{{$evaluation->customers->count()}} عميل</span></td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('evaluation.index', $evaluation->id) }}">
                                            <button class="btn btn-sm shadow-sm mx-1"
                                                style="border-color: #997a44; color: #997a44;">
                                                <i class="fas fa-edit"></i> تعديل
                                            </button>
                                        </a>
                                        <form action="{{ route('evaluation.delete', $evaluation->id) }}" method="POST"
                                            class="mx-1" onsubmit="confirmDelete(event)">
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
