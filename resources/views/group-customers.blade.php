@extends('adminlte::page')

@section('title', 'العملاء')

@section('content_header')
    <h1>العملاء في حقيبة ({{ $bag->name }})</h1>
    {{-- مكتبات select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop

@section('content')
    <div class="container-fluid customers-page">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow border-0 customers-card">
                    <div class="card-body">

                        {{-- مجموعة الأزرار العلوية --}}
                        <div class="btn-group mb-3">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                عمليات
                            </button>
                            <ul class="dropdown-menu shadow-lg rounded-3 border-0">
                                {{-- السويس --}}
                                <li>
                                    <a href="{{ route('reports.transaction_statement_suez', $bag->id) }}" target="_blank"
                                        class="dropdown-item d-flex justify-content-between align-items-center text-success fw-bold">
                                        <div>
                                            <i class="fas fa-file-alt me-2"></i>
                                            كشف معاملات السويس
                                        </div>
                                        <span class="badge bg-success rounded-pill">
                                            {{ $bag->customers->filter(fn($c) => $c->customerGroup?->visaType?->embassy?->title === 'السويس')->count() }}
                                        </span>
                                    </a>
                                </li>

                                {{-- القاهرة --}}
                                <li>
                                    <a href="{{ route('reports.transaction_statement_cairo', $bag->id) }}" target="_blank"
                                        class="dropdown-item d-flex justify-content-between align-items-center text-primary fw-bold">
                                        <div>
                                            <i class="fas fa-file-alt me-2"></i>
                                            كشف معاملات القاهرة
                                        </div>
                                        <span class="badge bg-primary rounded-pill">
                                            {{ $bag->customers->filter(fn($c) => $c->customerGroup?->visaType?->embassy?->title === 'القاهرة')->count() }}
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <button id="exportBtn" class="dropdown-item btn btn-success mb-3">تصدير إلى
                                        Excel</button>
                                </li>
                                <li>
                                    <button id="visa" class="dropdown-item btn btn-success mb-3">جلب بيانات
                                        التاشيرة</button>
                                </li>
                            </ul>

                        </div>

                        {{-- الجدول --}}
                        <div class="table-responsive">
                            <table class="table table-hover text-center customers-table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th width="40px">
                                            <input type="checkbox" id="checkAll" class="form-check-input">
                                        </th>
                                        <th>كود العميل</th>
                                        <th>اسم العميل</th>
                                        <th>الصورة</th>
                                        <th>المندوب</th>
                                        <th>الهاتف</th>
                                        <th>اصدار التاشيرة</th>
                                        <th>الرابط</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr
                                            class="{{ $customer->blackList && $customer->blackList->block ? 'bg-light-danger' : 'bg-light' }}">
                                            <td style="position: relative !important;">
                                                <input
                                                    style="position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);"
                                                    class="form-check-input row-checkbox width-input centered-checkbox"
                                                    type="checkbox" data-customer='@json($customer)'>
                                            </td>
                                            <td>#{{ $customer->id }}</td>
                                            <td>
                                                <a href="{{ route('customer.add', $customer->id) }}"
                                                    class="text-primary fw-bold">
                                                    {{ $customer->name_ar }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $customer->image) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $customer->image) }}" width="40"
                                                        height="40" class="img-circle border" alt="صورة">
                                                </a>
                                            </td>
                                            <td>{{ $customer->delegate->name ?? '-' }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>
                                                {!! $customer->visa_number
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                @php
                                                    $visaDoc = $customer
                                                        ->documentTypes()
                                                        ->where('document_type', 'التاشيرة')
                                                        ->first();
                                                @endphp

                                                @if ($visaDoc)
                                                    <div class="d-flex gap-1">
                                                        {{-- زر العرض --}}
                                                        <a href="{{ asset('storage/' . $visaDoc->file) }}" target="_blank"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                        {{-- زر التحميل --}}
                                                        <a href="{{ asset('storage/' . $visaDoc->file) }}" download
                                                            class="btn btn-sm btn-success">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="text-muted">لا يوجد تأشيرة</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="btn-group dropstart">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('reports.show', $customer->id) }}"><i
                                                                    class="fas fa-file-alt text-primary me-2"></i> عرض
                                                                التقارير</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('bag.customers.remove', $customer->id) }}"><i
                                                                    class="fas fa-times text-danger me-2"></i> ازالة من
                                                                الحقيبة</a>
                                                        </li>
                                                        @if ($customer->phone != null)
                                                            <li>
                                                                <a class="dropdown-item text-success"
                                                                    href="https://wa.me/{{ '20' . ltrim($customer->phone, '0') }}"
                                                                    target="_blank" rel="noopener noreferrer">
                                                                    <i class="fab fa-whatsapp"></i>
                                                                    تواصل عبر واتساب
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> {{-- نهاية الجدول --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('swal_errors'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'حدثت بعض الأخطاء',
                html: `{!! implode('<br>', session('swal_errors')) !!}`,
            });
        </script>
    @endif


    <style>
        /* ألوان وتنسيقات خاصة بالصفحة فقط */
        .customers-page .customers-card {
            border-radius: 12px;
        }

        .customers-page .customers-table thead {
            background: linear-gradient(45deg, #2c3e50, #3498db);
            color: #fff;
        }

        .customers-page .customers-table thead th {
            vertical-align: middle;
            font-weight: 600;
        }

        .customers-page .customers-table tbody tr:hover {
            background-color: #f1f5f9 !important;
            transition: background-color 0.2s ease;
        }

        .customers-page .img-circle {
            border-radius: 50%;
            object-fit: cover;
        }

        .customers-page .fw-bold {
            font-weight: 600 !important;
        }

        .customers-page .dropdown-menu {
            font-size: 14px;
        }
    </style>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        .form-check-input {
            width: 16px;
            height: 16px;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.4em 0.6em;
        }

        .checkbox-header {
            position: relative;
            padding: 0 !important;
            text-align: center;
            vertical-align: middle;
        }

        .form-check-input {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#dataTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                pageLength: 50
            });

            // تحديد الكل
            document.getElementById("checkAll").addEventListener("change", function() {
                document.querySelectorAll("#dataTable .row-checkbox").forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            // احصل على الجدول
            var table = document.getElementById('dataTable');

            // حوّل الجدول إلى ورقة عمل Excel
            var workbook = XLSX.utils.table_to_book(table, {
                sheet: "Customers"
            });

            // احفظ الملف
            XLSX.writeFile(workbook, 'customers.xlsx');
        });
    </script>

    <Script>
        document.getElementById('visa').addEventListener('click', async function() {

            const selectedCustomers = [];

            document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
                const customerData = checkbox.getAttribute('data-customer');
                selectedCustomers.push(JSON.parse(customerData));
            });
            console.log(selectedCustomers);

            if (selectedCustomers.length === 0) {
                Swal.fire({
                    title: 'تنبيه',
                    text: 'يرجى تحديد العملاء أولاً',
                    icon: 'warning',
                    confirmButtonText: 'حسناً'
                });
                return;
            }

            for (const customer of selectedCustomers) {
                await handleCustomerVisa(customer); // دالة async
            }
        });

        async function handleCustomerVisa(customer) {
            // ✅ 1. رسالة البدء
            const loadingSwal = Swal.fire({
                title: '<span style="font-size: 20px; font-weight: bold;">جاري تنفيذ الكشف عن التأشيرة أو طلب الدخول...</span>',
                html: `
                        <div dir="rtl" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 10px;">
                            <div style="background: linear-gradient(135deg, #007bff, #6610f2); border-radius: 50%; padding: 18px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                                <div class="spinner-border text-white" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                            </div>
                            <h2 style="margin-top: 20px; font-size: 20px; font-weight: bold; color: #333;">يرجى الانتظار حتى انتهاء الحجز للعميل: ${customer.name_ar}</h2>
                        </div>
                    `,
                background: '#fff',
                width: '400px',
                customClass: {
                    popup: 'modern-swal-popup',
                },
                showConfirmButton: false,
                allowOutsideClick: false,
                backdrop: `rgba(0,0,0,0.2)`
            });

            const name_en = customer.name_en_mrz?.split(" ") || [];
            const name_ar = customer.name_ar || "";

            if (name_ar.length < 3 || name_en.length < 3) {
                await Swal.close(); // ⛔️ غلق رسالة الانتظار
                await Swal.fire({
                    title: "فشلت العملية!",
                    text: "هناك مشكلة في الاسم: " + name_ar,
                    icon: "error"
                });
                return;
            }

            try {
                const response = await fetch('http://localhost:3000/open-mofa', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        applicationNumber: customer.e_visa_number,
                        sponserId: customer.passport_id,
                        name: customer.name_en_mrz,
                        customer_id: customer.id,
                        email: "{{ auth()->user()->email }}",
                    }),
                });

                const data = await response.json();

                await Swal.close(); // ✅ غلق الرسالة السابقة قبل عرض الجديدة

                if (data.status === true) {
                    const successMessage = data.visaNumber ?
                        `تم فتح موقع وزارة الخارجية بنجاح!\nرقم التأشيرة: ${data.visaNumber}\nاسم العميل: ${customer.name_ar}` :
                        `تم إصدار طلب الدخول للعميل: ${customer.name_ar}`;

                    await Swal.fire({
                        title: "نجحت العملية!",
                        text: successMessage,
                        icon: "success",
                        timer: 3000, // ✅ الانتظار 3 ثواني
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                } else {
                    await Swal.fire({
                        title: "فشلت العملية!",
                        text: data.message || "حدث خطأ غير معروف",
                        icon: "error"
                    });
                }

            } catch (error) {
                await Swal.close();
                console.error('❌ Error:', error);
                await Swal.fire({
                    title: "فشلت العملية!",
                    text: "حدثت مشكلة في فتح الموقع",
                    icon: "error"
                });
            }
        }
    </Script>
@stop
