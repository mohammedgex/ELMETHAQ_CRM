@extends('adminlte::page')

@section('title', 'سجل الموظف')

@section('content_header')
    <h1 class="fw-bold">📜 سجل الموظف ({{ $user->name }})</h1>
@stop

@section('content')
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-dark text-white">
            <h3 class="card-title mb-0">قائمة السجل</h3>
        </div>

        <div class="card-body p-3 table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">اسم الموظف</th>
                        <th scope="col">اسم العميل</th>
                        <th scope="col">النوع</th>
                        <th scope="col">الوصف</th>
                        <th scope="col">تاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                        <tr>
                            {{-- اسم الموظف --}}
                            <td class="fw-semibold">{{ $history->user->name ?? '-' }}</td>

                            {{-- اسم العميل أو العميل المحتمل --}}
                            <td>
                                @if ($history->customer)
                                    <a href="{{ route('customer.show', $history->customer->id) }}"
                                        class="text-decoration-none text-primary fw-bold">
                                        {{ $history->customer->name_ar }}
                                    </a>
                                @elseif($history->lead)
                                    <a href="{{ route('leads-customers.show', $history->lead->id) }}"
                                        class="text-decoration-none text-warning fw-bold">
                                        {{ $history->lead->name }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- النوع --}}
                            <td>
                                @if ($history->customer)
                                    <span class="badge bg-primary">عميل أساسي</span>
                                @elseif($history->lead)
                                    <span class="badge bg-warning text-dark">عميل محتمل</span>
                                @else
                                    <span class="badge bg-secondary">غير محدد</span>
                                @endif
                            </td>

                            {{-- الوصف --}}
                            <td class="text-muted">{{ $history->description }}</td>

                            {{-- التاريخ --}}
                            <td class="text-secondary">{{ $history->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted py-4">لا توجد تقييمات حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- 
        @if (method_exists($histories, 'links'))
            <div class="card-footer clearfix">
                {{ $histories->links() }}
            </div>
        @endif --}}
    </div>
@stop
