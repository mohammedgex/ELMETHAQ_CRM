@extends('adminlte::page')

@section('title', 'إحصائيات المندوبين للمجموعة: ' . $group->title)

@section('content_header')
    <h1>إحصائيات المندوبين للمجموعة: {{ $group->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <canvas id="delegatesChart" height="120"></canvas>
        </div>
    </div>

    <!-- جدول توضيحي أسفل الرسم البياني -->
    <div class="card mt-3">
        <div class="card-header">تفاصيل العملاء لكل مندوب</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>المندوب</th>
                        <th>عدد العملاء في المجموعة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($delegateNames as $index => $name)
                        <tr>
                            <td>{{ $name }}</td>
                            <td>{{ $customersCount[$index] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-3 border-0 shadow-sm">
        <div class="card-header bg-primary bg-gradient text-white fw-bold">
            <i class="fas fa-users-cog me-2"></i> إحصائيات حالات العملاء
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr class="text-uppercase small">
                            <th class="ps-4">الحالة</th>
                            <th class="text-center">عدد العملاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statusCounts as $item)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge rounded-pill bg-info-subtle text-info-emphasis border border-info">
                                        {{ $item->status ?: 'غير محددة' }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold">
                                    <span class="text-primary-emphasis">
                                        {{ number_format($item->total) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-active fw-bold">
                            <td class="ps-4 text-secondary">إجمالي جميع العملاء</td>
                            <td class="text-center text-primary fs-5">
                                {{ number_format($statusCounts->sum('total')) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3 border-0 shadow-sm">
        <div
            class="card-header bg-primary bg-gradient text-white fw-bold d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list-alt me-2"></i> قائمة ملاحظات العملاء</span>
            <span class="badge bg-white text-primary">إجمالي: {{ $customers->count() }} عميل</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr class="text-uppercase small">
                            <th class="ps-4" style="width: 25%;">اسم العميل</th>
                            <th class="text-center" style="width: 15%;">الحالة</th>
                            <th class="ps-3" style="width: 60%;">الملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="ps-4 fw-medium text-emphasis-secondary">
                                    {{ $customer->name_ar }}
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge rounded-pill {{ $customer->status ? 'bg-secondary-subtle text-secondary-emphasis border border-secondary' : 'bg-light text-muted' }}">
                                        {{ $customer->status ?: 'بدون حالة' }}
                                    </span>
                                </td>
                                <td class="ps-3">
                                    @if ($customer->notes)
                                        <div
                                            class="p-2 rounded bg-light-subtle border-start border-3 border-primary text-body-secondary small">
                                            {{ $customer->notes }}
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic small">لا توجد ملاحظات</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('delegatesChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($delegateNames),
                datasets: [{
                    label: 'عدد العملاء داخل المجموعة',
                    data: @json($customersCount),
                    backgroundColor: @json($colors),
                    borderColor: @json($borders),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        title: {
                            display: true,
                            text: 'عدد العملاء'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'المندوبين'
                        }
                    }
                }
            }
        });
    </script>
@stop
