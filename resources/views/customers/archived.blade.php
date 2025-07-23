@extends('adminlte::page')

@section('title', 'العملاء المؤرشفين')

@section('content_header')
    <h1>العملاء المؤرشفين</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('customer.indes') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-users"></i> رجوع إلى العملاء
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center" id="archivedCustomersTable">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>كود العميل</th>
                        <th>اسم العميل</th>
                        <th>الصورة</th>
                        <th>الهاتف</th>
                        <th>تاريخ الأرشفة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>#{{ $customer->id }}</td>
                            <td><a href="{{ route('customer.add', $customer->id) }}">{{ $customer->name_ar }}</a></td>
                            <td>
                                <a href="{{ asset('storage/' . $customer->image) }}" target="blank">
                                    <img src="{{ asset('storage/' . $customer->image) }}" width="40" height="40"
                                        class="img-circle" alt="صورة">
                                </a>
                            </td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>{{ $customer->archived_at }}</td>
                            <td>
                                <form action="{{ route('customers.unarchive', $customer->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-undo"></i> استرجاع
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    {{-- DataTables CDN --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"></script>

    <script>
        $(document).ready(function() {
            const table = $('#archivedCustomersTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                pageLength: 25,
                ordering: true,
                responsive: true,
                autoWidth: false
            });

            // تحسين تنسيق حقل البحث بعد تهيئة الجدول
            $('.dataTables_filter input[type="search"]')
                .addClass('form-control form-control-sm')
                .attr('placeholder', 'بحث...')
                .css({
                    display: 'inline-block',
                    width: '250px',
                    marginRight: '10px'
                });
        });
    </script>
@endsection
