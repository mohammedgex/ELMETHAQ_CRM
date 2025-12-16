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
