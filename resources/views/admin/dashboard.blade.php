@extends('layouts.app', ['hideHeaderFooter' => true])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.partials.sidebar')
            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="pt-4">
                    <!-- لمسة ترحيبية -->
                    <div class="alert alert-primary text-center mb-4"
                        style="font-size:1.2rem; font-weight:600; letter-spacing:1px;">
                        مرحباً بك في لوحة تحكم الأدمن — يمكنك متابعة جميع الطلبات والإحصائيات من هنا بسهولة.
                    </div>
                    <!-- تنبيه للطلبات العاجلة -->
                    @if ($urgentOrders > 0)
                        <div class="alert alert-danger text-center mb-4" style="font-size:1.1rem;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            يوجد <b>{{ $urgentOrders }}</b> طلب عاجل بحاجة للمتابعة السريعة!
                        </div>
                    @endif
                    <!-- إحصائيات سريعة -->
                    <h2 class="mb-3 mt-2 text-primary" style="font-weight:bold;">الإحصائيات العامة</h2>
                    <div class="row mb-4 g-3">
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-light">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-list fa-2x text-primary"></i></div>
                                    <h6 class="card-title">إجمالي الطلبات</h6>
                                    <p class="card-text display-6">{{ $totalOrders }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-warning bg-opacity-25">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-hourglass-half fa-2x text-warning"></i></div>
                                    <h6 class="card-title">طلبات قيد الانتظار</h6>
                                    <p class="card-text display-6">{{ $pendingOrders }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-info bg-opacity-25">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-spinner fa-2x text-info"></i></div>
                                    <h6 class="card-title">طلبات قيد التنفيذ</h6>
                                    <p class="card-text display-6">{{ $inProgressOrders }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-success bg-opacity-25">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-check-circle fa-2x text-success"></i></div>
                                    <h6 class="card-title">طلبات مكتملة</h6>
                                    <p class="card-text display-6">{{ $completedOrders }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 g-3">
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-danger bg-opacity-25">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-times-circle fa-2x text-danger"></i></div>
                                    <h6 class="card-title">طلبات مرفوضة</h6>
                                    <p class="card-text display-6">{{ $rejectedOrders }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-danger bg-opacity-10">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-bolt fa-2x text-danger"></i></div>
                                    <h6 class="card-title">طلبات عاجلة</h6>
                                    <p class="card-text display-6">{{ $urgentOrders }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-primary bg-opacity-10">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-calendar-alt fa-2x text-primary"></i></div>
                                    <h6 class="card-title">طلبات الشهر الحالي</h6>
                                    <p class="card-text display-6">{{ $currentMonthOrders }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm border-0 bg-secondary bg-opacity-10">
                                <div class="card-body">
                                    <div class="mb-2"><i class="fas fa-layer-group fa-2x text-secondary"></i></div>
                                    <h6 class="card-title">أنواع الطلبات</h6>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($ordersByType as $type => $count)
                                            <li><span class="fw-bold">{{ $type }}</span>: {{ $count }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- آخر الطلبات -->
                    <h2 class="mb-3 mt-5 text-primary" style="font-weight:bold;">آخر 10 طلبات</h2>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light fw-bold">آخر 10 طلبات</div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>النوع</th>
                                        <th>الحالة</th>
                                        <th>الأولوية</th>
                                        <th>تاريخ الإنشاء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->type }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>{{ $order->priority }}</td>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- إحصائيات الأسبوع -->
                    <h2 class="mb-3 mt-5 text-primary" style="font-weight:bold;">إحصائيات الأسبوع الحالي</h2>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light fw-bold">عدد الطلبات لكل يوم</div>
                        <div class="card-body">
                            <ul class="list-inline mb-0">
                                @foreach ($weeklyStats as $stat)
                                    <li class="list-inline-item mx-2 mb-2">
                                        <span class="badge bg-primary bg-opacity-75 p-2"
                                            style="font-size:1rem;">{{ $stat->date }}: {{ $stat->count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- طلبات تسجيل الشركات -->
                    <h2 class="mb-3 mt-5 text-primary" style="font-weight:bold;">طلبات تسجيل الشركات</h2>
                    <div class="card shadow mb-5">
                        <div class="card-header bg-primary text-white fw-bold">طلبات تسجيل الشركات</div>
                        <div class="card-body">
                            @if (isset($requests) && count($requests) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>اسم الشركة</th>
                                                <th>البريد الإلكتروني</th>
                                                <th>المسمى الوظيفي</th>
                                                <th>عدد العمالة</th>
                                                <th>ملاحظات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requests as $req)
                                                <tr>
                                                    <td>{{ $req['company_name'] }}</td>
                                                    <td>{{ $req['email'] }}</td>
                                                    <td>{{ $req['job_title'] }}</td>
                                                    <td>{{ $req['workers_count'] }}</td>
                                                    <td>{{ $req['message'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">لا توجد طلبات شركات حالياً.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <style>
        #sidebar {
            background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
            min-height: 100vh;
            box-shadow: 2px 0 20px rgba(23, 74, 124, 0.08);
        }

        #sidebar .nav-link.active,
        #sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #B89C5A !important;
            border-radius: 8px;
            font-weight: bold;
        }

        #sidebar .nav-link i {
            color: #B89C5A;
        }

        #sidebar .fw-bold {
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        @media (max-width: 767.98px) {
            #sidebar {
                display: none;
            }

            main.col-md-10 {
                width: 100% !important;
            }
        }
    </style>
@endsection
