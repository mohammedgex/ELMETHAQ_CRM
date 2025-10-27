@extends('layouts.app')

@section('title', 'طلبات تسجيل الشركات')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- السايدبار --}}
            @include('admin.partials.sidebar')
            {{-- المحتوى الرئيسي --}}
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <h2 class="mb-4 text-primary">طلبات تسجيل الشركات</h2>
                    <div class="card shadow">
                        <div class="card-body">
                            @if (session('status_message'))
                                <div class="alert alert-info text-center">{{ session('status_message') }}</div>
                            @endif
                            @if (count($requests) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>اسم الشركة</th>
                                                <th>البريد الإلكتروني</th>
                                                <th>رقم الهاتف</th>
                                                <th>المسمى الوظيفي</th>
                                                <th>عدد العمالة</th>
                                                <th>ملاحظات</th>
                                                <th>الحالة</th>
                                                <th>إجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requests as $req)
                                                <tr>
                                                    <td>{{ $req['company_name'] }}</td>
                                                    <td>{{ $req['email'] }}</td>
                                                    <td>{{ $req['phone'] ?? '' }}</td>
                                                    <td>{{ $req['job_title'] }}</td>
                                                    <td>{{ $req['workers_count'] }}</td>
                                                    <td>{{ $req['message'] }}</td>
                                                    <td>
                                                        @if ($req['status'] == 'approved')
                                                            <span class="badge bg-success">مقبول</span>
                                                        @elseif($req['status'] == 'rejected')
                                                            <span class="badge bg-danger">مرفوض</span>
                                                        @else
                                                            <span class="badge bg-secondary">قيد المراجعة</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form method="POST"
                                                            action="{{ route('admin.companies.requests.status', $req['index']) }}"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                @if ($req['status'] == 'approved') disabled @endif>موافقة</button>
                                                        </form>
                                                        <form method="POST"
                                                            action="{{ route('admin.companies.requests.status', $req['index']) }}"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                @if ($req['status'] == 'rejected') disabled @endif>رفض</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">لا توجد طلبات شركات حالياً.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
