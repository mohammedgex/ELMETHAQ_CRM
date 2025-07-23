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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="dataTable">
                                <thead class="text-white" style="background: linear-gradient(45deg, #2c3e50, #3498db);">
                                    <tr>
                                        <th width="40px">
                                            <input type="checkbox" id="checkAll" class="form-check-input">
                                        </th>
                                        <th>كود العميل</th>
                                        <th>اسم العميل</th>
                                        <th>الصورة</th>
                                        <th>الهاتف</th>
                                        <th>الحالة</th>
                                        <th>الكشف الطبي</th>
                                        <th>البصمة</th>
                                        <th>كشف المعامل</th>
                                        <th>إنجاز</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr
                                            class="{{ $customer->blackList && $customer->blackList->block ? 'bg-light-danger' : 'bg-light' }}">
                                            <th width="40px" class="checkbox-header">
                                                <input type="checkbox" id="checkAll"
                                                    class="form-check-input centered-checkbox">
                                            </th>
                                            <td>#{{ $customer->id }}</td>
                                            <td>
                                                <a href="{{ route('customer.add', $customer->id) }}"
                                                    class="text-primary text-decoration-none">
                                                    {{ $customer->name_ar }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $customer->image) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $customer->image) }}" width="40"
                                                        height="40" class="img-circle" alt="صورة">
                                                </a>
                                            </td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $customer->status == 'نشط' ? 'primary' : 'secondary' }}">
                                                    {{ $customer->status }}
                                                </span>
                                            </td>
                                            <td>
                                                {!! $customer->medical_examination == 'تم الحجز'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                {!! $customer->finger_print_examination == 'تم تصدير الاكسيل'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                {!! $customer->virus_examination == 'تم اصدار ايصال المعامل'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                            </td>
                                            <td>
                                                {!! $customer->engaz_request == 'تم الحجز'
                                                    ? '<i class="fas fa-check-circle text-success"></i>'
                                                    : '<i class="fas fa-times-circle text-danger"></i>' !!}
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
                                                                href="{{ route('customer.add', $customer->id) }}"><i
                                                                    class="fas fa-edit text-primary me-2"></i> تعديل</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('customer.show', $customer->id) }}"><i
                                                                    class="fas fa-eye text-info me-2"></i> عرض</a></li>
                                                        @if ($customer->blackList)
                                                            @if ($customer->blackList->block)
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('customers.unblock', $customer->id) }}"><i
                                                                            class="fas fa-user-check text-success me-2"></i>
                                                                        إزالة البلوك</a></li>
                                                            @else
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('customers.block', $customer->id) }}"><i
                                                                            class="fas fa-user-slash text-danger me-2"></i>
                                                                        بلوك</a></li>
                                                            @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
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
@stop
