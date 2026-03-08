@extends('adminlte::page')

@section('title', 'سجل الموظف')

@section('content')
    <div class="container-fluid pt-4">

        <div class="row mb-4 px-2">
            <div class="col-12 d-flex justify-content-between align-items-center modern-header-card p-3 shadow-sm">
                <div>
                    <h4 class="mb-0 font-weight-bold header-title">📜 سجل نشاط الموظف</h4>
                    <p class="mb-0 small user-subtitle">عرض التسلسل الزمني لعمليات: <strong>{{ $user->name }}</strong></p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge badge-pill badge-soft-info ml-3 px-3 py-2">
                        إجمالي العمليات: {{ count($histories) }}
                    </span>
                    <a href="{{ route('users') }}" class="btn btn-back-modern rounded-pill px-4 shadow-sm">
                        <i class="fas fa-arrow-right ml-1"></i> رجوع
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 modern-table-card" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header border-0 bg-transparent py-3">
                <h5 class="mb-0 font-weight-bold section-title"><i class="fas fa-stream ml-2 text-primary"></i> تفاصيل السجل
                    الأخير</h5>
            </div>

            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead>
                        <tr class="thead-premium">
                            <th class="py-3">#</th>
                            <th class="py-3 text-right">الموظف</th>
                            <th class="py-3">العميل المستهدف</th>
                            <th class="py-3">نوع العملية</th>
                            <th class="py-3 text-right">الوصف</th>
                            <th class="py-3">الوقت والتاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr>
                                <td class="text-muted font-italic small">{{ $loop->iteration }}</td>

                                {{-- اسم الموظف مع أيقونة --}}
                                <td class="text-right py-3">
                                    <div class="d-flex align-items-center justify-content-start pr-3">
                                        <div class="avatar-sm ml-2">
                                            <i class="fas fa-user-circle text-navy opacity-50"></i>
                                        </div>
                                        <span
                                            class="font-weight-bold text-navy-title">{{ $history->user->name ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- اسم العميل بتصميم مميز --}}
                                <td>
                                    @if ($history->customer)
                                        <a href="{{ route('customer.show', $history->customer->id) }}"
                                            class="customer-link-primary">
                                            <i class="fas fa-user-check ml-1"></i> {{ $history->customer->name_ar }}
                                        </a>
                                    @elseif($history->lead)
                                        <a href="{{ route('leads-customers.show', $history->lead->id) }}"
                                            class="customer-link-warning">
                                            <i class="fas fa-user-clock ml-1"></i> {{ $history->lead->name }}
                                        </a>
                                    @else
                                        <span class="text-muted small">غير مرتبط بعميل</span>
                                    @endif
                                </td>

                                {{-- التاج الخاص بالنوع --}}
                                <td>
                                    @if ($history->customer)
                                        <span class="badge badge-pill badge-soft-primary px-3 py-2">عميل أساسي</span>
                                    @elseif($history->lead)
                                        <span class="badge badge-pill badge-soft-warning px-3 py-2">عميل محتمل</span>
                                    @else
                                        <span class="badge badge-pill badge-soft-secondary px-3 py-2">نظام</span>
                                    @endif
                                </td>

                                {{-- الوصف --}}
                                <td class="text-right py-3 text-muted-dark font-weight-500">
                                    {{ $history->description }}
                                </td>

                                {{-- التاريخ بتنسيق عصري --}}
                                <td class="py-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <span
                                            class="text-White font-weight-bold mb-0">{{ $history->created_at->format('Y-m-d') }}</span>
                                        <span class="text-muted small">{{ $history->created_at->format('H:i A') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-5 text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-folder-open fa-3x text-light-gray mb-3"></i>
                                        <h6 class="text-muted">لا توجد أي أنشطة مسجلة لهذا الموظف حتى الآن</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($histories, 'links'))
                <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-4">
                    {{ $histories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('css')
    <style>
        :root {
            --primary-navy: #1a237e;
            --accent-blue: #3f51b5;
            --soft-blue: rgba(63, 81, 181, 0.08);
            --soft-gold: rgba(255, 193, 7, 0.1);
            --text-muted: #64748b;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
        }

        /* الهيدر الموحد */
        .modern-header-card {
            background-color: #ffffff;
            border-right: 5px solid var(--accent-blue);
            border-radius: 15px;
        }

        /* تنسيق الجدول والمحتوى */
        .modern-table-card {
            background-color: #ffffff;
        }

        .thead-premium {
            background-color: #f1f5f9;
            color: var(--primary-navy);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .text-navy-title {
            color: var(--primary-navy);
        }

        .text-muted-dark {
            color: #475569;
        }

        /* روابط العملاء */
        .customer-link-primary {
            color: #0d6efd;
            font-weight: 700;
            text-decoration: none !important;
            transition: 0.2s;
        }

        .customer-link-warning {
            color: #f59e0b;
            font-weight: 700;
            text-decoration: none !important;
            transition: 0.2s;
        }

        .customer-link-primary:hover,
        .customer-link-warning:hover {
            opacity: 0.7;
            transform: translateX(-3px);
            display: inline-block;
        }

        /* البادجات الناعمة (Soft Badges) */
        .badge-soft-primary {
            background-color: var(--soft-blue);
            color: var(--accent-blue);
            border: 1px solid rgba(63, 81, 181, 0.15);
        }

        .badge-soft-warning {
            background-color: var(--soft-gold);
            color: #b45309;
            border: 1px solid rgba(245, 158, 11, 0.15);
        }

        .badge-soft-info {
            background-color: #f0fdfa;
            color: #0d9488;
            border: 1px solid #ccfbf1;
        }

        /* الدارك مود */
        .dark-mode .modern-header-card,
        .dark-mode .modern-table-card {
            background-color: #1c2437 !important;
            color: #fff;
        }

        .dark-mode .thead-premium {
            background-color: #242f48;
            color: #cbd5e1;
        }

        .dark-mode .header-title,
        .dark-mode .text-navy-title {
            color: #fff !important;
        }

        .dark-mode .text-muted-dark {
            color: #94a3b8;
        }

        .dark-mode .user-subtitle {
            color: #64748b;
        }

        .dark-mode .customer-link-primary {
            color: #60a5fa;
        }

        .dark-mode .customer-link-warning {
            color: #fbbf24;
        }

        .dark-mode .badge-soft-primary {
            background: rgba(96, 165, 250, 0.1);
            color: #60a5fa;
        }

        .dark-mode .badge-soft-info {
            background: rgba(45, 212, 191, 0.1);
            color: #2dd4bf;
            border: none;
        }

        .btn-back-modern {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            color: var(--text-muted);
            transition: 0.3s;
        }

        .dark-mode .btn-back-modern {
            background-color: #242f48;
            border-color: #334155;
            color: #fff;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .font-weight-500 {
            font-weight: 500;
        }
    </style>
@stop
