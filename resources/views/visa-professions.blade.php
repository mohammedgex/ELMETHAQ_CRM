@extends('adminlte::page')

@section('title', 'أنواع التأشيرات')

@section('content_header')

    <h1 class="text-success" style="font-weight:bold; text-align:right;"> المهن لتأشيرة برقم صادر (4545454545)</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        <div class="col-md-12 mb-4">
            @if ($visaEdit->profession_count === '')
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold">إضافة مهنة</h4>
                    <form action="{{ route('visa-profession.create', $visa_id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> المهنة </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="job">
                                    <option value="">اختر المهنة بالتأشيرة</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}">{{ $job }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> العدد لهذه المهنة </label>
                                <input type="text" class="form-control" name="profession_count" placeholder="أدخل العدد"
                                    required>
                            </div>
                        </div>
                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #997a44; color: white;">
                            إضافة مهنة للتأشيرة
                        </button>
                    </form>
                </div>
            @else
                <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                    style="border-radius: 15px; background-color: #f8f9fa;">
                    <h4 class="mb-3 text-dark font-weight-bold"> التعديل علي "{{ $visaEdit->job }}"</h4>
                    <form action="{{ route('visa-profession.edit', $visaEdit->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> المهنة </label>
                                <select class="form-control fw-bold" style="border-color: #997a44;" name="job">
                                    <option value="">اختر المهنة بالتأشيرة</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}" {{ $visaEdit->job == $job ? 'selected' : '' }}>
                                            {{ $job }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold"> العدد لهذه المهنة </label>
                                <input type="text" class="form-control" name="profession_count"
                                    value="{{ $visaEdit->profession_count }}" placeholder="أدخل العدد" required>
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
                <h4 class="mb-3 text-dark font-weight-bold">
                    قائمة المهن <span class="text-success">(50 مهنة)</span>
                </h4>

                <!-- 🔎 مربع البحث والفلترة -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all"> البحث في جميع الحقول</option>
                            <option value="id"> كود مدةالتأشيرة</option>
                            <option value="name"> مدة التأشيرة</option>
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
                                <th> المهنة </th>
                                <th> العدد </th>
                                <th> عدد العملاء </th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visas as $visa)
                                <tr class="table-light">
                                    <td>{{ $visa->job }}</td>
                                    <td class="highlight"> <span class="badge bg-info">
                                            {{ $visa->profession_count }}</span>
                                    </td>
                                    <td class="highlight"> <span class="badge bg-success"> 100 عميل</span> </td>
                                    <td>
                                        <a href="{{ route('visa-profession.index', [$visa_id, $visa->id]) }}">
                                            <button class="btn btn-sm btn-outline-success shadow-sms">
                                                <i class="fas fa-edit"></i> تعديل
                                            </button>
                                        </a>
                                        <form action="{{ route('visa-profession.delete', $visa->id) }}" method="POST"
                                            class="mx-1" onsubmit="confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit">
                                                <i class="fas fa-trash"></i> حذف
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> اضافة مهن للتأشيرة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">اغلاق</button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold"> المهنة بالتأشيرة </label>
                        <input type="text" class="form-control" name="name" placeholder="أدخل اسم المهنة"
                            required>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="delegatesTable">
                        <thead class="text-white"
                            style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">
                            <tr>
                                <th> المهنة بالتأشيرة </th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-light">
                                <td>سائق حافلة</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"><i class="fas fa-trash"></i> حذف</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">اضافة</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
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
