@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <h1 style="font-weight:bold">لوحة التحكم</h1>
@stop
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-info">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="info-content">
                    <div class="info-title">أجمالي عدد العملاء</div>
                    <div class="info-number">{{ $customers->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-success">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="info-content">
                    <div class="info-title">أجمالي عدد المناديب</div>
                    <div class="info-number">{{ $delegates->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-warning">
                    <i class="fas fa-users"></i>
                </div>
                <div class="info-content">
                    <div class="info-title">أجمالي المجموعات</div>
                    <div class="info-number">{{ $groups->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-danger">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="info-content">
                    <div class="info-title">أجمالي الموظفين</div>
                    <div class="info-number">{{ $users->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- تقسيمة المجموعات (دوائر ملونة بأيقونة واسم) -->
    <h4 class="mt-4 mb-3" style="font-weight:bold;text-align: center;">المجموعات ({{ $groups->count() }})</h4>
    <div class="row justify-content-center">
        @foreach ($groups as $group)
            <div class="col-auto mb-3">
                <a href="{{ route('group.customer', $group->id) }}" class="text-decoration-none">
                    <div class="group-circle group-madina text-center p-3 shadow rounded">
                        <div class="group-icon mb-2">
                            <i class="fas fa-kaaba fa-2x"></i>
                        </div>
                        <div class="group-name mb-1">
                            <p class="mb-0 font-weight-bold text-truncate px-2" style="max-width: 150px;"
                                title="{{ $group->title }}">
                                {{ $group->title }}
                            </p>
                        </div>
                        <div class="group-count text-muted " style='color:#000 !important'>
                            {{ count($group->customers) }} من {{ $group->visaProfession->profession_count }}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <hr>

    <!-- تقسيمة المجموعات (دوائر ملونة بأيقونة واسم) -->
    <h4 class="mt-4 mb-3" style="font-weight:bold; text-align: center;">الحقائب ({{ $bags->count() }})</h4>
    <div class="row justify-content-center">
        @foreach ($bags as $bag)
            <div class="col-auto mb-3">
                <a href="{{ route('bags.customers', $bag->id) }}" class="text-decoration-none">
                    <div class="group-circle text-center p-3 shadow rounded" style="background-color: #e59a29;">
                        <div class="group-icon mb-2">
                            <i class="fas fa-kaaba fa-2x"></i>
                        </div>
                        <div class="group-name mb-1">
                            <p class="mb-0 font-weight-bold text-truncate px-2" style="max-width: 150px;"
                                title="{{ $bag->name }}">
                                {{ $bag->name }}
                            </p>
                        </div>
                        <div class="group-count" style="color: #000;">
                            {{ count($bag->customers) }} عميل
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

    </div>
    <hr>
    <h4 class="mt-4 mb-3" style="font-weight:bold"> عمليات اليوم</h4>

    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-info">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="info-content">
                    <div class="info-title"> العملاء المضافين اليوم</div>
                    <div class="info-number">
                        {{ $customers->filter(function ($customer) {
                                return $customer->created_at && $customer->created_at->isToday();
                            })->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-success">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="info-content">
                    <div class="info-title"> المؤهلين للنقصلية </div>
                    <div class="info-number">410</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-warning">
                    <i class="fas fa-users"></i>
                </div>
                <div class="info-content">
                    <div class="info-title">أجمالي المجموعات</div>
                    <div class="info-number">13,648</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-card small-card">
                <div class="icon-container bg-danger">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="info-content">
                    <div class="info-title">أجمالي الموظفين</div>
                    <div class="info-number">93,139</div>
                </div>
            </div>
        </div>
    </div>

@stop


@section('css')
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
    </style>
@stop

@section('js')

@stop
