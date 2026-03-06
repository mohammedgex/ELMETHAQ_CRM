@extends('adminlte::page')

@section('title', 'كشف الحساب اليومي')

@section('content_header')
    <h1 class="m-0 text-dark">تقرير يومية: <span class="badge badge-info">{{ $date }}</span></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box bg-danger shadow-sm">
                <span class="info-box-icon"><i class="fas fa-arrow-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">إجمالي المدين (خارج)</span>
                    <span class="info-box-number">{{ number_format($totalDebit, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box bg-success shadow-sm">
                <span class="info-box-icon"><i class="fas fa-arrow-down"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">إجمالي الدائن (داخل)</span>
                    <span class="info-box-number">{{ number_format($totalCredit, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-12">
            <div class="info-box {{ $netBalance >= 0 ? 'bg-primary' : 'bg-warning' }} shadow-sm">
                <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">صافي الحركة اليومية</span>
                    <span class="info-box-number">{{ number_format($netBalance, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h3 class="card-title text-bold"><i class="fas fa-search mr-1"></i> تصفية سريعة</h3>
        </div>
        <form action="{{ route('accounts.day') }}" method="GET">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>اختر تاريخ المعاملات:</label>
                        <input type="date" name="date" class="form-control border-primary"
                            value="{{ $date }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block text-bold">
                            تحديث البيانات <i class="fas fa-sync-alt ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-valign-middle mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="50px">#</th>
                            <th>العميل</th>
                            <th class="text-center">مدين</th>
                            <th class="text-center">دائن</th>
                            <th>الوصف</th>
                            <th class="text-center">الوقت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $account->customer->image) ?? asset('vendor/adminlte/dist/img/user-placeholder.jpg') }}"
                                        class="img-circle img-size-32 mr-2 border shadow-sm" alt="User Image">
                                    <span class="text-bold">{{ $account->customer->name_ar ?? 'غير معروف' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-pill badge-outline-danger px-3 py-2"
                                        style="font-size: 0.9rem; border: 1px solid #dc3545; color: #dc3545;">
                                        {{ number_format($account->debit, 2) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-pill badge-outline-success px-3 py-2"
                                        style="font-size: 0.9rem; border: 1px solid #28a745; color: #28a745;">
                                        {{ number_format($account->credit, 2) }}
                                    </span>
                                </td>
                                <td><small class="text-muted text-bold">{{ $account->description ?? '---' }}</small></td>
                                <td class="text-center text-secondary">
                                    <i class="far fa-clock mr-1"></i> {{ $account->created_at->format('h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80"
                                        class="mb-3 opacity-50">
                                    <p class="text-muted">لا توجد معاملات مسجلة لهذا اليوم!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* تحسينات للدارك مود */
        .dark-mode .card {
            background-color: #343a40;
            color: #fff;
        }

        .dark-mode .table thead {
            background-color: #212529;
        }

        .dark-mode .text-muted {
            color: #adb5bd !important;
        }

        /* تأثير عند التمرير على الجدول */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .075);
            transition: 0.3s;
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, .05);
        }

        /* تنسيق البادج الشفاف */
        .badge-outline-danger {
            background: transparent;
            color: #dc3545;
            font-weight: bold;
        }

        .badge-outline-success {
            background: transparent;
            color: #28a745;
            font-weight: bold;
        }
    </style>
@stop
