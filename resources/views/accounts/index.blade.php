@extends('adminlte::page')

@section('title', 'كشف حساب تفصيلي')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="text-bold">كشف حساب: <span class="text-primary">{{ $customer->name_ar }}</span></h1>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('accounts.create', $customer->id) }}" class="btn btn-success shadow-sm mr-2">
                <i class="fas fa-plus-circle"></i> عملية جديدة
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-print"></i> طباعة الكشف
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card card-outline card-primary shadow-sm custom-card">
                <div class="card-body box-profile">
                    <div class="text-center position-relative">
                        <img class="profile-user-img img-fluid img-circle shadow border-3"
                            src="{{ $customer->image ? asset('storage/' . $customer->image) : asset('vendor/adminlte/dist/img/user-placeholder.jpg') }}"
                            style="width: 110px; height: 110px; object-fit: cover; border-color: #3c8dbc;"
                            alt="صورة العميل">
                    </div>
                    <h3 class="profile-username text-center mt-3 text-bold">{{ $customer->name_ar }}</h3>
                    <p class="text-muted text-center mb-3">كود العميل: #{{ $customer->id }}</p>

                    <hr class="my-3">

                    <div class="payment-titles-section mb-4">
                        <h6 class="text-bold mb-2"><i class="fas fa-file-invoice-dollar mr-1"></i> بنود مستحقة:</h6>
                        <div class="d-flex flex-wrap">
                            @php $totalTitlesPrice = 0; @endphp
                            @forelse ($customer->paymentTitles as $payment)
                                @php $totalTitlesPrice += $payment->price; @endphp
                                <span
                                    class="badge badge-pill custom-item-badge mb-1 mr-1 p-2 border {{ $payment->price < 0 ? 'text-danger border-danger' : 'text-primary border-primary' }}"
                                    style="background: transparent; font-size: 0.85rem;">
                                    {{ $payment->title }}
                                    <span class="item-price text-bold">({{ number_format($payment->price, 2) }})</span>
                                </span>
                            @empty
                                <span class="text-muted small italic w-100 border p-2 rounded text-center">
                                    <i class="fas fa-info-circle mr-1"></i> لا توجد بنود سداد مسجلة
                                </span>
                            @endforelse
                        </div>
                        @if ($customer->paymentTitles->isNotEmpty())
                            <div class="mt-2 text-right">
                                <small class="text-muted">إجمالي البنود:</small>
                                <span class="text-bold {{ $totalTitlesPrice < 0 ? 'text-danger' : 'text-dark' }}">
                                    {{ number_format($totalTitlesPrice, 2) }} ج.م
                                </span>
                            </div>
                        @endif
                    </div>

                    <hr class="my-3">

                    <div class="summary-item mb-2 p-2 rounded bg-light-custom border-left border-danger">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted font-weight-bold">إجمالي مدين</span>
                            <span class="text-danger text-bold">{{ number_format($totalDebit, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item mb-3 p-2 rounded bg-light-custom border-left border-success">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted font-weight-bold">إجمالي دائن</span>
                            <span class="text-success text-bold">{{ number_format($totalCredit, 2) }}</span>
                        </div>
                    </div>

                    <div
                        class="summary-item p-3 rounded shadow-sm {{ $balance >= 0 ? 'bg-success-light border border-success' : 'bg-danger-light border border-danger' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-bold d-block">الرصيد الحالي</span>
                                <small
                                    class="opacity-75">{{ $balance >= 0 ? 'رصيد دائن (له)' : 'رصيد مدين (عليه)' }}</small>
                            </div>
                            <span class="h4 mb-0 text-bold">{{ number_format($balance, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-8">
            <div class="card shadow-sm custom-card">
                <div class="card-header border-0 d-flex align-items-center">
                    <h3 class="card-title text-bold"><i class="fas fa-history mr-2"></i> سجل التحركات المالية</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="pl-4">التاريخ</th>
                                    <th>البيان</th>
                                    <th class="text-center">مدين (-)</th>
                                    <th class="text-center">دائن (+)</th>
                                    <th class="text-center">الرصيد</th>
                                    <th class="text-center">إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $runningBalance = 0; @endphp
                                @forelse ($accounts as $account)
                                    @php $runningBalance += ($account->credit - $account->debit); @endphp
                                    <tr>
                                        <td class="pl-4">
                                            <div class="text-bold mb-0 small">{{ $account->created_at->format('d-m-Y') }}
                                            </div>
                                            <div class="text-muted extra-small">{{ $account->created_at->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="description-text font-weight-500">
                                                {{ $account->description ?: 'إجراء مالي عام' }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="{{ $account->debit > 0 ? 'text-danger-custom text-bold' : 'text-muted opacity-50' }}">
                                                {{ $account->debit > 0 ? number_format($account->debit, 2) : '0.00' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="{{ $account->credit > 0 ? 'text-success-custom text-bold' : 'text-muted opacity-50' }}">
                                                {{ $account->credit > 0 ? number_format($account->credit, 2) : '0.00' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $runningBalance >= 0 ? 'bg-primary-soft text-primary' : 'bg-warning-soft text-warning' }} px-3 py-2 rounded-pill">
                                                {{ number_format($runningBalance, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-link text-danger p-0"
                                                    onclick="return confirm('تنبيه: حذف القيد سيؤثر على الرصيد التراكمي!')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted small italic">لا يوجد سجل
                                            معاملات لهذا العميل حتى الآن.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* --- ألوان مخصصة تدعم الوضعين --- */

        /* خلفيات خفيفة للعناصر في الوضع الفاتح */
        .bg-light-custom {
            background-color: #f8f9fa;
        }

        .bg-success-light {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .bg-danger-light {
            background-color: #ffebee;
            color: #c62828;
        }

        .thead-custom {
            background-color: #f4f6f9;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }

        /* الوضع المظلم (Dark Mode) */
        .dark-mode .custom-card {
            background-color: #2b3035 !important;
            border: 1px solid #3d4348;
        }

        .dark-mode .bg-light-custom {
            background-color: #343a40 !important;
        }

        .dark-mode .bg-success-light {
            background-color: rgba(40, 167, 69, 0.15) !important;
            color: #48bb78;
        }

        .dark-mode .bg-danger-light {
            background-color: rgba(220, 53, 69, 0.15) !important;
            color: #f56565;
        }

        .dark-mode .thead-custom {
            background-color: #1a1e21;
            color: #ced4da;
            border-color: #3d4348;
        }

        .dark-mode .text-muted {
            color: #a0aec0 !important;
        }

        .dark-mode .table td {
            border-top: 1px solid #3d4348;
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        /* ألوان النصوص المالية */
        .text-danger-custom {
            color: #e53e3e;
        }

        .text-success-custom {
            color: #38a169;
        }

        .dark-mode .text-danger-custom {
            color: #fc8181;
        }

        .dark-mode .text-success-custom {
            color: #68d391;
        }

        /* تنسيق البادج الشفاف للرصيد */
        .bg-primary-soft {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .bg-warning-soft {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .dark-mode .bg-primary-soft {
            background-color: rgba(66, 153, 225, 0.2);
        }

        .dark-mode .bg-warning-soft {
            background-color: rgba(236, 159, 5, 0.2);
        }

        /* إضافات جمالية */
        .extra-small {
            font-size: 0.75rem;
        }

        .description-text {
            font-size: 0.95rem;
            line-height: 1.4;
            color: #2d3748;
        }

        .dark-mode .description-text {
            color: #e2e8f0;
        }

        .table td {
            vertical-align: middle !important;
        }

        /* تنسيق الطباعة */
        @media print {

            .btn,
            .main-sidebar,
            .main-footer,
            .card-header .btn {
                display: none !important;
            }

            .content-wrapper {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .custom-card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }

            .bg-light-custom,
            .bg-success-light,
            .bg-danger-light {
                background: transparent !important;
                border: 1px solid #eee;
            }
        }
    </style>
@stop
