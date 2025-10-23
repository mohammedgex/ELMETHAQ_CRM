@extends('adminlte::page')

@section('title', 'البحث العميق')

@section('content_header')
    <h1 class="text-right font-weight-bold text-center">
        البحث العميق</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white text-left">
            <h5 class="mb-0">خيارات البحث</h5>
        </div>
        <div class="card-body">
            <form id="searchForm" class="row g-3 text-right" method="POST" action="{{ route('deepSearchFN') }}">
                @csrf

                <div class="col-md-3">
                    <label for="searchType" class="form-label">طريقة البحث</label>
                    <select name="searchType" id="searchType" class="form-control">
                        <option value="">-- اختر --</option>
                        <option value="name" {{ request('searchType') == 'name' ? 'selected' : '' }}>الاسم</option>
                        <option value="passport" {{ request('searchType') == 'passport' ? 'selected' : '' }}>رقم الجواز
                        </option>
                        <option value="nid" {{ request('searchType') == 'nid' ? 'selected' : '' }}>الرقم القومي</option>
                        <option value="phone" {{ request('searchType') == 'phone' ? 'selected' : '' }}>رقم الهاتف</option>
                    </select>
                </div>

                {{-- البحث بالاسم --}}
                <div class="col-md-3 search-field" id="searchByName" style="display:none;">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}" class="form-control"
                        placeholder="ابحث بالاسم">
                </div>

                {{-- البحث برقم الجواز --}}
                <div class="col-md-3 search-field" id="searchByPassport" style="display:none;">
                    <label for="passport" class="form-label">رقم الجواز</label>
                    <input type="text" name="passport" id="passport" value="{{ request('passport') }}"
                        class="form-control" placeholder="ابحث برقم الجواز">
                </div>

                {{-- البحث بالرقم القومي --}}
                <div class="col-md-3 search-field" id="searchByNID" style="display:none;">
                    <label for="nid" class="form-label">الرقم القومي</label>
                    <input type="text" name="nid" id="nid" value="{{ request('nid') }}" class="form-control"
                        placeholder="ابحث بالرقم القومي">
                </div>

                {{-- البحث برقم الهاتف --}}
                <div class="col-md-3 search-field" id="searchByPhone" style="display:none;">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone" value="{{ request('phone') }}" class="form-control"
                        placeholder="ابحث برقم الهاتف">
                </div>

                <div class="col-12 text-left mt-3">
                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> بحث</button>
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> تفريغ</button>
                </div>
            </form>

        </div>
    </div>

    {{-- 🟢 جدول العملاء --}}
    @if (isset($customers) && $customers->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-success text-white text-left">
                <h5 class="mb-0">نتائج العملاء</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>رقم الجواز</th>
                            <th>الرقم القومي</th>
                            <th>رقم الهاتف</th>
                            <th>المجموعة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $index => $c)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="{{ route('customer.add', $c->id) }}">{{ $c->name_ar }}</a></td>
                                <td>{{ $c->passport_id ?? '-' }}</td>
                                <td>{{ $c->card_id ?? '-' }}</td>
                                <td>{{ $c->phone ?? '-' }}</td>
                                <td>
                                    @if ($c->customerGroup)
                                        <a href="{{ route('group.customer', $c->customerGroup->id) }}">
                                            {{ $c->customerGroup->title ?? '-' }}
                                        </a>
                                    @else
                                        {{ $c->customerGroup->title ?? '-' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- 🟦 جدول العملاء المحتملين --}}
    @if (isset($leads) && $leads->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-info text-white text-left">
                <h5 class="mb-0">نتائج العملاء المحتملين</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>رقم الجواز</th>
                            <th>الرقم القومي</th>
                            <th>رقم الهاتف</th>
                            <th>الاختبارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $index => $l)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="{{ route('leads-customers.show', $l->id) }}" class="">
                                        {{ $l->name }} </a></td>
                                <td>{{ $l->passport_numder ?? '-' }}</td>
                                <td>{{ $l->card_id ?? '-' }}</td>
                                <td>{{ $l->phone ?? '-' }}</td>
                                <td>
                                    @if ($l->tests->count())
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                {{ $l->tests->count() }}
                                            </a>
                                            <div class="dropdown-menu">
                                                @foreach ($l->tests as $test)
                                                    <a class="dropdown-item" title="{{ $test->title }}"
                                                        href="{{ route('test.leads', $test->id) }}">
                                                        {{ $test->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- 🚫 في حالة لا توجد نتائج --}}
    @if (isset($customers) && isset($leads) && $customers->count() === 0 && $leads->count() === 0)
        <div class="alert alert-warning text-center mt-4">لا توجد نتائج مطابقة لعملية البحث.</div>
    @endif
@stop

@section('css')
    {{-- دعم RTL وتحسين المظهر --}}
    <style>
        /* body {
                                    direction: rtl;
                                    text-align: left;
                                }

                                .dataTables_filter,
                                .dataTables_info {
                                    text-align: left !important;
                                } */

        .dropdown-item {
            max-width: 250px;
            /* العرض الأقصى */
            white-space: nowrap;
            /* يمنع نزول النص لسطر جديد */
            overflow: hidden;
            /* يخفي الجزء الزائد */
            text-overflow: ellipsis;
            /* يضيف ... عند الزيادة */
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {

            // عند تحميل الصفحة، أظهر الحقل المناسب (لو فيه قيمة محفوظة)
            const initialType = $('#searchType').val();
            if (initialType) {
                $('.search-field').hide();
                if (initialType === 'name') $('#searchByName').show();
                else if (initialType === 'passport') $('#searchByPassport').show();
                else if (initialType === 'nid') $('#searchByNID').show();
                else if (initialType === 'phone') $('#searchByPhone').show();
            }

            // تغيير طريقة البحث
            $('#searchType').on('change', function() {
                $('.search-field').hide();
                const type = $(this).val();
                if (type === 'name') $('#searchByName').show();
                else if (type === 'passport') $('#searchByPassport').show();
                else if (type === 'nid') $('#searchByNID').show();
                else if (type === 'phone') $('#searchByPhone').show();
            });

            // عند إعادة تعيين الفورم
            $('#searchForm').on('reset', function() {
                setTimeout(() => {
                    $('#searchType').val('');
                    $('.search-field').hide();
                }, 100);
            });
        });
    </script>
@stop
