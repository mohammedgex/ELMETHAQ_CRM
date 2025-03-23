@extends('adminlte::page')

@section('title', 'عرض بيانات العميل')

@section('content_header')
<h1 style="font-weight:bold; text-align:right;"> عرض بيانات العميل</h1>
<h6 style="text-align:right;color:#28a745"> * العميل مؤهل للقنصلية *</h6>

@stop

@section('content')
<div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
    style="border-radius: 15px; background-color: #f8f9fa;">

    <ul class="nav nav-tabs nav-fill">
        <li class="nav-item"><a class="nav-link active" style="color: #997a44;" data-bs-toggle="tab" href="#personalInfo">التفاصيل الشخصية</a></li>
        <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab" href="#passportDetails">تفاصيل جواز السفر</a></li>
        <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab" href="#attachments">المرفقات</a></li>
        <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab" href="#payments">المدفوعات</a></li>
        <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab" href="#timelineTab">تقدم العميل</a></li>
    </ul>

    <div class="tab-content mt-3">
        <div id="personalInfo" class="tab-pane fade show active">
            <div class="section-container my-4">
                <h4> البيانات الاساسية </h4>
                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> اسم العميل </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> الرقم القومي </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> رقم الهاتف </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> محافظة الاقامة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> السن </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> تاريخ الميلاد </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> التقييم </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> حالة العميل </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-container my-4">
                <h4> بيانات التواصل </h4>
                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> رقم الهاتف </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> رقم هاتف اخر </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-container my-4">
                <h4> معلومات العمل </h4>
                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> المندوب </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> المجموعة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold"> نوع التأشيرة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold"> الكفيل </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold"> الوظيفة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="section-container my-4">
                <h4> بيانات الرخصة </h4>
                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-4 my-3">
                        <label class="font-weight-bold"> نوع الرخصة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4 my-3">
                        <label class="font-weight-bold"> تاريخ انتهاء الرخصة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-4 my-3">
                        <label class="font-weight-bold"> حالة الرخصة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-container my-4">
                <h4> بيانات التأشيرة </h4>
                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> نوع التأشيرة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> رقم طلب التأشيرة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-container my-4">
                <h4> مراحل العميل </h4>
                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> مرحلة الكشف الطبي </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> مرحلة البصمة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> مرحلة الفايرس </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-6 my-3">
                        <label class="font-weight-bold"> مرحلة التأشيرة </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="section-container my-4">
                <h4> بيانات اضافية </h4>
                <div class="row">
                    <!-- اسم العميل -->
                    <div class="col-md-4 my-3">
                        <label class="font-weight-bold"> الجنسية </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-4 my-3">
                        <label class="font-weight-bold"> المؤهل الدراسي </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4 my-3">
                        <label class="font-weight-bold"> الحالة الاجتماعية </label>
                        <div class="input-group rounded">
                            <p id="textToCopy" class="form-control border-0 m-0"></p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- الوظيفة المقدم عليها -->
                    <div class="col-md-12 my-3">
                        <label class="font-weight-bold"> ملاحظات </label>
                        <div class="input-group rounded" style="height: 100px;">
                            <p id="textToCopy" class="form-control border-0 m-0"> </p>
                            <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="passportDetails" class="tab-pane fade">
        <div class="section-container my-4">
            <h4>بيانات جواز السفر</h4>
            <div class="row">
                <!-- اسم العميل -->
                <div class="col-md-12 my-3">
                    <label class="font-weight-bold"> MRZ </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0"></p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- اسم العميل -->
                <div class="col-md-6 my-3">
                    <label class="font-weight-bold"> الاسم بجواز السفر </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0"></p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- الوظيفة المقدم عليها -->
                <div class="col-md-6 my-3">
                    <label class="font-weight-bold"> رقم جواز السفر </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0"> </p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- اسم العميل -->
                <div class="col-md-4 my-3">
                    <label class="font-weight-bold"> تاريخ الميلاد </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0"></p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- الوظيفة المقدم عليها -->
                <div class="col-md-4 my-3">
                    <label class="font-weight-bold"> تاريخ انتهاء الصلاحية </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0"> </p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-4 my-3">
                    <label class="font-weight-bold"> جهة الاصدار </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0"> </p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <div id="attachments" class="tab-pane fade">
        <h4> المرفقات </h4>
        <table class="table table-bordered mt-3">
            <thead style="background-color: #997a44; color: white;">
                <tr>
                    <th>عنوان المرفق</th>
                    <th>المرفق</th>
                    <th>حالة المرفق</th>
                    <th>ملحوظة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="attachmentTable">
                <!-- بيانات المرفقات ستتم إضافتها هنا -->
            </tbody>
        </table>
    </div>

    <!-- المدفوعات -->
    <div id="payments" class="tab-pane fade">
        <h4> المدفوعات </h4>
        <table class="table table-bordered mt-3">
            <thead style="background-color: #997a44; color: white;">
                <tr>
                    <th>عنوان الدفع</th>
                    <th>المبلغ</th>
                    <th>المتبقي</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="paymentTable">
            </tbody>
        </table>
    </div>

    <div id="timelineTab" class="tab-pane fade">
        <h2 class=" text-center"> تقدم العميل</h2>
        <ul class="timeline" id="timeline">
            <li class="timeline-item">
                <span class="timeline-icon step-1"><i class="fas fa-passport"></i></span>
                <div class="timeline-content">
                    <h3 class="bold">تسجيل البيانات</h3>
                    <p>تم تسجيل البيانات الأساسية</p>
                </div>
            </li>
            <li class="timeline-item">
                <span class="timeline-icon step-2"><i class="fas fa-plane"></i></span>
                <div class="timeline-content">
                    <h3>حجز الكشف الطبي</h3>
                    <p>تم حجز الكشف الطبي</p>
                </div>
            </li>
            <li class="timeline-item">
                <span class="timeline-icon step-3"><i class="fas fa-file-alt"></i></span>
                <div class="timeline-content">
                    <h3> اصدار نتيجة الكشف الطبي</h3>
                    <p> النتيجة ناجح </p>
                </div>
            </li>
        </ul>
    </div>



    <!-- أزرار التحكم -->
    <div class="d-flex justify-content-between mt-4">
        <a href="#"
            class="btn btn-primary shadow-sm flex-grow-1 mx-2 text-center">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="#" class="btn btn-secondary shadow-sm flex-grow-1 mx-2 text-center">
            <i class="fas fa-arrow-left"></i> رجوع
        </a>
        <form action="" method="POST" class="flex-grow-1 mx-2"
            onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger shadow-sm w-100 text-center">
                <i class="fas fa-trash-alt"></i> حذف
            </button>
        </form>
    </div>




    @stop

    @section('css')
    <style>
        .timeline {
            position: relative;
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            width: 4px;
            height: 100%;
            background: #6c757d;
            transform: translateX(50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .timeline-content {
            width: 45%;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
            text-align: right;
        }

        .timeline-item:nth-child(even) .timeline-content {
            margin-right: auto;
            text-align: right;
        }

        .timeline-icon {
            position: absolute;
            top: 50%;
            right: 50%;
            transform: translate(50%, -50%);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .step-1 {
            background: #28a745;
        }

        /* ناجح */
        .step-2 {
            background: #007bff;
        }

        /* قيد التنفيذ */
        .step-3 {
            background: #ffc107;
        }

        /* بانتظار الموافقة */
        .step-4 {
            background: #dc3545;
        }

        /* مرفوض */
        .tab-pane {
            display: none;
        }

        .tab-pane.show {
            display: block;
        }

        .section-container {
            background: rgb(255, 255, 255);
            /* لون فاتح */
            padding: 20px;
            border-radius: 10px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
            margin-bottom: 20px;
            /* تباعد بين الأقسام */
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            height: auto;
            border: 1px solid #ced4da;
            background-color: #e9ecef;
            font-weight: bold;
        }

        .nav-tabs {
            font-weight: 800 !important;
        }

        #attachmentFile {
            border: 1px solid #997a44;
            border-radius: 8px;
            height: 55px;
            font-weight: bold;
            color: #333;
            background-color: #f9f5f0;
            transition: all 0.3s ease-in-out;
            padding: 10px;
        }

        #attachmentFile:hover {
            border-color: #b38f5e;
            background-color: #f1ebe5;
        }

        #attachmentFile:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(153, 122, 68, 0.5);
            border-color: #b38f5e;
        }

        .fw-bold {
            font-size: 16px;
        }

        label.fw-bold {
            display: block;
            margin-bottom: 8px;
            font-size: 18px;
        }
    </style>
    @stop

    @section('js')
    <script>
        $(document).ready(function() {
            $('.nav-tabs a').click(function(e) {
                e.preventDefault(); // منع السلوك الافتراضي

                // إزالة الكلاسات "active" و "show" من جميع الـ tab-pane
                document.querySelectorAll(".tab-pane").forEach(function(element) {
                    element.classList.remove("active", "show");
                });

                // تفعيل التاب الجديد
                $(this).tab('show');

                // تحديد التاب المستهدف وإضافة الكلاسات
                let targetTab = $(this).attr("href"); // الحصول على الـ ID للتاب المستهدف
                $(targetTab).addClass("active show"); // إضافة الكلاسات إليه
            });
        });


        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                let text = this.previousElementSibling.innerText;
                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'تم النسخ!',
                        text: text,
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });
        });
    </script>
    @stop