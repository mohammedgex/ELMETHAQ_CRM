@extends('adminlte::page')

@section('title', 'الكفلاء')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">الكفلاء</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة كفيل -->
        <div class="col-md-12 mb-4">
            @if ($sponserEdit->name === '')
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">إضافة كفيل جديد</h4>
                    <form action="{{ route('sponsor.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">اسم الكفيل</label>
                                <input type="text" class="form-control" name="name" placeholder="أدخل اسم الكفيل"
                                    required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">رقم هاتف الكفيل</label>
                                <input type="text" class="form-control" name="phone" placeholder="أدخل اسم الكفيل"
                                    required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">دولة الكفيل</label>
                                <input type="text" class="form-control" name="city" placeholder="أدخل اسم الكفيل"
                                    required>
                            </div>
                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #997a44; color: white;">
                            إضافة كفيل جديد
                        </button>
                    </form>
                </div>
            @else
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">التعديل علي "{{ $sponserEdit->name }}"</h4>
                    <form action="{{ route('sponsor.edit', $sponserEdit->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">اسم الكفيل</label>
                                <input type="text" class="form-control" name="name" value="{{ $sponserEdit->name }}"
                                    placeholder="أدخل اسم الكفيل" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">رقم هاتف الكفيل</label>
                                <input type="text" class="form-control" name="phone" value="{{ $sponserEdit->phone }}"
                                    placeholder="أدخل اسم الكفيل" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">دولة الكفيل</label>
                                <input type="text" class="form-control" name="city" value="{{ $sponserEdit->city }}"
                                    placeholder="أدخل اسم الكفيل" required>
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

        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #eae0d5;">
                <h4 class="mb-3 text-dark font-weight-bold">
                    قائمة الكفلاء <span class="text-success"> ({{ $sponsers->count() }})</span>
                </h4>

                <!-- 🔎 مربع البحث والفلترة -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all"> البحث في جميع الحقول</option>
                            <option value="id"> كود الكفيل</option>
                            <option value="name"> اسم الكفيل</option>
                            <option value="name"> دولة الكفيل</option>
                            <option value="name"> رقم هاتف الكفيل</option>


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
                                <th>كود الكفيل</th>
                                <th>اسم الكفيل</th>
                                <th>دولة الكفيل</th>
                                <th>رقم هاتف الكفيل</th>
                                <th> عدد تأشيرات الكفيل</th>
                                <th>عدد عملاء الكفيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sponsers as $sponser)
                                <tr class="table-light">
                                    <td>{{ $sponser->id }}</td>
                                    <td class="highlight">{{ $sponser->name }}</td>
                                    <td class="highlight">{{ $sponser->phone }}</td>
                                    <td class="highlight">{{ $sponser->city }}</td>
                                    <td class="highlight"><span class="badge bg-warning">{{ count($sponser->visas) }}
                                            تأشيرات</span> </td>
                                    <td class="highlight">
                                        <form action="{{ route('customers.filter') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="sponser_id" value="{{ $sponser->id }}">
                                            <button type="submit" class="badge bg-success">
                                                {{ count($sponser->customers) }}
                                                عميل
                                            </button>
                                        </form>
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('sponsor.index', $sponser->id) }}">
                                            <button class="btn btn-sm btn-outline-success shadow-sms">
                                                <i class="fas fa-edit"></i> تعديل
                                            </button>
                                        </a>
                                        <form action="{{ route('sponsor.delete', $sponser->id) }}" method="POST"
                                            class="mx-1" onsubmit="confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger shadow-sm">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                        <form action="{{ route('customers.filter') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="sponser_id" value="{{ $sponser->id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary shadow-sm mx-1">
                                                <i class="fas fa-users"></i> عرض العملاء
                                            </button>
                                        </form>
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
