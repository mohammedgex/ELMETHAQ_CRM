@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    <h1>العملاء</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header text-white text-center" 
                     style="background: linear-gradient(to right, #997A44, #7A5E33); font-size: 1.2rem;">
                    جدول بيانات العملاء
                </div>
                
                <div class="card-body">
                    <div class="row d-flex justify-content-between">
                        <!-- حقل البحث -->
                                                <!-- 📌 فلتر متقدم -->
                        <div class="mb-3 d-flex ">
                            <!-- القائمة الأولى لاختيار الفئة -->
                            <select id="filterType" class="form-select me-2 mx-2" onchange="updateFilterValues()">
                                <option value="all">🔍 البحث في الكل</option>
                                <option value="name">الاسم</option>
                                <option value="phone">رقم الهاتف</option>
                            </select>

                            <!-- القائمة الثانية لتحديد القيمة بناءً على الأولى -->
                            <select id="filterValues" class="form-select me-2 mx-2">
                                <option value="">-- اختر --</option>
                            </select>
                            
                            <!-- زر تصفية -->
                            <button class="btn btn-warning" onclick="filterTable()">تصفية</button>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="mb-3">
                            <button class="btn btn-success" onclick="sendSMS()">📩 إرسال SMS</button>
                            <button class="btn btn-danger" onclick="deleteRows()">🗑️ حذف المحدد</button>
                        </div>

                        </div>
                    
                    <table id="dataTable" class="table table-bordered table-hover text-center" style="border-radius: 10px; overflow: hidden;">
                        <thead class="table-dark">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>رقم الجواز</th>
                                <th>الرقم القومي</th>
                                <th>العمر</th>
                                <th>المندوب</th>
                                <th>المحافظة</th>
                                <th>المرفقات</th>
                                <th>المدفوعات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $customers = [
                                    ['id' => 1, 'name' => 'أحمد محمد', 'phone' => '0501234567', 'passport' => 'A12345678', 'nationality' => 'سعودي', 'status' => 'نشط'],
                                    ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],
                                                                        ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],

                                    ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],

                                    ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],

                                    ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],

                                    ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],
                                    ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],
                                    ['id' => 2, 'name' => 'خالد علي', 'phone' => '0507654321', 'passport' => 'B98765432', 'nationality' => 'مصري', 'status' => 'غير نشط'],


                                ];
                            @endphp
                            
                            @foreach($customers as $index => $customer)
                                <tr>
                                    <td><input type="checkbox" class="rowCheckbox"></td>
                                    <td>{{ $customer['name'] }}</td>
                                    <td>{{ $customer['phone'] }}</td>
                                    <td>{{ $customer['passport'] }}</td>
                                    <td>{{ $customer['nationality'] }}</td>
                                    <td>{{ rand(20, 50) }}</td>
                                    <td>مندوب {{ $index + 1 }}</td>
                                    <td>محافظة {{ $index + 1 }}</td>
                                    <td><i class="fas fa-paperclip"></i></td>
                                    <td>
                                        <span class="badge {{ $customer['status'] == 'نشط' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $customer['status'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i> عرض</button>
                                        <button class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i> تعديل</button>
                                        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i> حذف</button>
                                         <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-success"
                                                href="">
                                                <i class="fas fa-edit"></i> تصدير العميل اكسيل
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-warning"
                                                href="">
                                                <i class="fas fa-edit"></i> طباعة ملف العميل
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-warning"
                                                href="">
                                                <i class="fas fa-edit"></i> حجز نت
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-warning"
                                                href="">
                                                <i class="fas fa-edit"></i> بيانات التأشيرة
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-warning check-medical-status" href="#" data-mrz="P<EGYABDOU<<FAYEZ<ABDELSATTAR<FAYEZ<<<<<<<<<
                                            A268118145EGY9005156M2701312<<<<<<<<<<<<<<04">
                                                <i class="fas fa-edit"></i> نتيجة كشف طبي
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
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- End card-body -->
            </div> <!-- End card -->
        </div>
    </div>
</div>

@stop

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stop

@section('js')
<script>
   document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".check-medical-status").forEach(button => {
        button.addEventListener("click", async function (event) {
            event.preventDefault();

            let mrzCode = this.getAttribute("data-mrz");

            try {
                let response = await fetch("http://localhost:3000/check-status", { // Use 127.0.0.1 instead of localhost
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ mrzCode: mrzCode })
                });

                if (!response.ok) throw new Error(`HTTP Error! Status: ${response.status}`);

                let result = await response.json();

                if (result.status === "success") {
                    Swal.fire({
    title: "تم اصدار نتيجة الكشف الطبي بنجاح",
    icon: "success",
    confirmButtonText: "تم",
    showCancelButton: true,
    cancelButtonText: "عرض النتيجة",
    didOpen: () => {
        const cancelButton = document.querySelector(".swal2-cancel");
        if (cancelButton) {
            cancelButton.addEventListener("click", () => {
                window.open(result.pdf_url, "_blank"); // Replace with actual PDF link
            });
        }
    }
});
                } else {
                    alert("⚠️ " + result.message);
                }

            } catch (error) {
                alert("❌ Error: " + error.message);
            }
        });
    });
});
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            }
        });
        
        // تحديد الكل
        $('#selectAll').on('click', function() {
            $('.rowCheckbox').prop('checked', this.checked);
        });

        // البحث المخصص
        $('#tableSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#dataTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });

        
</script>
@stop
