<!-- إحصائيات سريعة -->
<div class="row mb-3">
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h6 class="card-title">إجمالي الطلبات</h6>
                <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                @if (request('status') || request('priority') || request('search') || request('date_from') || request('date_to'))
                    <small class="text-light">مع الفلاتر المطبقة</small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h6 class="card-title">قيد الانتظار</h6>
                <h4 class="mb-0">{{ $stats['pending'] ?? 0 }}</h4>
                @if (request('status') || request('priority') || request('search') || request('date_from') || request('date_to'))
                    <small class="text-light">مع الفلاتر المطبقة</small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h6 class="card-title">قيد المعالجة</h6>
                <h4 class="mb-0">{{ $stats['in_progress'] ?? 0 }}</h4>
                @if (request('status') || request('priority') || request('search') || request('date_from') || request('date_to'))
                    <small class="text-light">مع الفلاتر المطبقة</small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h6 class="card-title">مكتمل</h6>
                <h4 class="mb-0">{{ $stats['completed'] ?? 0 }}</h4>
                @if (request('status') || request('priority') || request('search') || request('date_from') || request('date_to'))
                    <small class="text-light">مع الفلاتر المطبقة</small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h6 class="card-title">مرفوض</h6>
                <h4 class="mb-0">{{ $stats['rejected'] ?? 0 }}</h4>
                @if (request('status') || request('priority') || request('search') || request('date_from') || request('date_to'))
                    <small class="text-light">مع الفلاتر المطبقة</small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h6 class="card-title">عاجل</h6>
                <h4 class="mb-0">{{ $stats['urgent'] ?? 0 }}</h4>
                @if (request('status') || request('priority') || request('search') || request('date_from') || request('date_to'))
                    <small class="text-light">مع الفلاتر المطبقة</small>
                @endif
            </div>
        </div>
    </div>
</div>
