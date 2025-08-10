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
                    <div class="d-flex justify-content-between">
                        <h4 class="mb-3" style="color: #343a40; font-weight: bold;">إضافة تأشيرة جديدة</h4>
                    </div>
                    <form action="{{ route('visa-type.create') }}" method="POST" id="visa-type">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">نوع التأشيرة</label>
                                <select class="form-control fw-bold" style="border-color: #343a40;" name="visa_peroid"
                                    required>
                                    <option value="">اختر النوع</option>
                                    <option value='تأشيرة العمل المؤقت لخدمات الحج والعمرة'>تأشيرة العمل المؤقت لخدمات الحج
                                        والعمرة</option>
                                    <option value='عمل'>عمل</option>
                                    <option value="عمل مؤقت">عمل مؤقت</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">اسم التأشيرة</label>
                                <input type="text" class="form-control" style="border-color: #343a40;" name="name"
                                    placeholder="أدخل اسم التأشيرة" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">رقم السجل</label>
                                <input type="number" id="registration_number" class="form-control"
                                    style="border-color: #343a40;" name="registration_number" placeholder="أدخل رقم السجل"
                                    required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">رقم الصادر</label>
                                <input type="number" id="outgoing_number" class="form-control"
                                    style="border-color: #343a40;" name="outgoing_number" placeholder="أدخل رقم الصادر"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">القنصلية</label>
                                <select class="form-control fw-bold" id="embassy_id" style="border-color: #343a40;"
                                    name="embassy_id" required>
                                    <option value="">اختر الحالة</option>
                                    @foreach ($embassions as $embassy)
                                        <option value="{{ $embassy->id }}">{{ $embassy->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">الكفيل</label>
                                <select class="form-control fw-bold" style="border-color: #343a40;" name="sponser_id"
                                    required>
                                    <option value="">اختر الكفيل</option>
                                    @foreach ($sponsers as $sponser)
                                        <option value="{{ $sponser->id }}">{{ $sponser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">الغرض</label>
                                <input type="text" class="form-control" style="border-color: #343a40;" name="porpose"
                                    value="{{ old('porpose', $visaTypeEdit->porpose ?? '') }}" placeholder="أدخل الغرض"
                                    required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">تاريخ اصدار التاشيرة</label>
                                <input type="date" class="form-control" name="issuing_visa"
                                    value="{{ old('issuing_visa') }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100 fw-bold"
                            style="background-color: #28a745; color: white;">
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
                                <label class="font-weight-bold" style="color: #343a40;"> نوع التاشيرة التأشيرة </label>
                                <select class="form-control fw-bold" style="border-color: #343a40;" name="visa_peroid"
                                    required>
                                    <option value="">اختر النوع</option>
                                    <option value="تأشيرة العمل المؤقت لخدمات الحج والعمرة"
                                        {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'تأشيرة العمل المؤقت لخدمات الحج والعمرة' ? 'selected' : '' }}>
                                        تأشيرة العمل المؤقت لخدمات الحج والعمرة
                                    </option>
                                    <option value="عمل"
                                        {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'عمل' ? 'selected' : '' }}>
                                        عمل
                                    </option>
                                    <option value="عمل مؤقت"
                                        {{ old('visa_peroid', $visaTypeEdit->visa_peroid) == 'عمل مؤقت' ? 'selected' : '' }}>
                                        عمل مؤقت
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;"> اسم التاشيرة </label>
                                <input type="text" class="form-control" style="border-color: #343a40;" name="name"
                                    value="{{ $visaTypeEdit->name }}" placeholder="أدخل اسم التاشيرة" required>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;"> رقم السجل </label>
                                <input type="number" class="form-control" style="border-color: #343a40;"
                                    value="{{ $visaTypeEdit->registration_number }}" name="registration_number"
                                    placeholder="أدخل رقم السجل" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;"> رقم الصادر </label>
                                <input type="number" class="form-control" style="border-color: #343a40;"
                                    name="outgoing_number" placeholder="أدخل رقم الصادر" required
                                    value="{{ $visaTypeEdit->outgoing_number }}">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;"> القنصلية </label>
                                <select class="form-control fw-bold" style="border-color: #343a40;" name="embassy_id"
                                    required>
                                    <option value="">اختر القمصلية</option>
                                    @foreach ($embassions as $embassy)
                                        <option value="{{ $embassy->id }}"
                                            {{ old('embassy_id', $visaTypeEdit->embassy_id ?? '') == $embassy->id ? 'selected class= bg-success' : '' }}>
                                            {{ $embassy->title }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;"> الكفيل </label>
                                <select class="form-control fw-bold" style="border-color: #343a40;" name="sponser_id"
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
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">الغرض</label>
                                <input type="text" class="form-control" style="border-color: #343a40;" name="porpose"
                                    value="{{ old('porpose', isset($visaTypeEdit->porpose) ? $visaTypeEdit->porpose : '') }}"
                                    placeholder="أدخل الغرض" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold" style="color: #343a40;">تاريخ اصدار التاشيرة</label>
                                <input type="date" class="form-control" style="border-color: #343a40;"
                                    name="issuing_visa"
                                    value="{{ old('issuing_visa', isset($visaTypeEdit->issuing_visa) ? $visaTypeEdit->issuing_visa : '') }}"
                                    placeholder="أدخل الغرض" required>
                            </div>

                        </div>


                        <!-- زر بعرض كامل -->
                        <button type="submit" class="btn mt-3 px-4 shadow-sm w-100"
                            style="background-color: #28a745; color: white;">
                            حفظ التعديلات
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- ✅ قسم البحث والعرض -->
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #ccc;">
                <h4 class="mb-3" style="color: #343a40; font-weight: bold;">قائمة التأشيرات</h4>

                <!-- 🔎 مربع البحث والفلترة -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <select id="filterType" class="form-control" onchange="searchTable()">
                            <option value="all">البحث في جميع الحقول</option>
                            <option value="id">كود التأشيرة</option>
                            <option value="name">نوع التأشيرة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder="أدخل كلمة البحث..."
                            onkeyup="searchTable()">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center animate__animated animate__fadeInUp" id="delegatesTable">
                        <thead style="background-color: #343a40;">
                            <tr>
                                <th>كود التأشيرة</th>
                                <th>الاسم</th>
                                <th>نوع التاشيرة</th>
                                <th>رقم السجل</th>
                                <th>رقم الصادر</th>
                                <th>الغرض</th>
                                <th>أجمالي العدد</th>
                                <th>الكفيل</th>
                                <th>القنصلية</th>
                                <th>عدد المهن</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visa_types as $visa_type)
                                <tr class="table-light">
                                    <td>#{{ $visa_type->id }}</td>
                                    <td>{{ $visa_type->name }}</td>
                                    <td>{{ $visa_type->visa_peroid }}</td>
                                    <td>{{ $visa_type->registration_number }}</td>
                                    <td>{{ $visa_type->outgoing_number }}</td>
                                    <td>{{ $visa_type->porpose }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $visa_type->count }} عميل
                                        </span>
                                    </td>
                                    <td>{{ $visa_type->sponser->name }}</td>
                                    <td>{{ $visa_type->embassy->title }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ count($visa_type->visa_professions) }} مهن
                                        </span>
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center gap-1">
                                        <a href="{{ route('visa-type.index', $visa_type->id) }}"
                                            class="btn btn-sm btn-outline-success shadow-sm" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- <form action="{{ route('visa-type.delete', $visa_type->id) }}" method="POST"
                                            class="d-inline mx-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger shadow-sm" type="submit"
                                                title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form> --}}

                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-secondary shadow-sm dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a data-embassy="{{ $visa_type->embassy->title }}"
                                                        data-outgoing_number="{{ $visa_type->outgoing_number }}"
                                                        data-registration_number="{{ $visa_type->registration_number }}"
                                                        data-visa="{{ $visa_type->id }}"
                                                        class="dropdown-item text-success profession-outomation"
                                                        id="profession">
                                                        <i class="fas fa-edit"></i> جلب المهن
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-primary"
                                                        href="{{ route('visa-profession.index', $visa_type->id) }}">
                                                        <i class="fas fa-list"></i> المهن
                                                    </a>
                                                </li>
                                                {{-- <li>
                                                    <a class="dropdown-item text-warning" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal">
                                                        <i class="fas fa-print"></i> طباعة تقرير
                                                    </a>
                                                </li> --}}
                                                {{-- <li>
                                                    <button class="dropdown-item text-danger">
                                                        <i class="fas fa-users"></i> بلاك ليست
                                                    </button>
                                                </li> --}}
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

        .loader {
            border: 5px solid #f3f3f3;
            /* لون الخلفية */
            border-top: 5px solid #4caf50;
            /* لون الدائرة المتحركة */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 16px;
            text-align: center;
        }

        /* الوضع الفاتح - الألوان الحالية */
        #delegatesTable thead {
            background-color: #343a40 !important;
            color: white !important;
        }

        #delegatesTable tbody tr.table-light {
            background-color: #f8f9fa !important;
            color: #212529 !important;
        }

        /* الوضع الداكن */
        body.dark-mode #delegatesTable thead {
            background-color: #1f2d3d !important;
            /* هيدر داكن */
            color: #ffffff !important;
        }

        body.dark-mode #delegatesTable tbody tr.table-light {
            background-color: #2c3b4c !important;
            /* صفوف داكنة */
            color: #ffffff !important;
        }

        body.dark-mode #delegatesTable tbody tr:hover {
            background-color: #3a4b5c !important;
            /* لون الهوفر */
        }

        /* البادجات في الوضع الداكن */
        body.dark-mode .badge.bg-success {
            background-color: #28a745 !important;
            color: #fff !important;
        }

        body.dark-mode .badge.bg-info {
            background-color: #17a2b8 !important;
            color: #fff !important;
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

        document.querySelectorAll('.profession-outomation').forEach(function(element) {
            element.addEventListener('click', function(e) {
                const element = e.currentTarget;

                const visaType = {
                    VisaNumber: element.dataset.outgoing_number,
                    Embassy: element.dataset.embassy,
                    SponserID: element.dataset.registration_number
                };


                // إذا كنت تريد إرسال الطلب لجلب المهن مثلاً:
                fetch('http://localhost:3000/getVisaInfo', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(visaType)
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.visa_id = element.dataset.visa;

                        fetch("{{ route('profession') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector(
                                            'meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('خطأ في الاستجابة من السيرفر');
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire({
                                    title: "نجحت العملية!",
                                    icon: "success"
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            })
                            .catch(error => {
                                console.error("حدث خطأ أثناء جلب المهن:", error);
                            });

                    })
                    .catch(error => {
                        console.error('حدث خطأ أثناء جلب المهن:', error);
                    });
            });
        })

        // document.getElementById('profession').addEventListener('click', function(e) {
        //     const element = e.currentTarget;

        //     const visaType = {
        //         VisaNumber: element.dataset.outgoing_number,
        //         Embassy: element.dataset.embassy,
        //         SponserID: element.dataset.registration_number
        //     };


        //     // إذا كنت تريد إرسال الطلب لجلب المهن مثلاً:
        //     fetch('http://localhost:3000/getVisaInfo', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json'
        //             },
        //             body: JSON.stringify(visaType)
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             data.visa_id = element.dataset.visa;

        //             fetch("{{ route('profession') }}", {
        //                     method: "POST",
        //                     headers: {
        //                         "Content-Type": "application/json",
        //                         "Accept": "application/json",
        //                         "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
        //                             .getAttribute('content')
        //                     },
        //                     body: JSON.stringify(data)
        //                 })
        //                 .then(response => {
        //                     if (!response.ok) {
        //                         throw new Error('خطأ في الاستجابة من السيرفر');
        //                     }
        //                     return response.json();
        //                 })
        //                 .then(data => {
        //                     Swal.fire({
        //                         title: "نجحت العملية!",
        //                         icon: "success"
        //                     });

        //                     setTimeout(() => {
        //                         location.reload();
        //                     }, 3000);
        //                 })
        //                 .catch(error => {
        //                     console.error("حدث خطأ أثناء جلب المهن:", error);
        //                 });

        //         })
        //         .catch(error => {
        //             console.error('حدث خطأ أثناء جلب المهن:', error);
        //         });
        // });
    </script>
@stop
