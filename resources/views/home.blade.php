@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <h1 style="font-weight:bold">لوحة التحكم</h1>
@stop
@section('content')
    <div class="container-fluid">
        <!-- بطاقات الإحصائيات -->
        <div class="row">
            <div class="col-lg-3 col-6">
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

            <div class="col-lg-3 col-6">
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

            <div class="col-lg-3 col-6">
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

            <div class="col-lg-3 col-6">
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
        </div>

        <!-- قسم الاختبارات -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">الاختبارات ({{ $tests->count() }})</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach ($tests as $test)
                        <div class="col-md-3 col-6 mb-4">
                            <a href="{{ route('test.leads', $test->id) }}" class="text-decoration-none">
                                <div class="info-box bg-gradient-primary">
                                    <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $test->title }}</span>
                                        <span class="info-box-number">{{ $test->leads->count() }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <!-- قسم المجموعات -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">المجموعات ({{ $groups->count() }})</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach ($groups as $group)
                        <div class="col-md-3 col-6 mb-4">
                            <a href="{{ route('group.customer', $group->id) }}" class="text-decoration-none">
                                <div class="info-box bg-gradient-info">
                                    <span class="info-box-icon"><i class="fas fa-kaaba"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $group->title }}</span>
                                        @if ($group->visaProfession)
                                            <span class="info-box-number">
                                                {{ count($group->customers) }} /
                                                {{ $group->visaProfession->profession_count }}
                                            </span>
                                        @endif
                                        @if ($group->visaProfession && $group->visaType)
                                            <div class="progress">
                                                {{-- <div class="progress-bar"
                                                    style="width: {{ (count($group->customers) / $group->visaProfession->profession_count) * 100 }}%">
                                                </div> --}}
                                            </div>
                                        @elseif (!$group->visaProfession && $group->visaType)
                                            <span style="font-size: 12px;color: black;text-decoration: underline;">
                                                مربوطة بالتاشيرة وغير مربوطة بالمهنة
                                            </span>
                                        @elseif ($group->visaProfession && !$group->visaType)
                                            <span style="font-size: 12px;color: black;text-decoration: underline;">
                                                مربوطة بالمهنة وغير مربوطة بالتاشيرة
                                            </span>
                                        @else
                                            <span style="font-size: 12px;color: black;text-decoration: underline;">
                                                غير مربوطة بمهنة او تاشيرة
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- قسم الحقائب -->
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">الحقائب ({{ $bags->count() }})</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach ($bags as $bag)
                        <div class="col-md-3 col-6 mb-4">
                            <a href="{{ route('bags.customers', $bag->id) }}" class="text-decoration-none">
                                <div class="info-box bg-gradient-success">
                                    <span class="info-box-icon"><i class="fas fa-suitcase"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $bag->name }}</span>
                                        <span class="info-box-number">{{ count($bag->customers) }} عميل</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- قسم التاشيرات -->
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">التأشيرات ({{ $visas->count() }})</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach ($visas as $visa)
                        <div class="col-md-3 col-6 mb-4">
                            <a href="{{ route('groups.visa', $visa->id) }}" class="text-decoration-none">
                                <div class="info-box bg-gradient-success">
                                    <span class="info-box-icon"><i class="fas fa-passport"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $visa->name }}</span>
                                        <span class="info-box-number">{{ $visa->outgoing_number }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{ $visa->count }}%"></div>
                                        </div>
                                        <span class="progress-description">
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

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th>اسم الموظف</th>
                            <th>اسم العميل</th>
                            <th>الوصف</th>
                            <th>تاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr>
                                <td>{{ $history->user->name ?? '-' }}</td>
                                <td><a
                                        href="{{ route('customer.show', $history->customer->id) }}">{{ $history->customer->name_ar ?? '-' }}</a>
                                </td>
                                <td>{{ $history->description }}</td>
                                <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">لا توجد تقييمات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
    </style>
@stop

@section('js')

@stop
