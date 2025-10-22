@extends('adminlte::page')

@section('title', 'إحصائيات المندوبين للاختبار: ' . $test->title)

@section('content_header')
    <h1>إحصائيات المندوبين للاختبار: {{ $test->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <canvas id="delegatesChart" height="120"></canvas>
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
                        label: 'عدد العملاء',
                        data: @json($customersCount),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'عدد الناجحين',
                        data: @json($successCount),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
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
