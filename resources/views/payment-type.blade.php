@extends('adminlte::page')

@section('title', 'تعريف المعاملات المالية')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تعريف المعاملات المالية</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
                style="border-radius: 15px; background-color: #f8f9fa;">

                @if ($paymenEdit->title === '')
                    <h4 class="mb-3 text-dark font-weight-bold"><i class="fas fa-plus-circle text-success ml-2"></i> إضافة
                        معاملة مالية جديدة</h4>
                    <form action="{{ route('payment-type.create') }}" method="POST">
                    @else
                        <h4 class="mb-3 text-dark font-weight-bold"><i class="fas fa-edit text-warning ml-2"></i> تعديل
                            المعاملة: {{ $paymenEdit->title }}</h4>
                        <form action="{{ route('payment-type.edit', $paymenEdit->id) }}" method="POST">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label class="font-weight-bold">نوع المعاملة</label>
                        <input type="text" class="form-control" name="title" value="{{ $paymenEdit->title }}"
                            placeholder="أدخل نوع المعاملة (مثلاً: رسوم تسجيل)" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">السعر</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" name="price"
                                value="{{ $paymenEdit->price ?? 0 }}" placeholder="0.00" required>
                            <div class="input-group-append">
                                <span class="input-group-text">ج.م</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="btn mt-3 px-4 shadow-sm w-100 {{ $paymenEdit->title === '' ? 'btn-success' : 'btn-warning' }}">
                    {{ $paymenEdit->title === '' ? 'إضافة المعاملة' : 'حفظ التعديلات' }}
                </button>
                </form>
            </div>
        </div>

        @if (Session::has('success'))
            <script>
                Swal.fire({
                    title: "{{ Session::get('success') }}",
                    icon: "success",
                    confirmButtonText: "تم"
                });
            </script>
        @endif

        @if (Session::has('edit_success'))
            <script>
                Swal.fire({
                    title: "تم تعديل '{{ Session::get('edit_success') }}' بنجاح",
                    icon: "success",
                    confirmButtonText: "تم"
                });
            </script>
        @endif

        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0" style="border-radius: 15px;">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center" id="delegatesTable">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th width="10%">الكود</th>
                                <th width="50%">نوع المعاملة</th>
                                <th width="20%">السعر</th>
                                <th width="20%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td class="font-weight-bold text-muted">#{{ $payment->id }}</td>
                                    <td class="text-center pr-4">{{ $payment->title }}</td>
                                    <td><span class="badge badge-pill badge-info px-3 py-2"
                                            style="font-size: 0.9rem;">{{ number_format($payment->price, 2) }} ج.م</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('payment-type.index', $payment->id) }}"
                                                class="btn btn-sm btn-outline-primary mx-1" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- <form action="{{ route('payment-type.delete', $payment->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)"
                                                    class="btn btn-sm btn-outline-danger mx-1" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form> --}}
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
@stop

@section('css')
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        .form-control {
            border-radius: 8px;
            height: 45px;
        }

        .card {
            border: none;
            transition: 0.3s;
        }

        .table thead th {
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-group .btn {
            border-radius: 8px !important;
            margin: 0 2px;
        }

        .input-group-text {
            background-color: #e9ecef;
            border-radius: 0 8px 8px 0 !important;
        }

        input[type=number] {
            border-radius: 8px 0 0 8px !important;
        }
    </style>
@stop

@section('js')
    <script>
        // دالة البحث المحدثة
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll("#delegatesTable tbody tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
            });
        }

        // دالة الحذف بـ SweetAlert2
        function confirmDelete(button) {
            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من استعادة هذه المعاملة بعد الحذف!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، احذفها",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
@stop
