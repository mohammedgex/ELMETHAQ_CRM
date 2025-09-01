a{{-- resources/views/admin/failed-logins/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'محاولات الدخول الفاشلة')

@section('content_header')
    <h1 class="fw-bold">📋 العملاء الذين فشلوا في تسجيل الدخول : {{ count($leads) }}</h1>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center 
                bg-primary text-white">
            <span class="fw-bold"> قائمة العملاء </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0" id="failedLoginsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>الرقم</th>
                            <th>الصورة</th>
                            <th>رقم الهاتف</th>
                            <th>الوظيفة</th>
                            <th>تاريخ التسجيل</th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ $lead->image ? asset('storage/' . $lead->image) : asset('images/default-avatar.png') }}"
                                        target="_blank" rel="noopener noreferrer">
                                        <img src="{{ $lead->image ? asset('storage/' . $lead->image) : asset('images/default-avatar.png') }}"
                                            alt="avatar" class="rounded-circle shadow-sm"
                                            style="width:48px;height:48px;object-fit:cover;" loading="lazy">
                                    </a>

                                </td>
                                <td class="fw-semibold">{{ $lead->phone ?? '-' }}</td>
                                <td class="fw-semibold">{{ $lead->jobTitle->title ?? '-' }}</td>
                                <td>{{ optional($lead->created_at)->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1 flex-nowrap">
                                        <a href="{{ route('leads-customers.update', $lead->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if (auth()->user()->role == 'admin')
                                            <form id="delete" action="{{ route('leads-customers.delete', $lead->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-4 text-muted">
                                    لا توجد محاولات فاشلة مسجلة
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
