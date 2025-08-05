@extends('adminlte::page')

@section('title', 'تحديد الصلاحيات')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تحديد صلاحيات المستخدم</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark shadow-lg" style="border-radius: 15px; background-color: #343a40;">
                <div class="card-body">

                    <!-- معلومات المستخدم -->
                    <div class="mb-4 p-3 shadow-sm rounded"
                        style="background-color: #495057; border-right: 5px solid #997a44;">
                        <h5 class="mb-1 text-white font-weight-bold">
                            👤 {{ $user->name }}
                        </h5>
                        <p class="mb-0 text-light">
                            📧 {{ $user->email }}
                        </p>
                    </div>

                    <!-- عنوان -->
                    <h4 class="mb-4 text-white font-weight-bold">اختر الصلاحيات</h4>

                    <form method="POST" action="{{ route('permissions.edit', $user->id) }}">
                        @csrf

                        <div class="row">
                            @php
                                $permissions = [
                                    'dashboard-access' => 'لوحة التحكم',
                                    'leads-customers-show' => 'العملاء المحتملون',
                                    'customers-show' => 'عرض العملاء',
                                    'create-customer' => 'إضافة عميل',
                                    'show-customer' => 'عرض العميل',
                                    'visa-type-create' => 'تعريف التأشيرة',
                                    'embassy-create' => 'تعريف القنصلية',
                                    'sponser-create' => 'تعريف الكفيل',
                                    'delegate-create' => 'تعريف المناديب',
                                    'message-create' => 'تعريف قوالب الرسائل',
                                    'bag-create' => 'تعريف الحقائب',
                                    'group-create' => 'تعريف المجموعات',
                                    'file-create' => 'تعريف المستندات',
                                    'payment-create' => 'تعريف المعاملات المالية',
                                    'test-create' => 'الاختبارات',
                                    'job-create' => 'تعريف الوظائف',
                                    'bulk-sms-access' => 'ارسال رسائل',
                                    'tasks-access' => 'المهام',
                                    'users-manage' => 'المستخدم',
                                    'company-settings' => 'اعدادات الشركة',
                                    'archived-customers' => 'ارشيف العملاء',
                                    'taakeb-show' => 'طلبات التعقيب',
                                    'requests-show' => 'طلبات الملفات',
                                ];
                            @endphp

                            @foreach ($permissions as $value => $label)
                                <div class="col-md-3 mb-3">
                                    <div class="form-check d-flex align-items-center text-white">
                                        <input class="form-check-input me-2" type="checkbox" id="perm_{{ $loop->index }}"
                                            name="permissions[]" value="{{ $value }}"
                                            @if (in_array($value, $userPermissions)) checked @endif>
                                        <label class="form-check-label" for="perm_{{ $loop->index }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- زر الحفظ -->
                        <button type="submit" class="btn mt-4 px-4 shadow-sm btn-success" style=" color: white;">
                            حفظ الصلاحيات المختارة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop



@section('css')
    <style>
        .form-check-label {
            font-weight: bold;
            margin-right: 8px;
        }

        .form-check-input {
            border-color: #997a44;
        }

        .form-check-input:checked {
            background-color: #997a44;
            border-color: #997a44;
        }

        .btn {
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .checkbox-wrapper-19 {
            box-sizing: border-box;
            --background-color: #997a44;
            --checkbox-height: 25px;
        }

        @-moz-keyframes dothabottomcheck-19 {
            0% {
                height: 0;
            }

            100% {
                height: calc(var(--checkbox-height) / 2);
            }
        }

        @-webkit-keyframes dothabottomcheck-19 {
            0% {
                height: 0;
            }

            100% {
                height: calc(var(--checkbox-height) / 2);
            }
        }

        @keyframes dothabottomcheck-19 {
            0% {
                height: 0;
            }

            100% {
                height: calc(var(--checkbox-height) / 2);
            }
        }

        @keyframes dothatopcheck-19 {
            0% {
                height: 0;
            }

            50% {
                height: 0;
            }

            100% {
                height: calc(var(--checkbox-height) * 1.2);
            }
        }

        @-webkit-keyframes dothatopcheck-19 {
            0% {
                height: 0;
            }

            50% {
                height: 0;
            }

            100% {
                height: calc(var(--checkbox-height) * 1.2);
            }
        }

        @-moz-keyframes dothatopcheck-19 {
            0% {
                height: 0;
            }

            50% {
                height: 0;
            }

            100% {
                height: calc(var(--checkbox-height) * 1.2);
            }
        }

        .checkbox-wrapper-19 input[type=checkbox] {
            display: none;
        }

        .checkbox-wrapper-19 .check-box {
            height: var(--checkbox-height);
            width: var(--checkbox-height);
            background-color: transparent;
            border: calc(var(--checkbox-height) * .1) solid #000;
            border-radius: 5px;
            position: relative;
            display: inline-block;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -moz-transition: border-color ease 0.2s;
            -o-transition: border-color ease 0.2s;
            -webkit-transition: border-color ease 0.2s;
            transition: border-color ease 0.2s;
            cursor: pointer;
        }

        .checkbox-wrapper-19 .check-box::before,
        .checkbox-wrapper-19 .check-box::after {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            position: absolute;
            height: 0;
            width: calc(var(--checkbox-height) * .2);
            background-color: #997a44;
            display: inline-block;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            -o-transform-origin: left top;
            -webkit-transform-origin: left top;
            transform-origin: left top;
            border-radius: 5px;
            content: " ";
            -webkit-transition: opacity ease 0.5;
            -moz-transition: opacity ease 0.5;
            transition: opacity ease 0.5;
        }

        .checkbox-wrapper-19 .check-box::before {
            top: calc(var(--checkbox-height) * .72);
            left: calc(var(--checkbox-height) * .41);
            /* box-shadow: 0 0 0 calc(var(--checkbox-height) * .05) var(--background-color); */
            -moz-transform: rotate(-135deg);
            -ms-transform: rotate(-135deg);
            -o-transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            transform: rotate(-135deg);
        }

        .checkbox-wrapper-19 .check-box::after {
            top: calc(var(--checkbox-height) * .37);
            left: calc(var(--checkbox-height) * .05);
            -moz-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .checkbox-wrapper-19 input[type=checkbox]:checked+.check-box,
        .checkbox-wrapper-19 .check-box.checked {
            border-color: #997a44;
        }

        .checkbox-wrapper-19 input[type=checkbox]:checked+.check-box::after,
        .checkbox-wrapper-19 .check-box.checked::after {
            height: calc(var(--checkbox-height) / 2);
            -moz-animation: dothabottomcheck-19 0.2s ease 0s forwards;
            -o-animation: dothabottomcheck-19 0.2s ease 0s forwards;
            -webkit-animation: dothabottomcheck-19 0.2s ease 0s forwards;
            animation: dothabottomcheck-19 0.2s ease 0s forwards;
        }

        .checkbox-wrapper-19 input[type=checkbox]:checked+.check-box::before,
        .checkbox-wrapper-19 .check-box.checked::before {
            height: calc(var(--checkbox-height) * 1.2);
            -moz-animation: dothatopcheck-19 0.4s ease 0s forwards;
            -o-animation: dothatopcheck-19 0.4s ease 0s forwards;
            -webkit-animation: dothatopcheck-19 0.4s ease 0s forwards;
            animation: dothatopcheck-19 0.4s ease 0s forwards;
        }
    </style>
@stop
