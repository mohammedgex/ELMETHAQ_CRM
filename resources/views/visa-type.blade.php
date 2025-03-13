@extends('adminlte::page')

@section('title', 'أنواع التأشيرات')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> تعريف التأشيرات</h1>
@stop

@section('content')
    <div class="row">
        <!-- ✅ قسم إضافة مجموعة -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" style="border-radius: 15px; background-color: #f8f9fa;">
                <h4 class="mb-3 text-dark font-weight-bold">إضافة تأشيرة جديدة</h4>
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold"> العدد </label>
                            <input type="number" class="form-control" name="name" placeholder="أدخل العدد" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold"> رقم الصادر </label>
                            <input type="number" class="form-control" name="name" placeholder="أدخل رقم الصادر" required>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold"> رقم السجل </label>
                            <input type="number" class="form-control" name="name" placeholder="أدخل رقم السجل" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">  مدة التأشيرة </label>
                            <select class="form-control fw-bold" style="border-color: #997a44;">
                                <option value="">اختر المدة</option>
                                <option value="A">3 شهور</option>
                                <option value="B">6 شهور</option>
                                <option value="C">سنة </option>
                            </select>                           
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">  القنصلية </label>
                            <select class="form-control fw-bold" style="border-color: #997a44;">
                                <option value="">اختر الحالة</option>
                                <option value="A">القاهرة</option>
                                <option value="B">السويس</option>
                            </select>                       
                    </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">  الكفيل </label>
                            <select class="form-control fw-bold" style="border-color: #997a44;">
                                <option value="">اختر الكفيل</option>
                                <option value="A">محمد سيد</option>
                                <option value="B">احمد خالد</option>
                            </select>                       
                    </div>
                        
                    </div>

                    
                    <!-- زر بعرض كامل -->
                    <button type="submit" class="btn mt-3 px-4 shadow-sm w-100" style="background-color: #997a44; color: white;">
                        إضافة تأشيرة جديدة
                    </button>
                </form>
            </div>
        </div>

        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn" style="border-radius: 15px; background-color: #eae0d5;">
                <h4 class="mb-3 text-dark font-weight-bold">قائمة التقييمات</h4>

                <!-- 🔎 مربع البحث والفلترة -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all"> البحث في جميع الحقول</option>
                            <option value="id"> كود التأشيرة</option>
                            <option value="name"> نوع التأشيرة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder=" أدخل كلمة البحث..." onkeyup="searchTable()">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="delegatesTable">
                        <thead class="text-white" style="background: linear-gradient(45deg, #997a44, #7c6232); border-radius: 10px;">
                            <tr>
                                <th>كود التأشيرة</th>
                                <th>رقم السجل</th>
                                <th>رقم الصادر</th>
                                <th> أجمالي العدد</th>
                                <th>الكفيل </th>
                                <th> القنصلية</th>
                                <th> عدد المهن</th>
                                <th> عدد العملاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                             <tr class="table-light">
                                <td>#1</td>
                                <td class="highlight"> 658456456465 </td>
                                <td class="highlight"> 864765465 </td>
                                <td class="highlight"> <span class="badge bg-success"> 100 عميل</span> </td>
                                <td class="highlight"> البركة التجارية </td>
                                <td class="highlight"> قنصلية السويس</td>
                                <td class="highlight"> <span class="badge bg-info">3 مهن</span> </td>
                                <td class="highlight"> <span class="badge bg-primary">50 عميل</span> </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success shadow-sm"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"><i class="fas fa-trash"></i> حذف</button>
                                    <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-success">
                                                <i class="fas fa-edit"></i>  المهن
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-primary">
                                                <i class="fas fa-edit"></i>  العملاء
                                            </a>
                                        </li>                                        <li>
                                            <a class="dropdown-item text-warning">
                                                <i class="fas fa-edit"></i> طباعة تقرير
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger">
                                                <i class="fas fa-users"></i> بلاك ليست
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                            
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
    .table-responsive{
        overflow: visible !important;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
