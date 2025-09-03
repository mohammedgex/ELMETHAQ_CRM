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
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold mb-2 text-truncate">{{ $test->title }}</h5>
                                            <button type="button" class="btn btn-sm btn-pin" data-id="{{ $test->id }}"
                                                data-type="test">
                                                <i class="fas fa-thumbtack"></i>
                                            </button>
                                        </div>
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
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold mb-2 text-truncate">{{ $test->title }}</h5>
                                            <button type="button" class="btn btn-sm btn-pin"
                                                data-id="{{ $group->id }}" data-type="group">
                                                <i class="fas fa-thumbtack"></i>
                                            </button>

                                        </div>
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
                                                        $group->visaProfession->profession_count > 0 &&
                                                        $totalCustomers > 0
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="info-box-text fw-bold mb-2"
                                            style="font-size: 1.25rem; color: #a8d5a8;">
                                            {{ $bag->name }}
                                        </h5>
                                        <button style="color: white" type="button" class="btn btn-sm btn-pin"
                                            data-id="{{ $bag->id }}" data-type="bag">
                                            <i class="fas fa-thumbtack"></i>
                                        </button>
                                    </div>

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
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="info-box-text fw-bold">{{ $visa->name }}</span>
                                            <button type="button" class="btn btn-sm btn-pin"
                                                data-id="{{ $visa->id }}" data-type="visa">
                                                <i class="fas fa-thumbtack"></i>
                                            </button>
                                        </div>
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
                            <th scope="col">النوع</th> {{-- ✨ العمود الجديد --}}
                            <th scope="col">الوصف</th>
                            <th scope="col">تاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr>
                                <td class="fw-semibold">{{ $history->user->name ?? '-' }}</td>
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
                                <td>
                                    @if ($history->customer)
                                        <span class="badge bg-primary">عميل أساسي</span>
                                    @elseif($history->lead)
                                        <span class="badge bg-warning text-dark">عميل محتمل</span>
                                    @else
                                        <span class="badge bg-secondary">غير محدد</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $history->description }}</td>
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
        </div>


        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3 table-responsive">
                <table class="table  align-middle text-center mb-0" style="color: white;">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">👤 المرسل</th>
                            <th scope="col">👥 المستلم</th>
                            <th scope="col">📝 الوصف</th>
                            <th scope="col">⏰ الوقت</th>
                            <th scope="col">📌 الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr class="{{ $task->status == 'new' ? 'row-new' : 'row-done' }}">
                                <td class="fw-semibold">{{ $task->sender->name ?? '-' }}</td>
                                <td class="fw-semibold">{{ $task->receiver->name ?? '-' }}</td>
                                <td class="text-start" title="{{ $task->description }}">
                                    {{ \Illuminate\Support\Str::limit($task->description, 50) }}
                                </td>
                                <td class="text-secondary" style="color: white !important;">
                                    {{ $task->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if ($task->status == 'new')
                                        <span class="badge status-new">جديدة ⏳</span>
                                    @elseif($task->status == 'done')
                                        <span class="badge status-done">مكتملة ✅</span>
                                    @else
                                        <span class="badge bg-secondary">غير معروف</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-4">لا توجد مهام حالياً</td>
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

            /* صفوف المهام */
            .row-new {
                background-color: #fff9e6;
                /* أصفر فاتح في Light */
            }

            .row-done {
                background-color: #e6f7ed;
                /* أخضر فاتح في Light */
            }

            /* شارات (Badges) */
            .status-new {
                background-color: #ffc107;
                color: #222;
                font-weight: 600;
            }

            .status-done {
                background-color: #28a745;
                color: #fff;
                font-weight: 600;
            }

            /* الوضع الليلي */
            @media (prefers-color-scheme: dark) {
                .card {
                    /* background-color: #1e1e1e; */
                    /* color: #eee; */
                }

                thead.table-dark {
                    background-color: #333;
                    color: #f1f1f1;
                }

                .row-new {
                    background-color: #3a3200;
                    /* أصفر داكن */
                }

                .row-done {
                    background-color: #0f3320;
                    /* أخضر داكن */
                }

                .status-new {
                    background-color: #d6a700;
                    color: #000;
                }

                .status-done {
                    background-color: #1e7e34;
                    color: #fff;
                }
            }
        </style>
        {{-- <style>
            /* متغيرات الألوان للوضع الفاتح */
            :root {
                --primary-bg: #ffffff;
                --secondary-bg: #f8f9fa;
                --card-bg: #ffffff;
                --text-primary: #212529;
                --text-secondary: #6c757d;
                --border-color: #dee2e6;
                --shadow-light: rgba(0, 0, 0, 0.1);
                --shadow-medium: rgba(0, 0, 0, 0.15);
                --accent-primary: #007bff;
                --accent-success: #28a745;
                --accent-warning: #ffc107;
                --accent-danger: #dc3545;
                --accent-info: #17a2b8;
                --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
                --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            }

            /* متغيرات الألوان للوضع المظلم */
            body.dark-mode {
                --primary-bg: #1a1a1a;
                --secondary-bg: #2d2d2d;
                --card-bg: #343a40;
                --text-primary: #ffffff;
                --text-secondary: #adb5bd;
                --border-color: #495057;
                --shadow-light: rgba(255, 255, 255, 0.1);
                --shadow-medium: rgba(255, 255, 255, 0.15);
                --accent-primary: #4dabf7;
                --accent-success: #51cf66;
                --accent-warning: #ffd43b;
                --accent-danger: #ff6b6b;
                --accent-info: #22b8cf;
                --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
                --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            }

            /* تحسينات عامة */
            body {
                background-color: var(--secondary-bg);
                color: var(--text-primary);
                transition: all 0.3s ease;
            }

            /* تحسين الكروت الرئيسية */
            .small-box {
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 8px 25px var(--shadow-light);
                transition: all 0.3s ease;
                border: none;
                position: relative;
            }

            .small-box::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.7) 50%, rgba(255, 255, 255, 0.3) 100%);
            }

            .small-box:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px var(--shadow-medium);
            }

            .small-box .inner {
                padding: 20px;
            }

            .small-box .inner h3 {
                font-size: 2.2rem;
                font-weight: 700;
                margin-bottom: 5px;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .small-box .inner p {
                font-size: 1rem;
                font-weight: 500;
                opacity: 0.9;
            }

            .small-box .icon {
                position: absolute;
                top: 15px;
                left: 15px;
                opacity: 0.3;
            }

            .small-box .icon i {
                font-size: 60px !important;
            }

            .small-box-footer {
                background: rgba(0, 0, 0, 0.1);
                color: rgba(255, 255, 255, 0.8) !important;
                padding: 10px 0;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .small-box-footer:hover {
                background: rgba(0, 0, 0, 0.2);
                color: white !important;
            }

            /* ألوان مخصصة للكروت */
            .bg-info {
                background: var(--gradient-info) !important;
            }

            .bg-success {
                background: var(--gradient-success) !important;
            }

            .bg-warning {
                background: var(--gradient-warning) !important;
            }

            .bg-danger {
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%) !important;
            }

            /* تحسين الكروت العادية */
            .card {
                background-color: var(--card-bg);
                border: 1px solid var(--border-color);
                border-radius: 15px;
                box-shadow: 0 5px 15px var(--shadow-light);
                transition: all 0.3s ease;
                overflow: hidden;
            }

            .card:hover {
                box-shadow: 0 10px 25px var(--shadow-medium);
            }

            .card-header {
                background: linear-gradient(135deg, var(--accent-primary) 0%, #6c5ce7 100%);
                color: white;
                border-bottom: none;
                padding: 1rem 1.5rem;
                font-weight: 600;
            }

            .card-header.bg-info {
                background: var(--gradient-info);
            }

            .card-header.bg-success {
                background: var(--gradient-success);
            }

            .card-header.bg-warning {
                background: var(--gradient-warning);
            }

            .card-title {
                margin: 0;
                font-size: 1.1rem;
                font-weight: 600;
            }

            /* تحسين info-box */
            .info-box {
                background-color: var(--card-bg);
                border-radius: 12px;
                border: 1px solid var(--border-color);
                box-shadow: 0 4px 15px var(--shadow-light);
                transition: all 0.3s ease;
                overflow: hidden;
                position: relative;
            }

            .info-box::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: var(--accent-primary);
            }

            .info-box:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px var(--shadow-medium);
            }

            .info-box-icon {
                border-radius: 12px;
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                margin: 10px;
            }

            .info-box-content {
                padding: 15px;
                color: var(--text-primary);
            }

            /* تحسين الجداول */
            .table {
                background-color: var(--card-bg);
                color: var(--text-primary);
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 10px var(--shadow-light);
            }

            .table thead th {
                background: linear-gradient(135deg, #2d3436 0%, #636e72 100%);
                color: white;
                border: none;
                padding: 15px;
                font-weight: 600;
                text-align: center;
            }

            .table tbody td {
                padding: 12px 15px;
                border-top: 1px solid var(--border-color);
                color: var(--text-primary);
            }

            .table tbody tr {
                transition: all 0.2s ease;
            }

            .table tbody tr:hover {
                background-color: var(--secondary-bg);
                transform: scale(1.01);
            }

            /* تحسين الأزرار */
            .btn {
                border-radius: 8px;
                font-weight: 500;
                transition: all 0.3s ease;
                border: none;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            .btn-primary {
                background: var(--gradient-primary);
            }

            .btn-success {
                background: var(--gradient-success);
            }

            .btn-warning {
                background: var(--gradient-warning);
                color: white;
            }

            .btn-danger {
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            }

            .btn-info {
                background: var(--gradient-info);
            }

            /* تحسين الـ Progress Bars */
            .progress {
                height: 8px;
                border-radius: 10px;
                background-color: var(--secondary-bg);
                overflow: hidden;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            }

            .progress-bar {
                border-radius: 10px;
                transition: width 0.6s ease;
                position: relative;
                overflow: hidden;
            }

            .progress-bar::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
                animation: shimmer 2s infinite;
            }

            @keyframes shimmer {
                0% {
                    left: -100%;
                }

                100% {
                    left: 100%;
                }
            }

            /* تحسين الـ Badges */
            .badge {
                border-radius: 20px;
                padding: 6px 12px;
                font-weight: 500;
                font-size: 0.8rem;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }

            /* تحسين الصفوف الخاصة */
            .row-new {
                background: linear-gradient(135deg, #fff9e6 0%, #fef5d0 100%);
                border-left: 4px solid var(--accent-warning);
            }

            .row-done {
                background: linear-gradient(135deg, #e6f7ed 0%, #d1f2d9 100%);
                border-left: 4px solid var(--accent-success);
            }

            body.dark-mode .row-new {
                background: linear-gradient(135deg, #3a3200 0%, #4d4200 100%);
            }

            body.dark-mode .row-done {
                background: linear-gradient(135deg, #0f3320 0%, #1a4d2e 100%);
            }

            /* تحسين الأيقونات */
            .fas,
            .fab,
            .far {
                transition: all 0.3s ease;
            }

            /* تحسين الـ Scrollbars */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: var(--secondary-bg);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, var(--accent-primary), #6c5ce7);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(135deg, #0056b3, #5a4fcf);
            }

            /* تحسين الـ Container */
            .container-fluid {
                padding: 20px;
            }

            /* تأثيرات التحوم للكروت الصغيرة */
            .info-card:hover {
                transform: translateY(-5px) rotate(1deg);
                box-shadow: 0 10px 25px var(--shadow-medium);
            }

            /* تحسين الـ Dropdowns */
            .dropdown-menu {
                background-color: var(--card-bg);
                border: 1px solid var(--border-color);
                border-radius: 10px;
                box-shadow: 0 10px 25px var(--shadow-medium);
                padding: 10px;
            }

            .dropdown-item {
                color: var(--text-primary);
                border-radius: 6px;
                transition: all 0.2s ease;
                padding: 8px 12px;
            }

            .dropdown-item:hover {
                background-color: var(--secondary-bg);
                color: var(--accent-primary);
                transform: translateX(5px);
            }

            /* تحسين الروابط */
            a {
                color: var(--accent-primary);
                text-decoration: none;
                transition: all 0.3s ease;
            }

            a:hover {
                color: #0056b3;
                transform: translateX(2px);
            }

            body.dark-mode a:hover {
                color: #74c0fc;
            }

            /* تحسين الـ Form Controls */
            .form-control,
            .form-select {
                background-color: var(--card-bg);
                border: 2px solid var(--border-color);
                border-radius: 8px;
                color: var(--text-primary);
                transition: all 0.3s ease;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--accent-primary);
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                background-color: var(--card-bg);
                color: var(--text-primary);
            }

            /* تحسين الـ Modal (إذا كان موجود) */
            .modal-content {
                background-color: var(--card-bg);
                border: none;
                border-radius: 15px;
                box-shadow: 0 20px 40px var(--shadow-medium);
            }

            .modal-header {
                border-bottom: 1px solid var(--border-color);
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
            }

            .modal-footer {
                border-top: 1px solid var(--border-color);
            }

            /* تأثيرات الأنيميشن */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .card,
            .small-box,
            .info-box {
                animation: fadeInUp 0.6s ease-out;
            }

            /* تحسين responsive */
            @media (max-width: 768px) {
                .container-fluid {
                    padding: 10px;
                }

                .small-box .inner h3 {
                    font-size: 1.8rem;
                }

                .info-box-icon {
                    width: 50px;
                    height: 50px;
                    font-size: 1.2rem;
                }

                .card-header {
                    padding: 0.8rem 1rem;
                }
            }

            /* إضافات خاصة للوضع المظلم */
            body.dark-mode {
                background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            }

            body.dark-mode .card {
                background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            }

            body.dark-mode .small-box {
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            }

            body.dark-mode .table {
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            }
        </style> --}}
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const pinButtons = document.querySelectorAll(".btn-pin");

                // استرجاع البيانات من LocalStorage
                let pinned = JSON.parse(localStorage.getItem("pinnedItems") || "{}");

                function reorderCards() {
                    for (let type in pinned) {
                        let ids = pinned[type];
                        ids.forEach(id => {
                            let btn = document.querySelector(`.btn-pin[data-type="${type}"][data-id="${id}"]`);
                            let card = btn?.closest(".col-md-3, [style*='flex: 0 0']"); // عشان يمسك أي كارت
                            let container = card?.parentElement;
                            if (card && container) {
                                container.prepend(card); // يجيب المثبت الأول
                                btn.classList.add("btn-warning"); // لون الدبوس لو مثبت
                            }
                        });
                    }
                }

                pinButtons.forEach(btn => {
                    btn.addEventListener("click", function(e) {
                        e.preventDefault(); // يمنع فتح الرابط
                        e.stopPropagation(); // يمنع Bubbling للـ <a>

                        let id = this.dataset.id;
                        let type = this.dataset.type;

                        if (!pinned[type]) pinned[type] = [];

                        if (pinned[type].includes(id)) {
                            pinned[type] = pinned[type].filter(x => x !== id);
                            this.classList.remove("btn-warning");
                        } else {
                            pinned[type].push(id);
                            this.classList.add("btn-warning");
                        }

                        localStorage.setItem("pinnedItems", JSON.stringify(pinned));
                        reorderCards();
                    });

                });

                // تنفيذ أول مرة
                reorderCards();
            });
        </script>

    @stop
