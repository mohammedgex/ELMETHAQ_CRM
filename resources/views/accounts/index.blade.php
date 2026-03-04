@extends('adminlte::page')

@section('title', 'كشف حساب العميل')
@section('content')
    <div class="container">
        <h3>كشف حساب العميل: {{ $customer->name_ar ?? '---' }}</h3>

        <a href="{{ route('accounts.create', $customer->id) }}" class="btn btn-primary mb-3">
            إضافة عملية جديدة
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>التاريخ</th>
                    <th>مدين</th>
                    <th>دائن</th>
                    <th>الوصف</th>
                    <th width="100">إجراء</th> {{-- عمود جديد --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->created_at->format('d-m-Y | H:i') }}</td>
                        <td>{{ number_format($account->debit, 2) }}</td>
                        <td>{{ number_format($account->credit, 2) }}</td>
                        <td>{{ $account->description }}</td>

                        <td>
                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا القيد؟');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="bg-light font-weight-bold">
                    <td>الإجمالي</td>
                    <td>{{ number_format($totalDebit, 2) }}</td>
                    <td>{{ number_format($totalCredit, 2) }}</td>
                    <td></td>
                </tr>

                <tr class="text-black font-weight-bold">
                    <td>الرصيد الحالي</td>
                    <td colspan="3">
                        <span class="{{ $balance > 0 ? 'text-success' : 'text-danger' }}" style="font-size: 1.2em;">
                            {{ number_format($balance, 2) }}
                        </span>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>
@endsection
