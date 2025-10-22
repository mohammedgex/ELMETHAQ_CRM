@extends('adminlte::page')

@section('title', 'احصائيات المناديب')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">احصائيات المناديب للاختبار: {{ $test->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header text-right" style="font-weight:bold;">
            عدد العملاء المرتبطين بكل مندوب في هذا الاختبار
        </div>
        <div class="card-body">
            <canvas id="delegateChart" height="120"></canvas>
        </div>
    </div>

    {{-- جدول بسيط لعرض الأرقام --}}
    <div class="card mt-4">
        <div class="card-header text-right" style="font-weight:bold;">تفاصيل البيانات</div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>اسم المندوب</th>
                        <th>عدد العملاء</th>
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

@section('css')
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('delegateChart').getContext('2d');
        const delegateChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($delegateNames),
                datasets: [{
                    label: 'عدد العملاء المرتبطين بالاختبار',
                    data: @json($customersCount),
                    backgroundColor: '#997a44',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'عدد العملاء لكل مندوب (للاختبار {{ $test->title }})',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@stop
