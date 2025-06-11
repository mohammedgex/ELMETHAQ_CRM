@extends('adminlte::page')

@section('title', 'تحديد الصلاحيات')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;">تحديد صلاحيات المستخدم</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg p-4 border-0" style="border-radius: 15px; background-color: #f8f9fa;">
                <div class="mb-12 p-3 shadow-sm rounded"
                    style="background-color: #f8f9fa; border-right: 5px solid #997a44; margin-bottom: 50px">
                    <h5 class="mb-1 text-dark" style="font-weight: bold;">
                        👤 {{ $user->name }}
                    </h5>
                    <p class="mb-0 text-muted">
                        📧 {{ $user->email }}
                    </p>
                </div>

                <h4 class="mb-3 text-dark font-weight-bold">اختر الصلاحيات</h4>

                <form method="POST" action="{{ route('permissions.edit', $user->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-19" name="permissions[]" value="customers-show"
                                        @if (in_array('customers-show', $userPermissions)) checked @endif />
                                    <label for="cbtest-19" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-19">
                                    عرض العملاء
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-20" name="permissions[]" value="create-customer"
                                        @if (in_array('create-customer', $userPermissions)) checked @endif />
                                    <label for="cbtest-20" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-20">
                                    إضافة عميل
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-21" name="permissions[]" value="show-customer"
                                        @if (in_array('show-customer', $userPermissions)) checked @endif />
                                    <label for="cbtest-21" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-21">
                                    عرض العميل
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-22" name="permissions[]" value="visa-type-create"
                                        @if (in_array('visa-type-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-22" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-22">
                                    تعريف التاشيرة
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-23" name="permissions[]" value="embassy-create"
                                        @if (in_array('embassy-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-23" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-23">
                                    تعريف القنصلية
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-24" name="permissions[]" value="sponser-create"
                                        @if (in_array('sponser-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-24" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-24">
                                    تعريف الكفيل
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-25" name="permissions[]" value="delegate-create"
                                        @if (in_array('delegate-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-25" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-25">
                                    تعريف المناديب
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-26" name="permissions[]" value="message-create"
                                        @if (in_array('message-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-26" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-26">
                                    تعريف قوالب الرسائل
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-27" name="permissions[]" value="bag-create"
                                        @if (in_array('bag-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-27" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-27">
                                    تعريف الحقائب
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-28" name="permissions[]" value="group-create"
                                        @if (in_array('group-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-28" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-28">
                                    تعريف المجموعات
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-29" name="permissions[]" value="file-create"
                                        @if (in_array('file-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-29" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-29">
                                    تعريف المستندات
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check d-flex">
                                <div class="checkbox-wrapper-19">
                                    <input type="checkbox" id="cbtest-30" name="permissions[]" value="payment-create"
                                        @if (in_array('payment-create', $userPermissions)) checked @endif />
                                    <label for="cbtest-30" class="check-box">
                                </div>
                                <label class="form-check-label" for="cbtest-30">
                                    تعريف المعاملات المالية
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- زر حفظ -->
                    <button type="submit" class="btn mt-4 px-4 shadow-sm"
                        style="background-color: #997a44; color: white;">
                        حفظ الصلاحيات المختارة
                    </button>
                </form>


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
