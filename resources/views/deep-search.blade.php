@extends('adminlte::page')

@section('title', 'البحث العميق')

@section('content_header')
    <div class="d-flex justify-content-center mt-3">
        <h1 class="font-weight-bold shadow-sm p-3 bg-white rounded-pill border border-primary text-primary"
            style="min-width: 300px; text-align: center;">
            <i class="fas fa-search-plus ml-2"></i> البحث العميق
        </h1>
    </div>
@stop

@section('content')
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h5 class="card-title m-0 font-weight-bold"><i class="fas fa-filter ml-1"></i> خيارات البحث</h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form id="searchForm" class="row g-3 text-right" method="POST" action="{{ route('deepSearchFN') }}">
                @csrf

                <div class="col-md-3">
                    <label for="searchType" class="form-label font-weight-bold">طريقة البحث</label>
                    <select name="searchType" id="searchType" class="form-control custom-select border-primary shadow-sm">
                        <option value="">-- اختر طريقة البحث --</option>
                        <option value="name" {{ request('searchType') == 'name' ? 'selected' : '' }}>الاسم</option>
                        <option value="passport" {{ request('searchType') == 'passport' ? 'selected' : '' }}>رقم الجواز
                        </option>
                        <option value="nid" {{ request('searchType') == 'nid' ? 'selected' : '' }}>الرقم القومي</option>
                        <option value="phone" {{ request('searchType') == 'phone' ? 'selected' : '' }}>رقم الهاتف</option>
                    </select>
                </div>

                {{-- الحقول (لم يتم تغيير الـ IDs لضمان عمل JS) --}}
                <div class="col-md-5 search-field" id="searchByName" style="display:none;">
                    <label for="name" class="form-label font-weight-bold">الاسم المطلوب</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}"
                        class="form-control border-info" placeholder="اكتب الاسم هنا...">
                </div>

                <div class="col-md-5 search-field" id="searchByPassport" style="display:none;">
                    <label for="passport" class="form-label font-weight-bold">رقم الجواز</label>
                    <input type="text" name="passport" id="passport" value="{{ request('passport') }}"
                        class="form-control border-info" placeholder="مثال: A12345678">
                </div>

                <div class="col-md-5 search-field" id="searchByNID" style="display:none;">
                    <label for="nid" class="form-label font-weight-bold">الرقم القومي</label>
                    <input type="text" name="nid" id="nid" value="{{ request('nid') }}"
                        class="form-control border-info" placeholder="14 رقم">
                </div>

                <div class="col-md-5 search-field" id="searchByPhone" style="display:none;">
                    <label for="phone" class="form-label font-weight-bold">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone" value="{{ request('phone') }}"
                        class="form-control border-info" placeholder="01xxxxxxxxx">
                </div>

                <div class="col-md-4 d-flex align-items-end mt-3">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm ml-2">
                        <i class="fas fa-search"></i> تنفيذ البحث
                    </button>
                    <button type="reset" class="btn btn-outline-secondary px-4 shadow-sm">
                        <i class="fas fa-sync-alt"></i> إعادة تعيين
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 🟢 جدول العملاء --}}
    @if (isset($customers) && $customers->count() > 0)
        <div class="card card-success card-outline shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold text-success"><i class="fas fa-users ml-1"></i> نتائج العملاء المحققين</h5>
                <span class="badge badge-success px-3 py-2">{{ $customers->count() }} نتيجة</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped text-center mb-0">
                        <thead class="bg-light">
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
                                    <td class="align-middle font-weight-bold">{{ $index + 1 }}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('customer.add', $c->id) }}"
                                            class="text-bold text-primary">{{ $c->name_ar }}</a>
                                    </td>
                                    <td class="align-middle"><span
                                            class="badge badge-light border">{{ $c->passport_id ?? '-' }}</span></td>
                                    <td class="align-middle">{{ $c->card_id ?? '-' }}</td>
                                    <td class="align-middle text-ltr">{{ $c->phone ?? '-' }}</td>
                                    <td class="align-middle">
                                        @if ($c->customerGroup)
                                            <a href="{{ route('group.customer', $c->customerGroup->id) }}"
                                                class="btn btn-sm btn-outline-info">
                                                {{ $c->customerGroup->title }}
                                            </a>
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
        </div>
    @endif

    {{-- 🟦 جدول العملاء المحتملين --}}
    @if (isset($leads) && $leads->count() > 0)
        <div class="card card-info card-outline shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold text-info"><i class="fas fa-user-clock ml-1"></i> نتائج العملاء المحتملين
                    (Leads)</h5>
                <span class="badge badge-info px-3 py-2">{{ $leads->count() }} نتيجة</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped text-center mb-0">
                        <thead class="bg-light">
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
                                    <td class="align-middle font-weight-bold">{{ $index + 1 }}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('leads-customers.show', $l->id) }}"
                                            class="text-bold text-info">{{ $l->name }}</a>
                                    </td>
                                    <td class="align-middle"><span
                                            class="badge badge-light border">{{ $l->passport_numder ?? '-' }}</span></td>
                                    <td class="align-middle">{{ $l->card_id ?? '-' }}</td>
                                    <td class="align-middle text-ltr">{{ $l->phone ?? '-' }}</td>
                                    <td class="align-middle">
                                        @if ($l->tests->count())
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-info dropdown-toggle shadow-sm"
                                                    data-toggle="dropdown">
                                                    {{ $l->tests->count() }} اختبارات
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @foreach ($l->tests as $test)
                                                        <a class="dropdown-item text-right"
                                                            href="{{ route('test.leads', $test->id) }}">
                                                            <i class="fas fa-file-alt ml-1 text-secondary"></i>
                                                            {{ $test->title }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">لا يوجد</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if (isset($customers) && isset($leads) && $customers->count() === 0 && $leads->count() === 0)
        <div class="alert alert-custom bg-white border-warning text-center shadow-sm mt-4">
            <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
            <h5 class="font-weight-bold">عذراً، لم نجد شيئاً!</h5>
            <p class="mb-0">تأكد من اختيار طريقة البحث الصحيحة وإدخال البيانات بدقة.</p>
        </div>
    @endif
@stop

@section('css')
    <style>
        /* تحسينات عامة ودعم الوضع الليلي */
        body {
            direction: rtl;
            text-align: right;
        }

        /* توافق الدارك مود الخاص بـ AdminLTE */
        .dark-mode .card {
            background-color: #343a40 !important;
            color: #fff;
        }

        .dark-mode .bg-light {
            background-color: #454d55 !important;
            color: #fff !important;
        }

        .dark-mode .table {
            color: #fff;
        }

        .dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, .05);
        }

        .dark-mode .alert-custom {
            background-color: #3f474e !important;
            border-right: 5px solid #ffc107;
        }

        /* تأثيرات الهوفر */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .075);
            transition: 0.3s;
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, .1);
        }

        /* تنسيق القوائم المنسدلة */
        .dropdown-item {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }

        .text-ltr {
            direction: ltr;
            display: inline-block;
        }

        /* تحسين شكل الحقول */
        .form-control:focus {
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
            border-color: #80bdff;
        }

        .card-outline {
            border-top: 4px solid;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // الكود الأصلي الخاص بك بدون أي تعديل في المنطق
            const initialType = $('#searchType').val();
            if (initialType) {
                $('.search-field').hide();
                if (initialType === 'name') $('#searchByName').show();
                else if (initialType === 'passport') $('#searchByPassport').show();
                else if (initialType === 'nid') $('#searchByNID').show();
                else if (initialType === 'phone') $('#searchByPhone').show();
            }

            $('#searchType').on('change', function() {
                $('.search-field').hide();
                const type = $(this).val();
                if (type === 'name') $('#searchByName').show();
                else if (type === 'passport') $('#searchByPassport').show();
                else if (type === 'nid') $('#searchByNID').show();
                else if (type === 'phone') $('#searchByPhone').show();
            });

            $('#searchForm').on('reset', function() {
                setTimeout(() => {
                    $('#searchType').val('').trigger('change');
                    $('.search-field').hide();
                }, 100);
            });
        });
    </script>
@stop
