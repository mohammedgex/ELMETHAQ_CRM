@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <h1 style="font-weight:bold">لوحة التحكم</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6 col-sm-12 mb-3">
        <div class="info-card">
            <div class="icon-container bg-info">
                <i class="fas fa-user-friends"></i>
            </div>
            <div class="info-content">
                <div class="info-title">أجمالي عدد العملاء</div>
                <div class="info-number">1,410</div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 mb-3">
        <div class="info-card">
            <div class="icon-container bg-success">
                <i class="fas fa-eye"></i>
            </div>
            <div class="info-content">
                <div class="info-title">أجمالي عدد المناديب</div>
                <div class="info-number">410</div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 mb-3">
        <div class="info-card">
            <div class="icon-container bg-warning">
                <i class="fas fa-users"></i>
            </div>
            <div class="info-content">
                <div class="info-title">أجمالي المجموعات</div>
                <div class="info-number">13,648</div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 mb-3">
        <div class="info-card">
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
        min-height: 180px;
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
    }

    .info-card .icon-container {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-right: 15px;
        margin-left: 15px;

    }

    .info-card .info-content {
        flex: 1;
    }

    .info-card .info-title {
        font-size: 1.2rem;
        font-weight: normal;
        color: #333;
    }

    .info-card .info-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #555;
    }
</style>
@stop

@section('js')

@stop