@extends('adminlte::page')

@section('title', 'تعريف المستندات')

@section('content_header')
    <h3>مرفقات - {{ $client->name_ar}} </h3>
@stop

@section('content')

<button class="print-btn" onclick="window.print()">طباعة المرفقات</button>

        @foreach($client->documentTypes as $documentType)
        <div class="page">
            <h3>{{ $documentType->document_type ?? 'مرفق' }}</h3>
            <img src="{{ asset('storage/' . $documentType->file) }}" alt="{{ $documentType->document_type ?? 'مرفق' }}">
            <div class="footer my-2">
                <div class="footer d-flex justify-content-between" style="font-size: 12px;">
                    <span>التاريخ: {{ now()->format('Y-m-d') }}</span>
                    <span>الساعة: {{ now()->format('H:i') }}</span>
                    <span>اسم الموظف: {{ auth()->user()->name ?? '---' }}</span>
                </div>
            </div>
            <hr>
        </div>
        @endforeach

        

@stop

@section('css')
<style>
        body {
            font-family: 'Cairo';
            margin: 0;
            padding: 0;
        }

        

        .page {
            page-break-after: always;
            padding: 40px;
            text-align: center;
        }

        .page h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .page img {
            width: 600px;
            height: 600px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .footer {
    font-size: 12px;
    margin-top: 50px;
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
@extends('adminlte::page')

@section('title', 'تعريف المستندات')

@section('content_header')
<h3>مرفقات - {{ $client->name_ar}} </h3>
@stop

@section('content')

<button class="print-btn" onclick="window.print()">طباعة المرفقات</button>

<div class="page">
    <h3> الصورة الشخصية</h3>
    <img src="{{ asset('storage/' . $client->image) }}" alt="الصورة الشخصية">
    <div class="footer my-2">
        <div class="footer d-flex justify-content-between" style="font-size: 12px;">
            <span>التاريخ: {{ now()->format('Y-m-d') }}</span>
            <span>الساعة: {{ now()->format('H:i') }}</span>
            <span>اسم الموظف: {{ auth()->user()->name ?? '---' }}</span>
        </div>
    </div>
    <hr>
</div>

<div class="page">
    <h3>  جواز السفر</h3>
    <img src="{{ asset('storage/' . $client->mrz_image) }}" alt="الصورة الشخصية">
    <div class="footer my-2">
        <div class="footer d-flex justify-content-between" style="font-size: 12px;">
            <span>التاريخ: {{ now()->format('Y-m-d') }}</span>
            <span>الساعة: {{ now()->format('H:i') }}</span>
            <span>اسم الموظف: {{ auth()->user()->name ?? '---' }}</span>
        </div>
    </div>
    <hr>
</div>

@foreach($client->documentTypes as $documentType)
<div class="page">
    <h3>{{ $documentType->document_type ?? 'مرفق' }}</h3>
    <img src="{{ asset('storage/' . $documentType->file) }}" alt="{{ $documentType->document_type ?? 'مرفق' }}">
    <div class="footer my-2">
        <div class="footer d-flex justify-content-between" style="font-size: 12px;">
            <span>التاريخ: {{ now()->format('Y-m-d') }}</span>
            <span>الساعة: {{ now()->format('H:i') }}</span>
            <span>اسم الموظف: {{ auth()->user()->name ?? '---' }}</span>
        </div>
    </div>
    <hr>
</div>
@endforeach



@stop

@section('css')
<style>
    body {
        font-family: 'Cairo';
        margin: 0;
        padding: 0;
    }



    .page {
        page-break-after: always;
        padding: 40px;
        text-align: center;
    }

    .page h3 {
        margin-bottom: 20px;
        color: #333;
    }

    .page img {
        width: 600px;
        height: 600px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .print-btn {
        display: block;
        margin: 20px auto;
        padding: 12px 24px;
        background-color: #28a745;
        color: white;
        border: none;
        font-size: 18px;
        border-radius: 6px;
        cursor: pointer;
    }

    .footer {
        font-size: 12px;
        margin-top: 50px;
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