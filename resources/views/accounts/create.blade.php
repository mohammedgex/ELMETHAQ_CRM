@extends('adminlte::page')

@section('title', 'إضافة عملية للعميل')
@section('content')
    <div class="container">
        <h3>إضافة عملية للعميل: {{ $customer->name_ar ?? '' }}</h3>

        <form method="POST" action="{{ route('accounts.store') }}">
            @csrf

            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

            <div class="mb-3">
                <label>مدين</label>
                <input type="number" step="0.01" name="debit" class="form-control">
            </div>

            <div class="mb-3">
                <label>دائن</label>
                <input type="number" step="0.01" name="credit" class="form-control">
            </div>

            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">حفظ</button>
            <a href="{{ route('accounts.index', $customer->id) }}" class="btn btn-secondary">رجوع</a>

        </form>
    </div>
@endsection
