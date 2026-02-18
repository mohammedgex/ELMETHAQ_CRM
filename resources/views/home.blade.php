@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <div class="dashboard-wrapper" style="font-family: 'Cairo', sans-serif; direction: rtl;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="header-welcome shadow-lg custom-header"
                    style="border-radius: 24px; padding: 35px; position: relative; overflow: hidden; background: var(--header-gradient);">

                    <div class="row align-items-center mb-4">
                        <div class="col-md-7">
                            <div class="d-flex align-items-center">
                                <div class="welcome-icon ml-3 d-none d-md-flex"
                                    style="background: rgba(255, 255, 255, 0.2); width: 65px; height: 65px; border-radius: 18px; align-items: center; justify-content: center; backdrop-filter: blur(10px); margin-left: 15px !important;">
                                    <i class="fas fa-hand-peace fa-2x text-white"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1 text-white" style="font-weight: 800;">أهلاً بك،
                                        {{ auth()->user()->name }} 👋</h2>
                                    <p class="mb-0 text-white-50" style="font-size: 1.1rem;">
                                        {{ \Carbon\Carbon::now()->translatedFormat('l، d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 text-md-left text-center mt-3 mt-md-0">
                            <div class="quick-action">
                                <span class="text-white-50 d-block mb-1">إجمالي نشاط اليوم</span>
                                <h3 class="text-white font-weight-bold mb-0" style="font-size: 2.2rem;">
                                    {{ $historiesCount }}</h3>
                            </div>
                        </div>
                    </div>

                    <hr style="border-top: 1px solid rgba(255,255,255,0.15); margin: 25px 0;">

                    <div class="row mt-4">
                        @php
                            $stats = [
                                [
                                    'count' => $customers->count(),
                                    'label' => 'العملاء',
                                    'icon' => 'fas fa-user-friends',
                                    'color' => '#60a5fa',
                                ],
                                [
                                    'count' => $delegates->count(),
                                    'label' => 'المناديب',
                                    'icon' => 'fas fa-eye',
                                    'color' => '#34d399',
                                ],
                                [
                                    'count' => $groups->count(),
                                    'label' => 'المجموعات',
                                    'icon' => 'fas fa-users',
                                    'color' => '#fbbf24',
                                ],
                                [
                                    'count' => $users->count(),
                                    'label' => 'الموظفين',
                                    'icon' => 'fas fa-user-tie',
                                    'color' => '#f87171',
                                ],
                                [
                                    'count' => $visas->count(),
                                    'label' => 'التأشيرات',
                                    'icon' => 'fas fa-passport',
                                    'color' => '#a78bfa',
                                ],
                                [
                                    'count' => $bags->count(),
                                    'label' => 'الحقائب',
                                    'icon' => 'fas fa-briefcase',
                                    'color' => '#fb923c',
                                ],
                            ];
                        @endphp

                        @foreach ($stats as $stat)
                            <div class="col-lg-2 col-md-4 col-6 mb-3 mb-lg-0">
                                <div class="inner-stat-card"
                                    style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 15px; transition: 0.3s; backdrop-filter: blur(5px);">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="{{ $stat['icon'] }} mr-2"
                                            style="color: {{ $stat['color'] }}; font-size: 0.9rem;"></i>
                                        <small class="text-white-50 font-weight-bold">{{ $stat['label'] }}</small>
                                    </div>
                                    <h4 class="text-white mb-0 font-weight-bold">{{ $stat['count'] }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="position: absolute; left: -20px; bottom: -20px; opacity: 0.05; pointer-events: none;">
                        <i class="fas fa-rocket" style="font-size: 200px; color: white;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* --- المتغيرات والتنسيق المتكيف --- */
        :root {
            --header-gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .dark-mode :root,
        body.dark-mode {
            --header-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .inner-stat-card:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* لضمان تناسق الأيقونات والمسافات في العربي */
        .mr-2 {
            margin-left: 8px !important;
            margin-right: 0 !important;
        }

        .ml-3 {
            margin-right: 15px !important;
            margin-left: 0 !important;
        }

        @media (max-width: 768px) {
            .custom-header {
                padding: 20px !important;
            }

            .badge-value {
                font-size: 1.5rem !important;
            }
        }
    </style>
@stop

@section('content')
    <div class="container-fluid">
        <!-- قسم الاختبارات -->
        <div class="card card-primary card-outline position-relative">
            <style>
                /* --- تعريف متغيرات الهيدر لتناسب الوضعين --- */
                :root {
                    --header-bg: #ffffff;
                    --header-text: #1e293b;
                    --badge-bg: #f1f5f9;
                    --badge-text: #475569;
                    --btn-scroll-bg: #f8fafc;
                    --btn-scroll-border: #e2e8f0;
                    --btn-scroll-text: #64748b;
                }

                /* تحويل المتغيرات في الدارك مود */
                .dark-mode :root,
                body.dark-mode {
                    --header-bg: #1e293b;
                    /* نفس لون خلفية الكارت في الدارك */
                    --header-text: #f1f5f9;
                    --badge-bg: rgba(255, 255, 255, 0.1);
                    --badge-text: #cbd5e1;
                    --btn-scroll-bg: rgba(255, 255, 255, 0.05);
                    --btn-scroll-border: rgba(255, 255, 255, 0.1);
                    --btn-scroll-text: #f1f5f9;
                }

                .modern-card-header {
                    background-color: var(--header-bg) !important;
                    padding: 20px 25px;
                    border-bottom: 1px solid var(--btn-scroll-border);
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    border-radius: 20px 20px 0 0 !important;
                    transition: background-color 0.3s ease;
                }

                .header-title-wrapper {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                }

                .modern-card-title {
                    font-size: 1.25rem;
                    font-weight: 800;
                    color: var(--header-text);
                    margin: 0;
                }

                .test-count-pill {
                    background: var(--badge-bg);
                    color: var(--badge-text);
                    padding: 4px 14px;
                    border-radius: 50px;
                    font-size: 0.85rem;
                    font-weight: 700;
                    border: 1px solid var(--btn-scroll-border);
                }

                /* أزرار السكرول */
                .scroll-actions {
                    display: flex;
                    gap: 10px;
                }

                .btn-scroll-custom {
                    width: 40px;
                    height: 40px;
                    border-radius: 12px;
                    background: var(--btn-scroll-bg);
                    border: 1px solid var(--btn-scroll-border);
                    color: var(--btn-scroll-text);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    cursor: pointer;
                }

                .btn-scroll-custom:hover {
                    background: #3f6791;
                    /* لونك المفضل الأساسي */
                    color: #ffffff;
                    border-color: #3f6791;
                    transform: translateY(-3px);
                    box-shadow: 0 5px 15px rgba(63, 103, 145, 0.3);
                }

                .btn-scroll-custom:active {
                    transform: translateY(0);
                }

                /* أيقونة العنوان */
                .title-icon {
                    width: 35px;
                    height: 35px;
                    background: rgba(63, 103, 145, 0.1);
                    color: #3f6791;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.9rem;
                }
            </style>

            <div class="modern-card-header">
                <div class="header-title-wrapper">
                    <div class="title-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="modern-card-title">الاختبارات</h3>
                    <span class="test-count-pill">{{ $tests->count() }}</span>
                </div>

                <div class="scroll-actions">
                    <button id="scrollRight" class="btn-scroll-custom" title="السابق">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button id="scrollLeft" class="btn-scroll-custom" title="التالي">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>

            <div class="card-body position-relative">
                <!-- الحاوية اللي فيها الكروت -->
                <div id="testsContainer" class="d-flex flex-row flex-nowrap overflow-auto py-4"
                    style="gap: 20px; scroll-behavior: smooth;">
                    @foreach ($tests as $test)
                        @php
                            // حساب الإحصائيات
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

                            $latestRecords = \App\Models\Evaluation::whereIn('id', $latestEvaluationIds)->get();
                            $accepted = $latestRecords->where('evaluation', 'مقبول')->count();
                            $rejected = $latestRecords->where('evaluation', 'غير مقبول')->count();
                            $reserve = $latestRecords->where('evaluation', 'احتياطي')->count();
                            $total = $latestRecords->count();

                            $pAcc = $total > 0 ? ($accepted / $total) * 100 : 0;
                            $pRej = $total > 0 ? ($rejected / $total) * 100 : 0;
                            $pRes = $total > 0 ? ($reserve / $total) * 100 : 0;
                        @endphp

                        <div class="test-item col-md-3">
                            <a href="{{ route('test.leads', $test->id) }}" class="test-card-modern">

                                <button type="button" class="btn-pin btn-pin-top" data-id="{{ $test->id }}"
                                    data-type="test">
                                    <i class="fas fa-thumbtack"></i>
                                </button>

                                <div class="icon-wrapper">
                                    <i class="fas fa-layer-group"></i>
                                </div>

                                <div class="test-title-modern">{{ $test->title }}</div>

                                <div class="stats-container-modern">
                                    <div class="stat-box-modern">
                                        <span class="label">مقبول</span>
                                        <span class="value val-accepted">{{ $accepted }}</span>
                                    </div>
                                    <div class="stat-box-modern">
                                        <span class="label">مرفوض</span>
                                        <span class="value val-rejected">{{ $rejected }}</span>
                                    </div>
                                </div>

                                <div class="progress-section-modern">
                                    <div class="progress-header">
                                        <span>الإجمالي: <strong>{{ $total }}</strong></span>
                                        <span class="fw-bold">{{ round($pAcc) }}% مقبول</span>
                                    </div>
                                    <div class="progress-bar-stack">
                                        <div class="progress-bar bg-success" style="width: {{ $pAcc }}%"></div>
                                        <div class="progress-bar bg-danger" style="width: {{ $pRej }}%"></div>
                                        <div class="progress-bar bg-warning" style="width: {{ $pRes }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <style>
            /* --- المتغيرات المودرن --- */
            :root {
                /* Light Mode */
                --card-gradient: linear-gradient(-180deg, #5c7ea2, #3f6791);
                --glass-bg: rgba(255, 255, 255, 0.15);
                --glass-border: rgba(255, 255, 255, 0.2);
                --text-bright: #ffffff;
                --text-sub: #e0e6ed;
                --success-modern: #2ecc71;
                /* أخضر زاهي */
                --danger-modern: #e74c3c;
                /* أحمر زاهي */
                --warning-modern: #f1c40f;
            }

            .dark-mode :root,
            body.dark-mode {
                /* Dark Mode - جعلنا التدرج أغمق قليلاً ليتناسب مع بيئة الدارك */
                --card-gradient: linear-gradient(-180deg, #2c3e50, #1a252f);
                --glass-bg: rgba(0, 0, 0, 0.2);
                --glass-border: rgba(255, 255, 255, 0.05);
                --text-bright: #f8f9fa;
                --text-sub: #bdc3c7;
            }

            /* --- تنسيق الكارت المودرن --- */
            .test-card-modern {
                background: #3f6791 !important;
                border-radius: 24px;
                padding: 22px;
                border: 1px solid var(--glass-border);
                transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-direction: column;
                min-width: 290px;
                text-decoration: none !important;
                position: relative;
                overflow: hidden;
            }

            /* تأثير الإضاءة عند التحويم */
            .test-card-modern:hover {
                transform: translateY(-8px) scale(1.01);
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            }

            /* .test-card-modern::after {
                                                                                                            content: "";
                                                                                                            position: absolute;
                                                                                                            top: -50%;
                                                                                                            left: -50%;
                                                                                                            width: 200%;
                                                                                                            height: 200%;
                                                                                                            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
                                                                                                            opacity: 0;
                                                                                                            transition: opacity 0.4s;
                                                                                                        } */

            .test-card-modern:hover::after {
                opacity: 1;
            }

            /* --- العناصر الداخلية --- */
            .icon-wrapper {
                width: 48px;
                height: 48px;
                background: var(--glass-bg);
                backdrop-filter: blur(8px);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--text-bright);
                font-size: 1.2rem;
                margin-bottom: 18px;
                border: 1px solid var(--glass-border);
            }

            .test-title-modern {
                color: var(--text-bright);
                font-weight: 700;
                font-size: 1.15rem;
                margin-bottom: 20px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* صف الإحصائيات */
            .stats-container-modern {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
                margin-bottom: 20px;
            }

            .stat-box-modern {
                background: var(--glass-bg);
                padding: 12px;
                border-radius: 18px;
                text-align: center;
                border: 1px solid var(--glass-border);
            }

            .stat-box-modern .label {
                color: var(--text-sub);
                font-size: 0.75rem;
                display: block;
                margin-bottom: 4px;
                font-weight: 500;
            }

            .stat-box-modern .value {
                font-size: 1.25rem;
                font-weight: 800;
            }

            /* الألوان المطلوبة */
            .val-accepted {
                color: var(--success-modern) !important;
            }

            .val-rejected {
                color: var(--danger-modern) !important;
            }

            /* شريط التقدم */
            .progress-section-modern {
                background: var(--glass-bg);
                padding: 15px;
                border-radius: 20px;
                border: 1px solid var(--glass-border);
            }

            .progress-header {
                display: flex;
                justify-content: space-between;
                color: var(--text-bright);
                font-size: 0.85rem;
                margin-bottom: 10px;
            }

            .progress-bar-stack {
                height: 8px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                display: flex;
                overflow: hidden;
            }

            /* زر التثبيت */
            .btn-pin-top {
                position: absolute;
                top: 20px;
                left: 20px;
                /* بما أن الاتجاه RTL */
                background: var(--glass-bg);
                border: none;
                color: var(--text-bright);
                padding: 6px 10px;
                border-radius: 10px;
                backdrop-filter: blur(5px);
                transition: 0.3s;
            }

            .btn-pin-top:hover {
                background: var(--warning-modern);
                color: #000;
            }
        </style>

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
        <div class="card card-outline shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
            <div class="modern-card-header">
                <div class="header-title-wrapper">
                    <div class="title-icon"><i class="fas fa-users"></i></div>
                    <h3 class="modern-card-title">المجموعات</h3>
                    <span class="test-count-pill">{{ $groups->count() }}</span>
                </div>
                <div class="scroll-actions">
                    <button id="scrollRightGroups" class="btn-scroll-custom"><i class="fas fa-chevron-right"></i></button>
                    <button id="scrollLeftGroups" class="btn-scroll-custom"><i class="fas fa-chevron-left"></i></button>
                </div>
            </div>

            <div class="card-body bg-light-custom">
                <div id="groupsContainer" class="d-flex overflow-auto py-2"
                    style="scroll-behavior: smooth; gap: 20px; white-space: nowrap; padding-bottom: 15px;">

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

                        <div class="col-md-3" style="min-width: 300px; flex: 0 0 auto; position: relative;">
                            <button type="button" class="btn-pin btn-pin-group" data-id="{{ $group->id }}"
                                data-type="group">
                                <i class="fas fa-thumbtack"></i>
                            </button>

                            <a href="{{ route('group.customer', $group->id) }}" class="group-card-modern shadow-sm">
                                <div>
                                    <div class="group-icon-circle">
                                        <i class="fas fa-kaaba"></i>
                                    </div>
                                    <span class="group-title-text text-truncate" title="{{ $group->title }}">
                                        {{ $group->title }}
                                    </span>

                                    <div class="glass-stat-row">
                                        <small class="fw-bold">عدد العملاء</small>
                                        <span class="badge bg-primary rounded-pill">{{ $totalCustomers }}</span>
                                    </div>

                                    <div class="glass-stat-row">
                                        <small class="fw-bold">مؤهل للقنصلية</small>
                                        <span class="badge bg-success rounded-pill">{{ $qualifiedCustomers }}</span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    @if ($group->visaProfession && $group->visaType)
                                        @php
                                            $percentage =
                                                $totalCustomers > 0 ? ($qualifiedCustomers / $totalCustomers) * 100 : 0;
                                        @endphp
                                        <div class="d-flex justify-content-between text-white mb-1">
                                            <small>نسبة الجاهزية</small>
                                            <small class="fw-bold">{{ round($percentage) }}%</small>
                                        </div>
                                        <div class="progress progress-slim">
                                            <div class="progress-bar bg-white" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    @else
                                        <small class="text-white-50 fst-italic" style="font-size: 0.75rem;">
                                            مربوطة بالتأشيرة / غير مربوطة بالمهنة
                                        </small>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <style>
            /* --- تنسيق كارت المجموعات المودرن --- */
            .group-card-modern {
                background: linear-gradient(135deg, #17a2b8, #117a8b) !important;
                /* لون Info الأصلي بتدرج */
                border-radius: 20px;
                padding: 20px;
                min-width: 290px;
                position: relative;
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.1);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                height: 100%;
                text-decoration: none !important;
            }

            .group-card-modern:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(23, 162, 184, 0.3);
            }

            /* تأثير الدارك مود للمجموعات */
            .dark-mode .group-card-modern {
                background: linear-gradient(135deg, #0f6674, #0a4b55) !important;
                border-color: rgba(255, 255, 255, 0.05);
            }

            /* الصناديق الداخلية (البيضاء الشفافة) */
            .glass-stat-row {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(5px);
                border-radius: 12px;
                padding: 8px 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
            }

            /* زر التثبيت الخاص بالمجموعات */
            .btn-pin-group {
                position: absolute;
                top: 15px;
                left: 15px;
                z-index: 5;
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                width: 32px;
                height: 32px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: 0.3s;
            }

            .btn-pin-group.btn-warning {
                background: #ffc107 !important;
                color: #000 !important;
            }

            .group-icon-circle {
                width: 45px;
                height: 45px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                color: white;
                margin-bottom: 15px;
            }

            .group-title-text {
                font-weight: 800;
                color: white;
                font-size: 1.1rem;
                margin-bottom: 15px;
                display: block;
            }

            /* تخصيص شريط التقدم ليكون نحيفاً وأنيقاً */
            .progress-slim {
                height: 10px !important;
                border-radius: 20px !important;
                background: rgba(0, 0, 0, 0.1) !important;
                margin-top: 10px;
            }
        </style>

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
        <style>
            /* --- تنسيق كارت الحقائب المودرن --- */
            .bag-card-modern {
                background: linear-gradient(135deg, #28a745, #1e7e34) !important;
                /* لون Success الأصلي بتدرج */
                border-radius: 20px;
                padding: 20px;
                min-width: 290px;
                position: relative;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid rgba(255, 255, 255, 0.1);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                text-decoration: none !important;
                height: 100%;
            }

            .bag-card-modern:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 25px rgba(40, 167, 69, 0.3);
            }

            /* تحسين المظهر في الدارك مود للحقائب */
            .dark-mode .bag-card-modern {
                background: linear-gradient(135deg, #1e7e34, #145523) !important;
                border-color: rgba(255, 255, 255, 0.05);
            }

            /* صناديق البيانات الداخلية */
            .bag-glass-row {
                background: rgba(255, 255, 255, 0.12);
                backdrop-filter: blur(4px);
                border-radius: 12px;
                padding: 10px 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 8px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
            }

            /* أيقونة الحقيبة */
            .bag-icon-wrapper {
                width: 45px;
                height: 45px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem;
                color: white;
                margin-bottom: 15px;
            }

            .bag-title-text {
                font-weight: 800;
                color: white;
                font-size: 1.2rem;
                margin-bottom: 15px;
                display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* زر التثبيت الخاص بالحقائب */
            .btn-pin-bag {
                position: absolute;
                top: 20px;
                left: 20px;
                z-index: 10;
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                width: 34px;
                height: 34px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: 0.3s;
            }

            .btn-pin-bag.btn-warning {
                background: #ffc107 !important;
                color: #000 !important;
                box-shadow: 0 0 10px rgba(255, 193, 7, 0.4);
            }

            /* شريط تقدم الحقائب */
            .progress-bag-modern {
                height: 12px !important;
                border-radius: 20px !important;
                background: rgba(0, 0, 0, 0.15) !important;
                overflow: hidden;
            }
        </style>

        <div class="card card-outline shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
            <div class="modern-card-header">
                <div class="header-title-wrapper">
                    <div class="title-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                        <i class="fas fa-suitcase"></i>
                    </div>
                    <h3 class="modern-card-title">الحقائب</h3>
                    <span class="test-count-pill">{{ $bags->count() }}</span>
                </div>
                <div class="scroll-actions">
                    <button id="scrollRightBags" class="btn-scroll-custom"><i class="fas fa-chevron-right"></i></button>
                    <button id="scrollLeftBags" class="btn-scroll-custom"><i class="fas fa-chevron-left"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div id="bagsContainer" class="d-flex overflow-auto py-2"
                    style="scroll-behavior: smooth; gap: 20px; white-space: nowrap; padding-bottom: 15px;">

                    @foreach ($bags as $bag)
                        @php
                            $totalCustomers = count($bag->customers);
                            $customersWithVisaNumber = $bag->customers
                                ->whereNotNull('visa_number')
                                ->where('visa_number', '!=', '')
                                ->count();

                            $percentage =
                                $totalCustomers > 0 ? round(($customersWithVisaNumber / $totalCustomers) * 100) : 0;

                            // تحديد لون شريط التقدم بناءً على النسبة
                            $barColor = 'bg-white'; // لون افتراضي يتناسب مع الأخضر
                            if ($percentage < 40) {
                                $barColor = 'bg-danger';
                            } elseif ($percentage < 75) {
                                $barColor = 'bg-warning';
                            }
                        @endphp

                        <div class="col-md-3" style="min-width: 300px; flex: 0 0 auto; position: relative;">
                            <button type="button" class="btn-pin btn-pin-bag" data-id="{{ $bag->id }}"
                                data-type="bag">
                                <i class="fas fa-thumbtack"></i>
                            </button>

                            <a href="{{ route('bags.customers', $bag->id) }}" class="bag-card-modern shadow-sm">
                                <div>
                                    <div class="bag-icon-wrapper">
                                        <i class="fas fa-suitcase"></i>
                                    </div>

                                    <span class="bag-title-text" title="{{ $bag->name }}">
                                        {{ $bag->name }}
                                    </span>

                                    <div class="bag-glass-row">
                                        <small class="fw-bold">إجمالي العملاء</small>
                                        <span class="fw-bold">{{ $totalCustomers }}</span>
                                    </div>

                                    <div class="bag-glass-row">
                                        <small class="fw-bold">برقم تأشيرة</small>
                                        <span class="fw-bold">{{ $customersWithVisaNumber }}</span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="d-flex justify-content-between text-white mb-1">
                                        <small style="font-size: 0.75rem;">نسبة الإنجاز</small>
                                        <small class="fw-bold">{{ $percentage }}%</small>
                                    </div>
                                    <div class="progress progress-bag-modern">
                                        <div class="progress-bar {{ $barColor }}" role="progressbar"
                                            style="width: {{ $percentage }}%">
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


        <style>
            /* --- تنسيق كارت التأشيرات المودرن --- */
            .visa-card-modern {
                background: linear-gradient(135deg, #2ecc71, #27ae60) !important;
                /* درجة أخضر زاهية للتأشيرات */
                border-radius: 20px;
                padding: 20px;
                min-width: 280px;
                position: relative;
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.1);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                text-decoration: none !important;
                height: 100%;
            }

            .visa-card-modern:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(46, 204, 113, 0.2);
            }

            /* صفوف البيانات الشفافة */
            .visa-glass-row {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(4px);
                border-radius: 12px;
                padding: 8px 12px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 8px;
                color: white;
            }

            .visa-icon-box {
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.25);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                color: white;
                margin-bottom: 12px;
            }

            .visa-period-tag {
                font-size: 0.75rem;
                background: rgba(0, 0, 0, 0.2);
                padding: 2px 8px;
                border-radius: 6px;
                color: #eee;
                display: inline-block;
                margin-top: 5px;
            }

            .btn-pin-visa {
                position: absolute;
                top: 15px;
                left: 15px;
                z-index: 10;
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                width: 30px;
                height: 30px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .btn-pin-visa.btn-warning {
                background: #ffc107 !important;
                color: black !important;
            }
        </style>

        <div class="card card-outline shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
            <div class="modern-card-header">
                <div class="header-title-wrapper">
                    <div class="title-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                        <i class="fas fa-passport"></i>
                    </div>
                    <h3 class="modern-card-title">التأشيرات</h3>
                    <span class="test-count-pill">{{ $visas->count() }}</span>
                </div>
                <div class="scroll-actions">
                    <button id="visaScrollRight" class="btn-scroll-custom"><i class="fas fa-chevron-right"></i></button>
                    <button id="visaScrollLeft" class="btn-scroll-custom"><i class="fas fa-chevron-left"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div id="visaScrollContainer" class="d-flex overflow-auto py-2"
                    style="scroll-behavior: smooth; gap: 20px; white-space: nowrap; padding-bottom: 15px;">

                    @foreach ($visas as $visa)
                        @php
                            $totalCustomers = $visa->customerGroups->sum(fn($g) => $g->customers->count());
                            $totalOutgoing = $visa->customerGroups->sum(
                                fn($g) => $g->customers->where('status', 'تم السفر')->count(),
                            );
                            $percentage = $totalCustomers > 0 ? ($totalOutgoing / $totalCustomers) * 100 : 0;
                        @endphp

                        <div class="col-md-3" style="min-width: 280px; flex: 0 0 auto; position: relative;">
                            <button type="button" class="btn-pin btn-pin-visa" data-id="{{ $visa->id }}"
                                data-type="visa">
                                <i class="fas fa-thumbtack"></i>
                            </button>

                            <a href="{{ route('groups.visa', $visa->id) }}" class="visa-card-modern shadow-sm">
                                <div>
                                    <div class="visa-icon-box">
                                        <i class="fas fa-passport"></i>
                                    </div>

                                    <span class="fw-bold text-white d-block mb-2 text-truncate"
                                        title="{{ $visa->name }}">
                                        {{ $visa->name }}
                                    </span>

                                    <div class="visa-glass-row">
                                        <small>إجمالي العملاء</small>
                                        <span class="fw-bold">{{ $totalCustomers }}</span>
                                    </div>

                                    <div class="visa-glass-row">
                                        <small>تم السفر</small>
                                        <span class="fw-bold">{{ $totalOutgoing }}</span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="progress progress-slim bg-dark-transparent"
                                        style="height: 8px !important;">
                                        <div class="progress-bar bg-white" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <span class="visa-period-tag">{{ $visa->visa_peroid }}</span>
                                        <small class="text-white fw-bold">{{ round($percentage) }}%</small>
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


        <div class="card history-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table modern-table align-middle text-center mb-0">
                        <thead>
                            <tr>
                                <th scope="col">الموظف</th>
                                <th scope="col">الطرف المعني</th>
                                <th scope="col">التصنيف</th>
                                <th scope="col">تفاصيل النشاط</th>
                                <th scope="col">التوقيت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories as $history)
                                <tr>
                                    <td class="text-start pr-4">
                                        <div class="d-flex align-items-center">

                                            <a href="{{ route('users.history', $history->user->id) }}"
                                                class="text-decoration-none fw-bold"
                                                style="color: var(--header-text, #1e293b);">
                                                {{ $history->user->name ?? '-' }}
                                            </a>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($history->customer)
                                            <a href="{{ route('customer.show', $history->customer->id) }}"
                                                class="text-decoration-none fw-bold text-primary">
                                                <i class="fas fa-user-check me-1"></i> {{ $history->customer->name_ar }}
                                            </a>
                                        @elseif($history->lead)
                                            <a href="{{ route('leads-customers.show', $history->lead->id) }}"
                                                class="text-decoration-none fw-bold text-warning">
                                                <i class="fas fa-user-tag me-1"></i> {{ $history->lead->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">نظام عام</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($history->customer)
                                            <span class="badge rounded-pill bg-soft-primary px-3 py-2"
                                                style="background: rgba(13, 110, 253, 0.1); color: #0d6efd;">عميل
                                                أساسي</span>
                                        @elseif($history->lead)
                                            <span class="badge rounded-pill bg-soft-warning px-3 py-2"
                                                style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">عميل
                                                محتمل</span>
                                        @else
                                            <span class="badge rounded-pill bg-soft-secondary px-3 py-2">أخرى</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="description-text mx-auto text-truncate-2">
                                            {{ $history->description }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="time-badge">
                                            <i class="far fa-clock"></i>
                                            {{ $history->created_at->diffForHumans() }}
                                            <br>
                                            <small style="font-size: 10px opacity: 0.7">
                                                {{ $history->created_at->format('Y/m/d H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80"
                                            style="opacity: 0.2">
                                        <p class="text-muted mt-3">سجل النشاطات فارغ تماماً</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            /* الحاوية الرئيسية */
            .tasks-card {
                border: none;
                border-radius: 20px;
                background: #ffffff;
                /* افتراضي لايت */
                transition: background 0.3s ease;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
            }

            /* تحويل الحاوية في الدارك مود */
            .dark-mode .tasks-card {
                background: #1e293b !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
            }

            .tasks-table {
                border-collapse: separate;
                border-spacing: 0 12px;
                /* مسافة بين الكروت */
            }

            .tasks-table thead th {
                background: transparent !important;
                color: #64748b;
                border: none;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.5px;
            }

            /* تنسيق الصف (الكارت) */
            .tasks-table tbody tr {
                background: #ffffff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
                transition: all 0.3s ease;
                border-radius: 12px;
            }

            /* الدارك مود للصفوف */
            .dark-mode .tasks-table tbody tr {
                background: rgba(255, 255, 255, 0.03) !important;
            }

            .tasks-table tbody tr:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            }

            /* تمييز الحالات بالخط الجانبي */
            .row-new {
                border-right: 5px solid #f59e0b !important;
            }

            .row-done {
                border-right: 5px solid #10b981 !important;
            }

            .tasks-table td {
                padding: 16px !important;
                border: none !important;
                color: #334155;
                /* لون نص اللايت */
            }

            .dark-mode .tasks-table td {
                color: #e2e8f0 !important;
            }

            /* تنسيق الروابط والأسماء */
            .user-name-cell {
                font-weight: 700;
                color: inherit;
            }

            /* شارات الحالة المودرن */
            .status-badge {
                padding: 6px 14px;
                border-radius: 10px;
                font-size: 0.75rem;
                font-weight: 800;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .status-new-modern {
                background: rgba(245, 158, 11, 0.12);
                color: #d97706;
            }

            .status-done-modern {
                background: rgba(16, 185, 129, 0.12);
                color: #059669;
            }

            /* أيقونة الوقت */
            .time-wrapper {
                font-size: 0.8rem;
                color: #94a3b8;
            }
        </style>
        <div class="card tasks-card">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table tasks-table align-middle text-center mb-0">
                        <thead>
                            <tr>
                                <th>👤 المرسل</th>
                                <th>👥 المستلم</th>
                                <th class="text-start">📝 الوصف</th>
                                <th>⏰ الوقت</th>
                                <th>📌 الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr class="{{ $task->status == 'new' ? 'row-new' : 'row-done' }}">
                                    <td>
                                        <span class="user-name-cell">{{ $task->sender->name ?? '-' }}</span>
                                    </td>

                                    <td>
                                        <span class="text-muted fw-semibold">{{ $task->receiver->name ?? '-' }}</span>
                                    </td>

                                    <td class="text-start">
                                        <div style="max-width: 280px; white-space: normal; line-height: 1.5; font-size: 0.85rem;"
                                            title="{{ $task->description }}">
                                            {{ \Illuminate\Support\Str::limit($task->description, 70) }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="time-wrapper">
                                            <div class="mb-1"><i class="far fa-calendar-check me-1"></i>
                                                {{ $task->created_at->format('Y-m-d') }}</div>
                                            <div class="fw-bold"><i class="far fa-clock me-1"></i>
                                                {{ $task->created_at->format('H:i') }}</div>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($task->status == 'new')
                                            <span class="status-badge status-new-modern">
                                                <i class="fas fa-dot-circle fa-beat-fade"></i> جديدة
                                            </span>
                                        @elseif($task->status == 'done')
                                            <span class="status-badge status-done-modern">
                                                <i class="fas fa-check-double"></i> مكتملة
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">غير معروف</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5">
                                        <div class="text-center opacity-50">
                                            <i class="fas fa-clipboard-list fa-4x mb-3"></i>
                                            <h5 class="fw-bold">لا يوجد مهام حالياً</h5>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <style>
            <style>

            /* تنسيق الحاويات الرئيسي */
            .stats-card {
                border: none;
                border-radius: 20px;
                background: #ffffff;
                transition: all 0.3s ease;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05) !important;
                overflow: hidden;
            }

            .dark-mode .stats-card {
                background: #1e293b !important;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2) !important;
            }

            /* رأس الكارت المودرن */
            .stats-header {
                padding: 15px 20px;
                border: none;
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: transparent !important;
            }

            .stats-title {
                font-size: 1rem;
                font-weight: 700;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            /* أيقونات بجانب العناوين */
            .title-icon-wrapper {
                width: 35px;
                height: 35px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }

            /* تخصيص الألوان لكل قسم */
            .icon-primary {
                background: rgba(13, 110, 253, 0.1);
                color: #0d6efd;
            }

            .icon-info {
                background: rgba(13, 202, 240, 0.1);
                color: #0dcaf0;
            }

            .icon-success {
                background: rgba(25, 135, 84, 0.1);
                color: #198754;
            }

            .icon-warning {
                background: rgba(255, 193, 7, 0.1);
                color: #ffc107;
            }

            .icon-secondary {
                background: rgba(108, 117, 125, 0.1);
                color: #6c757d;
            }

            /* تحسين شكل الفلتر */
            .modern-select {
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                font-size: 0.85rem;
                padding: 5px 10px;
                cursor: pointer;
            }

            .dark-mode .modern-select {
                background: #0f172a;
                color: white;
                border-color: #334155;
            }

            /* تأثير المرور على الكارت */
            .stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
            }
        </style>
        </style>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="stats-header">
                            <h5 class="stats-title" style="color: #0d6efd;">
                                <div class="title-icon-wrapper icon-primary"><i class="fas fa-chart-line"></i></div>
                                إحصائيات العملاء
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="customers" height="180"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="stats-header">
                            <h5 class="stats-title" style="color: #0dcaf0;">
                                <div class="title-icon-wrapper icon-info"><i class="fas fa-layer-group"></i></div>
                                إحصائيات المجموعات
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="groupsChart" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="stats-header">
                            <h5 class="stats-title" style="color: #198754;">
                                <div class="title-icon-wrapper icon-success"><i class="fas fa-users-cog"></i></div>
                                المناديب والعملاء
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="delegatesChart" height="180"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="stats-header">
                            <h5 class="stats-title" style="color: #f59e0b;">
                                <div class="title-icon-wrapper icon-warning"><i class="fas fa-user-clock"></i></div>
                                العملاء المحتملين
                            </h5>
                            <select id="filterSelect" class="form-select modern-select w-auto shadow-sm">
                                <option value="day">اليوم</option>
                                <option value="month" selected>الشهر</option>
                                <option value="year">السنة</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <canvas id="potentialChart" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-8 mb-4">
                    <div class="card stats-card h-100">
                        <div class="stats-header border-bottom mb-2">
                            <h5 class="stats-title" style="color: #64748b;">
                                <div class="title-icon-wrapper icon-secondary"><i class="fas fa-passport"></i></div>
                                إحصائيات التأشيرات الإجمالية
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="visaChart" height="220"></canvas>
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
