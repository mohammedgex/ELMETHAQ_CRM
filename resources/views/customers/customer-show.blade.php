@extends('adminlte::page')

@section('title', 'عرض بيانات العميل')

@section('content_header')
    <h1 style="font-weight:bold; text-align:right;"> عرض بيانات العميل</h1>
    @if (
        $customer->medical_examination == 'لائق' &&
            $customer->virus_examination == 'سالب' &&
            $customer->finger_print_examination == 'تم تصدير الاكسيل' &&
            $customer->engaz_request == 'تم الحجز')
        <h6 style="text-align:right;color:#28a745"> * العميل مؤهل للقنصلية *</h6>
    @else
        <h6 style="text-align:right;color:red"> * العميل غير مؤهل للقنصلية *</h6>
    @endif
@stop

@section('content')
    <div class="card shadow-lg p-4 border-0 animate__animated animate__fadeIn"
        style="border-radius: 15px; background-color: #f8f9fa;">

        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item"><a class="nav-link active" style="color: #997a44;" data-bs-toggle="tab"
                    href="#personalInfo">التفاصيل الشخصية</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab"
                    href="#passportDetails">تفاصيل جواز السفر</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab"
                    href="#attachments">المرفقات</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab"
                    href="#payments">المدفوعات</a></li>
            <li class="nav-item"><a class="nav-link" style="color: #997a44;" data-bs-toggle="tab" href="#timelineTab">تقدم
                    العميل</a></li>
        </ul>

        <div class="tab-content mt-3">
            <div id="personalInfo" class="tab-pane fade show active">
                <h4> البيانات الاساسية </h4>

                <div class="section-container my-4">
                    <div class="section-container my-4" style="display: flex; justify-content: center;">
                        <div class="form-group" style="width: 150px;">
                            <label class="fw-bold d-block mb-2" style="color: #997a44;" for="passport_image">صورة
                                شخصية</label>
                            <div style="display: flex; justify-content: center;">
                                <div
                                    style="width: 150px; height: 150px; position: relative; border: 2px dashed #997a44; border-radius: 8px; overflow: hidden;">

                                    <!-- صورة المعاينة -->
                                    <img id="imagePreview" src="{{ asset('storage/' . $customer->image) }}"
                                        alt="معاينة الصورة"
                                        style="width: 100%; height: 100%; object-fit: cover; padding:4px; border-radius: 4px; position: absolute; top: 0; left: 0; z-index: 1;">
                                </div>
                            </div>
                            <div class="my-2">
                                <a href="{{ asset('storage/' . $customer->image) }}" download>
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-download"></i> تحميل
                                    </button>
                                </a>
                                <a href="{{ asset('storage/' . $customer->image) }}" target="_blank"
                                    rel="noopener noreferrer">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i> عرض
                                    </button>
                                </a>
                            </div>




                        </div>
                    </div>
                    <div class="row">
                        <!-- اسم العميل -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> اسم العميل </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->name_ar }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> الرقم القومي </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->card_id }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->phone }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> محافظة الاقامة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->governorate_live }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->age }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> تاريخ الميلاد </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->date_birth }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">
                                    {{ $customer->evaluation->title ?? '' }}
                                </p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> حالة العميل </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->status }}</p>
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
                            <label class="font-weight-bold"> رقم هاتف </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->phone }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> رقم هاتف اخر </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0"> {{ $customer->phone_two }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">
                                    {{ $customer->delegate->name ?? '' }}
                                </p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> المجموعة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">
                                    {{ $customer->customerGroup->title ?? '' }}
                                </p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">
                                    {{ $customer->visaType->outgoing_number ?? '' }}
                                </p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold"> الكفيل </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->sponser->name ?? '' }}
                                </p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold"> الوظيفة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">
                                    {{ $customer->jobTitle->title ?? '' }}
                                </p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->license_type }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4 my-3">
                            <label class="font-weight-bold"> تاريخ انتهاء الرخصة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->license_expire_date }}
                                </p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-4 my-3">
                            <label class="font-weight-bold"> حالة الرخصة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->license_status }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->license_type }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> رقم طلب التأشيرة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->e_visa_number }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->medical_examination }}
                                </p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> مرحلة البصمة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">
                                    {{ $customer->finger_print_examination }}
                                </p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->virus_examination }}
                                </p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-6 my-3">
                            <label class="font-weight-bold"> مرحلة التأشيرة </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->engaz_request }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->nationality }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- الوظيفة المقدم عليها -->
                        <div class="col-md-4 my-3">
                            <label class="font-weight-bold"> المؤهل الدراسي </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->education }}</p>
                                <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4 my-3">
                            <label class="font-weight-bold"> الحالة الاجتماعية </label>
                            <div class="input-group rounded">
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->marital_status }}</p>
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
                                <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->notes }}</p>
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
            <div class="section-container my-4" style="display: flex; justify-content: center;">
                <div class="form-group" style="width: 150px;">
                    <label class="fw-bold d-block mb-2" style="color: #997a44;" for="passport_image">صورة
                        الجواز</label>
                    <div style="display: flex; justify-content: center;">
                        <div
                            style="width: 150px; height: 150px; position: relative; border: 2px dashed #997a44; border-radius: 8px; overflow: hidden;">

                            <!-- صورة المعاينة -->
                            <img id="imagePreview" src="{{ asset('storage/' . $customer->mrz_image) }}"
                                alt="معاينة الصورة"
                                style="width: 100%; height: 100%; object-fit: cover; padding:4px; border-radius: 4px; position: absolute; top: 0; left: 0; z-index: 1;">
                        </div>
                    </div>

                    <div class="my-2">
                        <a href="{{ asset('storage/' . $customer->mrz_image) }}" download>
                            <button class="btn btn-success btn-sm">
                                <i class="fa-solid fa-download"></i> تحميل
                            </button>
                        </a>
                        <a href="{{ asset('storage/' . $customer->mrz_image) }}" target="_blank"
                            rel="noopener noreferrer">
                            <button class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-eye"></i> عرض
                            </button>
                        </a>
                    </div>

                </div>
            </div>
            <h4>بيانات جواز السفر</h4>
            <div class="row">
                <!-- اسم العميل -->
                <div class="col-md-12 my-3">
                    <label class="font-weight-bold"> MRZ </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->mrz }}</p>
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
                        <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->name_en_mrz }}</p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- الوظيفة المقدم عليها -->
                <div class="col-md-6 my-3">
                    <label class="font-weight-bold"> رقم جواز السفر </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->passport_id }}</p>
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
                        <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->date_birth }}</p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- الوظيفة المقدم عليها -->
                <div class="col-md-4 my-3">
                    <label class="font-weight-bold"> تاريخ انتهاء الصلاحية </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->passport_expire_date }}
                        </p>
                        <button class="btn btn-primary copy-btn" onclick="copyText()" title="نسخ">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-4 my-3">
                    <label class="font-weight-bold"> جهة الاصدار </label>
                    <div class="input-group rounded">
                        <p id="textToCopy" class="form-control border-0 m-0">{{ $customer->issue_place }} </p>
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
                @foreach ($customer->documentTypes as $file)
                    <tr>
                        <th>{{ $file->document_type }}</th>
                        <th><a href="{{ asset('storage/' . $file->file) }}" target="_blank"><img
                                    src="{{ asset('storage/' . $file->file) }}" alt=""
                                    style="width: 100px; height: auto; margin: 0 auto; display: block;"></a></th>
                        <th>
                            <span
                                class="badge 
                            @if ($file->status == 'موجود بالمكتب') bg-success 
                            @elseif ($file->status == 'لا يوجد بالمكتب') bg-warning text-dark @endif">
                                {{ $file->status }}
                            </span>
                        </th>
                        <th>{{ $file->note }}</th>
                        <th>
                            <a href="{{ asset('storage/' . $file->file) }}" download>
                                <button class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-download"></i> تحميل
                                </button>
                            </a>
                            <a href="{{ asset('storage/' . $file->file) }}" target="_blank" rel="noopener noreferrer">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </button>
                            </a>

                        </th>
                    </tr>
                @endforeach

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
                </tr>
            </thead>
            <tbody id="paymentTable">
                @foreach ($customer->payments as $payment)
                    <tr>
                        <th>{{ $payment->paymentTitle->title }}</th>
                        <th>{{ $payment->amount }} جنية</th>
                        <th>{{ $payment->amoun_rest }} جنية</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="timelineTab" class="tab-pane fade">
        <h2 class=" text-center"> تقدم العميل</h2>
        <ul class="timeline" id="timeline">
            @foreach ($customer->histories as $history)
                <li class="timeline-item">
                    <span class="timeline-icon step-1"></i></span>
                    <div class="timeline-content">
                        <div class="timeline-header row justify-content-between">
                            <span class="d-block text-start"><i class="fas fa-user" style="color: #997a44;"></i>
                                الموظف: <strong>{{ $history->user->name }}</strong></span>
                            <span class="timestamp"><i class="fas fa-calendar-alt" style="color: #997a44;"></i>
                                التاريخ:
                                <strong>{{ \Carbon\Carbon::parse($history->date)->format('Y-m-d H:i') }}
                                </strong></span>
                        </div>
                        <div class="row justify-content-between align-items-center d-flex">
                            <h3 class="bold mt-4 mb-0">{{ $history->description }}</h3>

                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>



    <!-- أزرار التحكم -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('customer.add', $customer->id) }}"
            class="btn btn-primary shadow-sm flex-grow-1 mx-2 text-center">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary shadow-sm flex-grow-1 mx-2 text-center">
            <i class="fas fa-arrow-left"></i> رجوع
        </a>
    </div>




@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
