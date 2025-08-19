@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <h1 style="font-weight:bold">لوحة التحكم</h1>
@stop
@section('content')
    <div class="container-fluid">
        <!-- بطاقات الإحصائيات -->
        <div class="row">
            <div class="col-lg-2 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $customers->count() }}</h3>
                        <p>إجمالي العملاء</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <a href="{{ route('leads-customers.index') }}" class="small-box-footer">المزيد <i
                            class="fas fa-arrow-circle-left"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $delegates->count() }}</h3>
                        <p>إجمالي المناديب</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <a href="{{ route('Delegates.create') }}" class="small-box-footer">المزيد <i
                            class="fas fa-arrow-circle-left"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $groups->count() }}</h3>
                        <p>إجمالي المجموعات</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('customer-groups.create') }}" class="small-box-footer">المزيد <i
                            class="fas fa-arrow-circle-left"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $users->count() }}</h3>
                        <p>إجمالي الموظفين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('users') }}" class="small-box-footer">المزيد <i
                            class="fas fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box" style="background: linear-gradient(135deg, #6f42c1, #8e63d4); color: white;">
                    <div class="inner">
                        <h3>{{ $visas->count() }}</h3>
                        <p>إجمالي التأشيرات</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-passport"></i>
                    </div>
                    <a href="{{ route('visa-type.index') }}" class="small-box-footer" style="color: white;">
                        المزيد <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box" style="background: linear-gradient(135deg, #ff7f50, #ff9966); color: white;">
                    <div class="inner">
                        <h3>{{ $bags->count() }}</h3>
                        <p>إجمالي الحقائب</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <a href="{{ route('bags.index') }}" class="small-box-footer" style="color: white;">
                        المزيد <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- قسم الاختبارات -->
        <div class="card card-primary card-outline position-relative">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">الاختبارات ({{ $tests->count() }})</h3>
                <div>
                    <button id="scrollRight" class="btn btn-light btn-sm"><i class="fas fa-chevron-right"></i></button>
                    <button id="scrollLeft" class="btn btn-light btn-sm me-1"><i class="fas fa-chevron-left"></i></button>
                </div>
            </div>

            <div class="card-body position-relative">
                <!-- الحاوية اللي فيها الكروت -->
                <div id="testsContainer" class="d-flex flex-row flex-nowrap overflow-auto"
                    style="gap: 20px; scroll-behavior: smooth; padding: 10px 40px;">

                    @foreach ($tests as $test)
                        @php
                            $latestEvaluations = \App\Models\Evaluation::select(
                                'lead_id',
                                \DB::raw('MAX(created_at) as latest_date'),
                            )
                                ->where('test_id', $test->id)
                                ->groupBy('lead_id');

                            $latestEvaluationIds = \App\Models\Evaluation::where('test_id', $test->id)
                                ->joinSub($latestEvaluations, 'latest', function ($join) {
                                    $join
                                        ->on('evaluations.lead_id', '=', 'latest.lead_id')
                                        ->on('evaluations.created_at', '=', 'latest.latest_date');
                                })
                                ->pluck('evaluations.id');

                            $latestEvaluationsRecords = \App\Models\Evaluation::whereIn(
                                'id',
                                $latestEvaluationIds,
                            )->get();

                            $acceptedCount = $latestEvaluationsRecords->where('evaluation', 'مقبول')->count();
                            $rejectedCount = $latestEvaluationsRecords->where('evaluation', 'غير مقبول')->count();
                            $reserveCount = $latestEvaluationsRecords->where('evaluation', 'احتياطي')->count();
                            $totalLeads = $latestEvaluationsRecords->count();
                        @endphp

                        <div class="col-md-3 col-6 mb-4" style="min-width: 280px;">
                            <a href="{{ route('test.leads', $test->id) }}" class="text-decoration-none">
                                <div class="info-box bg-gradient-primary text-white shadow rounded p-2">
                                    <span
                                        class="info-box-icon bg-primary d-flex align-items-center justify-content-center rounded">
                                        <i class="fas fa-file-alt fa-lg"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <h5 class="fw-bold mb-2 text-truncate">{{ $test->title }}</h5>

                                        <div class="d-flex justify-content-between align-items-center mb-2 px-3 py-1 rounded"
                                            style="background-color: #e2e3e5; color :#000">
                                            <span class="small">العملاء:</span>
                                            <span
                                                class="fw-semibold bg-primary text-white px-2 py-1 rounded">{{ $totalLeads }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-2 px-3 py-1 rounded"
                                            style="background-color: #d4edda; color: #155724;">
                                            <small>مقبولين</small>
                                            <small class="fw-semibold">{{ $acceptedCount }}</small>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-2 px-3 py-1 rounded"
                                            style="background-color: #f8d7da; color: #721c24;">
                                            <small>مرفوضين</small>
                                            <small class="fw-semibold">{{ $rejectedCount }}</small>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3 px-3 py-1 rounded"
                                            style="background-color: #fff3cd; color: #856404;">
                                            <small>احتياط</small>
                                            <small class="fw-semibold">{{ $reserveCount }}</small>
                                        </div>

                                        @php
                                            $acceptedPercent =
                                                $totalLeads > 0 ? round(($acceptedCount / $totalLeads) * 100) : 0;
                                            $rejectedPercent =
                                                $totalLeads > 0 ? round(($rejectedCount / $totalLeads) * 100) : 0;
                                            $reservePercent =
                                                $totalLeads > 0 ? round(($reserveCount / $totalLeads) * 100) : 0;
                                        @endphp

                                        <div class="progress" style="height: 12px; border-radius: 5px;">
                                            <div class="progress-bar bg-success d-flex justify-content-center align-items-center"
                                                style="width: {{ $acceptedPercent }}%;">
                                                {{ $acceptedPercent }}%
                                            </div>
                                            <div class="progress-bar bg-danger d-flex justify-content-center align-items-center"
                                                style="width: {{ $rejectedPercent }}%;">
                                                {{ $rejectedPercent }}%
                                            </div>
                                            <div class="progress-bar bg-warning d-flex justify-content-center align-items-center"
                                                style="width: {{ $reservePercent }}%;">
                                                {{ $reservePercent }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            const container = document.getElementById('testsContainer');
            document.getElementById('scrollLeft').addEventListener('click', () => {
                container.scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            });
            document.getElementById('scrollRight').addEventListener('click', () => {
                container.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            });
        </script>

        <!-- قسم المجموعات -->
        <div class="card card-info card-outline">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">المجموعات ({{ $groups->count() }})</h3>
                <div>
                    <button id="scrollRight" class="btn btn-light btn-sm"><i class="fas fa-chevron-right"></i></button>
                    <button id="scrollLeft" class="btn btn-light btn-sm me-1"><i
                            class="fas fa-chevron-left"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div id="groupsContainer" class="d-flex overflow-auto"
                    style="scroll-behavior: smooth; gap: 15px; white-space: nowrap;">

                    @foreach ($groups as $group)
                        @php
                            $totalCustomers = count($group->customers);
                            $qualifiedCustomers = $group->customers
                                ->filter(function ($customer) {
                                    return $customer->medical_examination === 'لائق' &&
                                        $customer->finger_print_examination === 'تم تصدير الاكسيل' &&
                                        $customer->virus_examination === 'سالب' &&
                                        !is_null($customer->e_visa_number);
                                })
                                ->count();
                        @endphp
                        <div class="col-md-3 col-6 mb-4">
                            <a href="{{ route('group.customer', $group->id) }}" class="text-decoration-none">
                                <div class="info-box bg-gradient-info text-white shadow rounded">
                                    <span class="info-box-icon bg-primary"><i class="fas fa-kaaba"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text fw-bold fs-5 mb-3 d-block">{{ $group->title }}</span>

                                        <div
                                            class="d-flex justify-content-between align-items-center mb-2 px-3 py-1 rounded bg-white text-dark shadow-sm">
                                            <small class="fw-semibold">عدد العملاء:</small>
                                            <small
                                                class="fw-bold badge bg-primary px-3 py-1">{{ $totalCustomers }}</small>
                                        </div>
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 px-3 py-1 rounded bg-white text-dark shadow-sm">
                                            <small class="fw-semibold">عدد المؤهلين للقنصلية:</small>
                                            <small
                                                class="fw-bold badge bg-success px-3 py-1">{{ $qualifiedCustomers }}</small>
                                        </div>

                                        @if ($group->visaProfession)
                                            <span class="info-box-number fw-semibold fs-6 text-white-75">
                                                {{ $totalCustomers }} / {{ $group->visaProfession->profession_count }}
                                            </span>
                                        @endif

                                        @if ($group->visaProfession && $group->visaType)
                                            <div class="progress mt-2"
                                                style="height: 14px; border-radius: 8px; overflow: hidden;">
                                                @php
                                                    $percentage =
                                                        $group->visaProfession->profession_count > 0
                                                            ? ($qualifiedCustomers / $totalCustomers) * 100
                                                            : 0;
                                                @endphp
                                                <div class="progress-bar bg-white d-flex justify-content-center align-items-center"
                                                    role="progressbar"
                                                    style="width: {{ $percentage }}%; color: #000; font-weight: bold;">
                                                    {{ round($percentage, 1) }}%
                                                </div>
                                            </div>
                                        @elseif (!$group->visaProfession && $group->visaType)
                                            <small class="text-white-50 d-block mt-3 fst-italic">
                                                مربوطة بالتأشيرة وغير مربوطة بالمهنة
                                            </small>
                                        @elseif ($group->visaProfession && !$group->visaType)
                                            <small class="text-white-50 d-block mt-3 fst-italic">
                                                مربوطة بالمهنة وغير مربوطة بالتأشيرة
                                            </small>
                                        @else
                                            <small class="text-white-50 d-block mt-3 fst-italic">
                                                غير مربوطة بمهنة أو تأشيرة
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <script>
            const container = document.getElementById('groupsContainer');
            document.getElementById('scrollLeft').addEventListener('click', () => {
                container.scrollBy({
                    left: -250,
                    behavior: 'smooth'
                });
            });
            document.getElementById('scrollRight').addEventListener('click', () => {
                container.scrollBy({
                    left: 250,
                    behavior: 'smooth'
                });
            });
        </script>

        <!-- قسم الحقائب -->
        <div class="card card-success card-outline">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">الحقائب ({{ $bags->count() }})</h3>
                <div>
                    <button id="scrollRightBags" class="btn btn-light btn-sm"><i
                            class="fas fa-chevron-right"></i></button>
                    <button id="scrollLeftBags" class="btn btn-light btn-sm me-1"><i
                            class="fas fa-chevron-left"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex overflow-auto" id="bagsContainer" style="gap: 1rem; white-space: nowrap;">
                    @foreach ($bags as $bag)
                        @php
                            $totalCustomers = count($bag->customers);
                            $customersWithVisaNumber = $bag->customers
                                ->whereNotNull('visa_number')
                                ->where('visa_number', '!=', '')
                                ->count();

                            $percentage =
                                $totalCustomers > 0 ? round(($customersWithVisaNumber / $totalCustomers) * 100) : 0;

                            if ($percentage >= 75) {
                                $progressBarClass = 'bg-success';
                            } elseif ($percentage >= 40) {
                                $progressBarClass = 'bg-warning';
                            } else {
                                $progressBarClass = 'bg-danger';
                            }
                        @endphp
                        <a href="{{ route('bags.customers', $bag->id) }}" class="text-decoration-none"
                            style="display: inline-block; flex: 0 0 auto; width: 300px;">
                            <div class="info-box shadow rounded border border-success bg-dark"
                                style="background-color: #1e2a1e !important; min-height: 180px;">
                                <span
                                    class="info-box-icon bg-success text-white d-flex align-items-center justify-content-center"
                                    style="font-size: 1.8rem; width: 60px; height: 60px;">
                                    <i class="fas fa-suitcase"></i>
                                </span>
                                <div class="info-box-content py-2">
                                    <h5 class="info-box-text fw-bold mb-2" style="font-size: 1.25rem; color: #a8d5a8;">
                                        {{ $bag->name }}
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted" style="color: #b5b5b5;">إجمالي العملاء</small>
                                        <span class="fw-semibold" style="color: #a8d5a8;">{{ $totalCustomers }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted" style="color: #b5b5b5;">العملاء برقم تأشيرة</small>
                                        <span class="fw-semibold text-success"
                                            style="color: #7bd17b;">{{ $customersWithVisaNumber }}</span>
                                    </div>
                                    <div class="progress rounded" style="height: 14px; background-color: #274927;">
                                        <div class="progress-bar {{ $progressBarClass }}" role="progressbar"
                                            style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <span class="fw-bold" style="font-size: 0.85rem; color: #e0f2e9;">
                                                {{ $percentage }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            document.getElementById('scrollRightBags').addEventListener('click', function() {
                document.getElementById('bagsContainer').scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            });
            document.getElementById('scrollLeftBags').addEventListener('click', function() {
                document.getElementById('bagsContainer').scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            });
        </script>


        <!-- قسم التأشيرات -->
        <div class="card card-success card-outline">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">التأشيرات ({{ $visas->count() }})</h3>
                <div>
                    <button id="visaScrollRight" class="btn btn-light btn-sm"><i
                            class="fas fa-chevron-right"></i></button>
                    <button id="visaScrollLeft" class="btn btn-light btn-sm me-1"><i
                            class="fas fa-chevron-left"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex overflow-auto" id="visaScrollContainer" style="gap: 15px;">
                    @foreach ($visas as $visa)
                        <div style="flex: 0 0 auto; width: 250px;">
                            <a href="{{ route('groups.visa', $visa->id) }}" class="text-decoration-none">
                                <div class="info-box bg-gradient-success text-white shadow">
                                    <span class="info-box-icon bg-success"><i class="fas fa-passport"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text fw-bold">{{ $visa->name }}</span>
                                        <span class="info-box-number">عدد العملاء:
                                            {{ $visa->customerGroups->sum(function ($group) {
                                                return $group->customers->count();
                                            }) }}</span>
                                        <span class="info-box-number">عدد المغادرين:
                                            {{ $visa->customerGroups->sum(function ($group) {
                                                return $group->customers->where('status', 'تم السفر')->count();
                                            }) }}</span>

                                        @php
                                            $totalCustomers = $visa->customerGroups->sum(function ($group) {
                                                return $group->customers->count();
                                            });

                                            $totalOutgoing = $visa->customerGroups->sum(function ($group) {
                                                return $group->customers->where('status', 'تم السفر')->count();
                                            });

                                            $percentage =
                                                $totalCustomers > 0 ? ($totalOutgoing / $totalCustomers) * 100 : 0;
                                        @endphp

                                        <div class="progress mt-2" style="height: 12px;">
                                            <div class="progress-bar bg-white d-flex justify-content-center align-items-center"
                                                style="width: {{ $percentage }}%; color: #000; font-weight: bold;">
                                                {{ round($percentage, 1) }}%
                                            </div>
                                        </div>
                                        <span class="progress-description text-white-50">
                                            {{ $visa->visa_peroid }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            const visaScrollContainer = document.getElementById('visaScrollContainer');
            document.getElementById('visaScrollLeft').addEventListener('click', () => {
                visaScrollContainer.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
            });
            document.getElementById('visaScrollRight').addEventListener('click', () => {
                visaScrollContainer.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
            });
        </script>


        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3 table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">اسم الموظف</th>
                            <th scope="col">اسم العميل</th>
                            <th scope="col">الوصف</th>
                            <th scope="col">تاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr>
                                <td class="fw-semibold">{{ $history->user->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('customer.show', $history->customer->id) }}"
                                        class="text-decoration-none text-primary fw-bold">
                                        {{ $history->customer->name_ar ?? '-' }}
                                    </a>
                                </td>
                                <td class="text-muted">{{ $history->description }}</td>
                                <td class="text-secondary">{{ $history->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted py-4">لا توجد تقييمات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container py-3">
            <div class="row">
                <!-- إحصائيات العملاء -->
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">📈 إحصائيات العملاء</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="customers" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- إحصائيات المجموعات -->
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">📊 إحصائيات المجموعات</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="groupsChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- إحصائيات المناديب -->
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">🧑‍💼 إحصائيات المناديب والعملاء</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="delegatesChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- العملاء المحتملين -->
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">📅 العملاء المحتملين</h5>
                            <select id="filterSelect" class="form-select form-select-sm w-auto" aria-label="تحديد فلتر">
                                <option value="day">اليوم</option>
                                <option value="month" selected>الشهر</option>
                                <option value="year">السنة</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <canvas id="potentialChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- إحصائيات التأشيرات -->
                <div class="col-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0">🎫 إحصائيات التأشيرات</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="visaChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop


    @section('css')
        <style>
            .info-box {
                cursor: pointer;
                transition: transform 0.3s;
            }

            .info-box:hover {
                transform: translateY(-5px);
            }

            .card-title {
                font-weight: bold;
            }

            .small-box .icon>i {
                font-size: 70px;
                top: 15px;
            }
        </style>
        <style>
            .info-card {
                display: flex;
                align-items: center;
                background: #fff;
                border-radius: 12px;
                padding: 15px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease-in-out;
            }

            .info-card.small-card {
                min-height: 120px;
            }

            .info-card:hover {
                transform: translateY(-3px);
            }

            .icon-container {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                margin-left: 15px;
            }

            .info-title {
                font-size: 1rem;
                color: #444;
            }

            .info-number {
                font-size: 1.4rem;
                font-weight: bold;
                color: #222;
            }

            .group-circle {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: white;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease-in-out;
                cursor: pointer;
                text-align: center;
                padding: 10px;
            }

            .group-circle:hover {
                transform: scale(1.05);
            }

            .group-icon {
                font-size: 1.7rem;
                margin-bottom: 8px;
            }

            .group-name {
                font-weight: bold;
                font-size: 0.95rem;
            }

            /* ألوان المجموعات */
            .group-makkah {
                background-color: #17a2b8;
                /* أزرق */
            }

            .group-madina {
                background-color: #28a745;
                /* أخضر */
            }

            .group-riyadh {
                background-color: #ffc107;
                /* أصفر */
                color: #000;
                /* لأن الخلفية فاتحة */
            }

            .group-dammam {
                background-color: #dc3545;
                /* أحمر */
            }

            .group-jeddah {
                background-color: #6f42c1;
                /* بنفسجي */
            }

            /* خلفية مخصصة في اللايت مود */
            .info-box.custom-bg {
                background-color: #e3f2fd;
                /* لون أزرق فاتح (يمكن تغييره) */
                color: #212529;
                /* لون نص داكن */
            }

            /* خلفية مخصصة في الدارك مود */
            body.dark-mode .info-box.custom-bg {
                background-color: #2c3e50;
                /* لون أزرق غامق */
                color: #ecf0f1;
                /* لون نص فاتح */
            }
        </style>
    @stop

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('customers');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                            label: 'العملاء الأساسيين',
                            data: @json($mainCounts),
                            borderWidth: 2,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'العملاء المحتملين',
                            data: @json($potentialCounts),
                            borderWidth: 2,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            const groups = document.getElementById('groupsChart');
            new Chart(groups, {
                type: 'bar',
                data: {
                    labels: @json($groupNames),
                    datasets: [{
                        label: 'عدد العملاء في كل مجموعة',
                        data: @json($customerCounts),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            const ctxDelegates = document.getElementById('delegatesChart');
            new Chart(ctxDelegates, {
                type: 'bar',
                data: {
                    labels: @json($delegateNames),
                    datasets: [{
                            label: 'عدد العملاء الكلي',
                            data: @json($totalDCustomers),
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'عدد العملاء الذين سافروا',
                            data: @json($traveledCustomers),
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            let potentialChart;

            function loadPotentialChart(filter = 'month') {
                fetch("{{ route('chart.potential') }}?filter=" + filter)
                    .then(response => response.json())
                    .then(data => {
                        let ctx = document.getElementById('potentialChart').getContext('2d');

                        if (window.potentialChartInstance) {
                            window.potentialChartInstance.destroy();
                        }

                        window.potentialChartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels, // الأيام أو الأشهر أو السنوات
                                datasets: [{
                                        label: 'العملاء المحتملين',
                                        data: data.potential,
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderWidth: 2,
                                        tension: 0.3,
                                        fill: true
                                    },
                                    {
                                        label: 'العملاء الذين تحولوا لأساسيين',
                                        data: data.converted,
                                        borderColor: 'rgba(75, 192, 75, 1)',
                                        backgroundColor: 'rgba(75, 192, 75, 0.2)',
                                        borderWidth: 2,
                                        tension: 0.3,
                                        fill: true
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        labels: {
                                            font: {
                                                size: 14
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            }

            document.getElementById('filterSelect').addEventListener('change', function() {
                loadPotentialChart(this.value);
            });

            loadPotentialChart(); // الافتراضي: الشهر

            fetch('/admin/chart/visa-customers')
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('visaChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                    label: 'إجمالي العملاء',
                                    data: data.total,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                },
                                {
                                    label: 'العملاء برقم تأشيرة',
                                    data: data.withVisa,
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                }
                            ]
                        },
                        options: {
                            responsive: true,
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
                });
        </script>
    @stop
