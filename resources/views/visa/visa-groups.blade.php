@extends('adminlte::page')

@section('title', 'المجموعات داخل التاشيرة')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">المجموعات داخل التاشيرة</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">عرض كل المجموعات تاشيرة : {{ $visa->name }}</h3>
        </div>
        <div class="card-body">
            <div class="row text-center">
                @forelse ($groups as $group)
                    <div class="col-md-3 col-sm-6 mb-4">
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
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            لا توجد مجموعات حالياً.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@stop
