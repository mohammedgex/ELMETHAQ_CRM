@extends('adminlte::page')

@section('title', 'طلبات التعقيب')

@section('content_header')
    <h1>طلبات التعقيب</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>صورة التأشيرة</th>
                        <th>رقم الصادر</th>
                        <th>رقم السجل</th>
                        <th>اسم الكفيل</th>
                        <th>عنوان الكفيل</th>
                        <th>هاتف الكفيل</th>
                        <th>القنصلية</th>
                        <th>الغرض</th>
                        <th>نوعه</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taakebs as $taakeb)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($taakeb->visa_image)
                                    <a href="{{ asset('storage/' . $taakeb->visa_image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $taakeb->visa_image) }}" width="50" height="50"
                                            class="img-thumbnail">
                                    </a>
                                @else
                                    <span class="text-muted">لا توجد</span>
                                @endif
                            </td>
                            <td>{{ $taakeb->issued_number }}</td>
                            <td>{{ $taakeb->sponsor_id_number }}</td>
                            <td>{{ $taakeb->sponsor_name }}</td>
                            <td>{{ $taakeb->sponsor_address }}</td>
                            <td>{{ $taakeb->sponsor_phone }}</td>
                            <td>{{ $taakeb->consulate }}</td>
                            <td>{{ $taakeb->purpose }}</td>
                            <td>{{ $taakeb->company->status == 'company' ? 'شركة' : 'فرد' }}</td>
                            <td>
                                @if ($taakeb->status === 'approved')
                                    <span class="badge bg-success">موافق عليه</span>
                                @elseif($taakeb->status === 'rejected')
                                    <span class="badge bg-danger">مرفوض</span>
                                @else
                                    <span class="badge bg-warning">قيد الانتظار</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('taakebs.approve', $taakeb->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">موافقة</button>
                                </form>

                                <form action="{{ route('taakebs.reject', $taakeb->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">رفض</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
