@extends('adminlte::page')

@section('title', 'أنواع التأشيرات')

@section('content_header')
<h1 style="font-weight:bold; text-align:right;"> تعريف التأشيرات</h1>
@stop

@section('content')
<div class="row">
    <!-- ✅ قسم إضافة مجموعة -->
    <div class="col-md-12 mb-4">
        @if ($visaTypeEdit->outgoing_number === '')
        <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
            style="border-radius: 15px; background-color: #f8f9fa;">
            <h4 class="mb-3 text-dark font-weight-bold">إضافة تأشيرة جديدة</h4>
            <form action="{{ route('visa-type.create') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> نوع التأشيرة </label>
                        <select class="form-control fw-bold" style="border-color: #997a44;" name="visa_peroid"
                            required>
                            <option value="">اختر النوع</option>
                            <option value='تأشيرة العمل المؤقت لخدمات الحج والعمرة'>تأشيرة العمل المؤقت لخدمات الحج والعمرة</option>
                            <option value='عمل'>عمل</option>
                            <option value="عمل مؤقت">عمل مؤقت </option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> اسم التاشيرة </label>
                        <input type="text" class="form-control" name="name" placeholder="أدخل اسم التاشيرة"
                            required>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> رقم السجل </label>
                        <input type="number" class="form-control" name="registration_number"
                            placeholder="أدخل رقم السجل" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> رقم الصادر </label>
                        <input type="number" class="form-control" name="outgoing_number"
                            placeholder="أدخل رقم الصادر" required>
                    </div>


                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> العدد </label>
                        <input type="number" class="form-control" name="count" placeholder="أدخل العدد" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">الغرض</label>
                        <input type="text" class="form-control" name="porpose" placeholder="أدخل الغرض" required>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> القنصلية </label>
                        <select class="form-control fw-bold" style="border-color: #997a44;" name="embassy_id"
                            required>
                            <option value="">اختر الحالة</option>
                            @foreach ($embassions as $embassy)
                            <option value="{{ $embassy->id }}">{{ $embassy->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> الكفيل </label>
                        <select class="form-control fw-bold" style="border-color: #997a44;" name="sponser_id"
                            data-placeholder="اختر الكفيل" required>
                            <option value="">اختر الكفيل</option>
                            @foreach ($sponsers as $sponser)
                            <option value="{{ $sponser->id }}">{{ $sponser->name }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>


                <!-- زر بعرض كامل -->
                <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                    style="background-color: #997a44; color: white;">
                    إضافة تأشيرة جديدة
                </button>
            </form>
        </div>

        @else
        <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
            style="border-radius: 15px; background-color: #f8f9fa;">
            <h4 class="mb-3 text-dark font-weight-bold">إضافة تأشيرة جديدة</h4>
            <form action="{{ route('visa-type.edit', $visaTypeEdit->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> نوع التاشيرة التأشيرة </label>
                        <select class="form-control fw-bold" style="border-color: #997a44;" name="visa_peroid" required>
                            <option value="">اختر النوع</option>
                            <option value="تأشيرة العمل المؤقت لخدمات الحج والعمرة" {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'تأشيرة العمل المؤقت لخدمات الحج والعمرة' ? 'selected' : '' }}>
                                تأشيرة العمل المؤقت لخدمات الحج والعمرة
                            </option>
                            <option value="عمل" {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'عمل' ? 'selected' : '' }}>
                                عمل
                            </option>
                            <option value="عمل مؤقت" {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'عمل مؤقت' ? 'selected' : '' }}>
                                عمل مؤقت
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> اسم التاشيرة </label>
                        <input type="text" class="form-control" name="name" value="{{ $visaTypeEdit->name }}"
                            placeholder="أدخل اسم التاشيرة" required>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> رقم السجل </label>
                        <input type="number" class="form-control" value="{{ $visaTypeEdit->registration_number }}"
                            name="registration_number" placeholder="أدخل رقم السجل" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> رقم الصادر </label>
                        <input type="number" class="form-control" name="outgoing_number"
                            placeholder="أدخل رقم الصادر" required value="{{ $visaTypeEdit->outgoing_number }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> العدد </label>
                        <input type="number" class="form-control" value="{{ $visaTypeEdit->count }}"
                            name="count" placeholder="أدخل العدد " required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">الغرض</label>
                        <input type="text" class="form-control" name="porpose"
                            value="{{ old('porpose', $visaTypeEdit->porpose ?? '') }}" placeholder="أدخل الغرض"
                            required>

                    </div>


                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> القنصلية </label>
                        <select class="form-control fw-bold" style="border-color: #997a44;" name="embassy_id"
                            required>
                            <option value="">اختر الحالة</option>
                            @foreach ($embassions as $embassy)
                            <option value="{{ $embassy->id }}"
                                {{ old('embassy_id', $visaTypeEdit->embassy_id ?? '') == $embassy->id ? 'selected class= bg-success' : '' }}>
                                {{ $embassy->title }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold"> الكفيل </label>
                        <select class="form-control fw-bold" style="border-color: #997a44;" name="sponser_id"
                            required>
                            <option value="">اختر الكفيل</option>
                            @foreach ($sponsers as $sponser)
                            <option value="{{ $sponser->id }}"
                                {{ old('sponser_id', $visaTypeEdit->sponser_id ?? '') == $sponser->id ? 'selected' : '' }}>
                                {{ $sponser->name }}
                            </option>
                            @endforeach
                        </select>
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
                        <option value="id"> كود التأشيرة</option>
                        <option value="name"> نوع التأشيرة</option>
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

                        @foreach ($visa_types as $visa_type)
                        <tr class="table-light">
                            <td>#{{ $visa_type->id }}</td>
                            <td class="highlight"> {{ $visa_type->outgoing_number }} </td>
                            <td class="highlight"> {{ $visa_type->registration_number }} </td>
                            <td class="highlight"> <span class="badge bg-success">
                                    {{ $visa_type->count }} عميل</span> </td>
                            <td class="highlight"> {{ $visa_type->sponser->name }}</td>
                            <td class="highlight">{{ $visa_type->embassy->title }}</td>
                            <td class="highlight"> <span
                                    class="badge bg-info">{{ count($visa_type->visa_professions) }} مهن</span>
                            </td>
                            <td class="highlight">
                                <form action="{{ route('customers.filter') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="visa_type_id" value="{{ $visa_type->id }}">
                                    <button type="submit" class="badge bg-primary">
                                        {{ $visa_type->customers->count() }}
                                        عميل
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('visa-type.index', $visa_type->id) }}">
                                    <button class="btn btn-sm btn-outline-success shadow-sms">
                                        <i class="fas fa-edit"></i> تعديل
                                    </button>
                                </a>
                                <form action="{{ route('visa-type.delete', $visa_type->id) }}" method="POST"
                                    class="mx-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>

                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-success"
                                                href="{{ route('visa-profession.index', $visa_type->id) }}">
                                                <i class="fas fa-edit"></i> المهن
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('customers.filter') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="visa_type_id"
                                                    value="{{ $visa_type->id }}">
                                                <button type="submit" class="dropdown-item text-primary">
                                                    <i class="fas fa-edit"></i> العملاء
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-warning" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
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
                <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                This is a Bootstrap modal.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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

    .table-responsive {
        overflow: visible !important;
    }
</style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
    $(document).on('DOMContentLoaded', function() {
        $('.select2').select2();
    });
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