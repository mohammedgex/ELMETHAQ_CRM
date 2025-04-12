@extends('adminlte::page')

@section('title', 'تفاصيل المدفوعات')

@section('content_header')
    <h3>مدفوعات - {{ $client->name_ar }}</h3>
@stop

@section('content')

<button class="print-btn" onclick="window.print()">طباعة المدفوعات</button>

@foreach($client->payments as $payment)
    <div class="payment-box">
        <h4>{{ $payment->paymentTitle->title ?? 'دفعة' }}</h4>
        <p><strong>المبلغ:</strong> {{ number_format($payment->amount, 2) }} جنيه</p>
        <p><strong>التاريخ:</strong> {{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d') }}</p>
        <p><strong>الوقت:</strong> {{ \Carbon\Carbon::parse($payment->created_at)->format('H:i') }}</p>
        <p><strong>المتبقي:</strong> {{ number_format($payment->remaining, 2) }} جنيه</p>
    </div>
@endforeach

@endsection

@section('css')
<style>
    body {
        font-family: 'Cairo';
        margin: 0;
        padding: 0;
    }

    .payment-box {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin: 20px auto;
        max-width: 700px;
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        page-break-inside: avoid;
    }

    .payment-box h4 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 20px;
    }

    .payment-box p {
        margin: 5px 0;
        font-size: 16px;
        color: #333;
    }

    .print-btn {
        display: block;
        margin: 20px auto;
        padding: 12px 24px;
        background-color: #007bff;
        color: white;
        border: none;
        font-size: 18px;
        border-radius: 6px;
        cursor: pointer;
    }

    @media print {
        .print-btn {
            display: none;
        }
    }
</style>
@stop

@section('js')
@endsection
