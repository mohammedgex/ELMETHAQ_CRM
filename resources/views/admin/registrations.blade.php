@extends('layouts.app')
@section('title', 'قائمة العمالة المسجلة')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm" style="border-radius:18px; border:1px solid #e5e7eb;">
            <div class="card-header text-center"
                style="background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
                   color: #fff; border-radius: 18px 18px 0 0;">
                <h4 class="mb-0 fw-bold">قائمة العمالة المسجلة</h4>
            </div>

            <div class="card-body"
                style="background: linear-gradient(135deg, #fff 85%, #f8fafc 100%);
                   border-radius: 0 0 18px 18px;">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center table-hover bg-white mb-0">
                        <thead
                            style="background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
                                  color: #fff;">
                            <tr>
                                <th>الصورة الشخصية</th>
                                <th>الاسم</th>
                                <th>الرقم القومي</th>
                                <th>الوظيفة</th>
                                <th>رقم الهاتف</th>
                                <th>صورة البطاقة</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($workers as $worker)
                                <tr>
                                    <td>
                                        @if ($worker->personal_photo)
                                            <a href="{{ asset('storage/' . $worker->personal_photo) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $worker->personal_photo) }}"
                                                    alt="صورة العامل" class="rounded-circle"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold" style="color:#174A7C;">{{ $worker->name }}</td>
                                    <td>{{ $worker->national_id }}</td>
                                    <td>{{ $worker->job_title }}</td>
                                    <td dir="ltr">
                                        <a href="tel:{{ $worker->phone }}" class="text-decoration-none text-dark">
                                            {{ $worker->phone }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($worker->id_card_photo)
                                            <a href="{{ asset('storage/' . $worker->id_card_photo) }}" target="_blank"
                                                class="btn btn-sm fw-bold text-white"
                                                style="background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
                                                  border-radius: 50px; padding: 4px 12px;">
                                                عرض
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $worker->message ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted fw-bold">
                                        لا توجد بيانات عمالة مسجلة حالياً 📄
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($workers->hasPages())
                    <div class="mt-4">
                        {{ $workers->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
