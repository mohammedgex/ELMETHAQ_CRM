@extends('adminlte::page')

@section('title', 'إدارة بيانات العمال')

@section('content_header')
    @if ($edit)
        <h1> تعديل "{{ $edit->name_ar }}"</h1>
    @else
        <h1>اضافة بيانات عميل</h1>
    @endif
@stop

@section('content')
    <div class="card shadow-lg border-success">
        <div class="card-body">
            <ul class="nav nav-tabs nav-fill">
                <li class="nav-item">
                    <a class="nav-link {{ session('tap') === null || session('tap') === 'info' ? 'active' : '' }}"
                        style="color: #997a44;" data-toggle="tab" href="#personalInfo">التفاصيل الشخصية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ session('tap') == 'mrz' ? ' active' : '' }}" style="color: #997a44;"
                        data-toggle="tab" href="#passportDetails">تفاصيل جواز السفر</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ session('tap') == 'attach' ? ' active' : '' }}" style="color: #997a44;"
                        data-toggle="tab" href="#attachments">المرفقات</a>
                </li>
                <li class="nav-item "><a class="nav-link {{ session('tap') == 'payment' ? ' active' : '' }}"
                        style="color: #997a44;" data-toggle="tab" href="#payments">المدفوعات</a></li>
                <li class="nav-item"><a class="nav-link {{ session('tap') == 'history' ? 'active' : '' }}"
                        style="color: #997a44;" data-bs-toggle="tab" href="#timelineTab">تقدم العميل</a></li>
            </ul>


            <div class="tab-content mt-3">

                <div id="timelineTab" class="tab-pane fade {{ session('tap') == 'history' ? 'show active' : '' }}">
                    <h2 class=" text-center"> تاريخ العميل</h2>
                    <ul class="timeline" id="timeline">
                        @foreach ($histories as $history)
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
                                        <form action="{{ route('history.delete', $history->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><span
                                                    class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center"
                                                    style="width: 35px; height: 35px; cursor: pointer;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </span></button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-center">
                        <button class="btn btn-sm mt-3 text-white" style="background-color: #997a44;" id="addHistory"
                            data-bs-toggle="modal" data-bs-target="#stepModal">
                            إضافة جديد
                        </button>
                    </div>
                </div>



                @if ($edit == null)
                    <!-- التفاصيل الشخصية -->
                    <form id="personalInfo"
                        class="tab-pane fade {{ session('tap') === null || session('tap') === 'info' ? 'show active' : '' }}"
                        action="{{ route('customer.basicDetails') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="section-container">
                            <h4>الصورة الشخصية</h4>
                            <div class="col-md-12 d-flex align-items-center justify-content-center">
                                <div class="form-group">
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control fw-bold" name="image">
                                        <img id="imagePreview" src="" alt="معاينة"
                                            style="display: none; width: 200px; height: 150px; object-fit: cover; margin-right: 30px; border-radius: 6px; border: 2px solid #997a44;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- القسم: المعلومات الأساسية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">المعلومات الأساسية</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الاسم الكامل</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل الاسم الكامل"
                                        name="name_ar" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الرقم القومي</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل الرقم القومي"
                                        name="card_id" required>
                                </div>

                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">رقم الهاتف</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الهاتف"
                                        name="phone" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">محافظة الاقامة</label>
                                    @php
                                        $governorates = [
                                            'القاهرة',
                                            'الجيزة',
                                            'اسكندرية',
                                            'الدقهلية',
                                            'الشرقية',
                                            'القليوبية',
                                            'الغربية',
                                            'المنوفية',
                                            'البحيرة',
                                            'كفر الشيخ',
                                            'دمياط',
                                            'بورسعيد',
                                            'الإسماعيلية',
                                            'السويس',
                                            'الفيوم',
                                            'بني سويف',
                                            'المنيا',
                                            'أسيوط',
                                            'سوهاج',
                                            'قنا',
                                            'الأقصر',
                                            'أسوان',
                                            'مطروح',
                                            'البحر الأحمر',
                                            'الوادي الجديد',
                                            'شمال سيناء',
                                            'جنوب سيناء',
                                        ];
                                    @endphp
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="governorate_live">
                                        <option value="">اختر المحافظة</option>
                                        @foreach ($governorates as $governate)
                                            <option value="{{ $governate }}">{{ $governate }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                            <label class="fw-bold" style="color: #997a44;">السن</label>
                                                                                                                                                                                                                                                                                                                                                            <input type="text" class="form-control fw-bold"
                                                                                                                                                                                                                                                                                                                                                                style="height: 60px; border-color: #997a44;" placeholder="أدخل العمر"
                                                                                                                                                                                                                                                                                                                                                                name="age">
                                                                                                                                                                                                                                                                                                                                                        </div> -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> التقييم</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="evaluation_id">
                                        <option value="">اختر التقييم</option>
                                        @foreach ($evalutions as $evalution)
                                            <option value="{{ $evalution->id }}">{{ $evalution->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> الحالة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="status">
                                        <option value="">اختر الحالة</option>
                                        <option value="جديد">جديد</option>
                                        <option value="ناجح">ناجح</option>
                                        <option value="تجهيز الاوراق">تجهيز الاوراق</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">عدد سنوات الخبرة</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل عدد سنين الخبرة "
                                        name="experience_years">
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> الخبرة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="experience">
                                        <option value="">اختر الخبرات</option>
                                        <option value="جديد">جديد
                                        </option>
                                        <option value="قديم شركات">قديم شركات
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <!-- القسم: معلومات العمل -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات العمل</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">اختر المندوب</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="delegate_id">
                                        <option value="">اختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">اختر المجموعة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="customer_group_id">
                                        <option value="">اختر المجموعة</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label class="fw-bold" style="color: #997a44;">اختر الوظيفة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="job_title_id">
                                        <option value="">اختر الوظيفة</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}">{{ $job->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 my-2">
                                    <label class="fw-bold" style="color: #997a44;">اختر الكفيل</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="sponser_id">
                                        <option value=""> اختر الكفيل</option>
                                        @foreach ($sponsers as $sponser)
                                            <option value="{{ $sponser->id }}">{{ $sponser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- القسم: البيانات الشخصية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3"> بيانات الرخصة</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="fw-bold" style="color: #997a44;">نوع الرخصة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="license_type">
                                        <option value="">اختر الرخصة</option>
                                        <option value="درجة أولي">درجة أولي</option>
                                        <option value="درجة ثانية">درجة ثانية</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="fw-bold" style="color: #997a44;">تاريخ انتهاء</label>
                                    <input type="date" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الرخصة"
                                        name="license_expire_date">
                                </div>

                                <div class="col-md-4">
                                    <label class="fw-bold" style="color: #997a44;">حالة الرخصة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="license_status">
                                        <option value="">حالة الرخصة</option>
                                        <option value="سارية"> سارية</option>
                                        <option value="منتهية">منتهية </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- القسم: معلومات الاتصال -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات الاتصال</h4>
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">رقم هاتف آخر</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم هاتف آخر"
                                        name="phone_two">
                                </div>

                            </div>
                        </div>



                        <!-- القسم: بيانات التأشيرة -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات تأشيرة السفر</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> التأشيرة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="visa_type_id">
                                        <option value="">اختر التأشيرة</option>
                                        @foreach ($visas as $visa)
                                            <option value="{{ $visa->id }}">{{ $visa->outgoing_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">رقم طلب التأشيرة</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم التأشيرة"
                                        name="e_visa_number">
                                </div>
                            </div>
                        </div>

                        <!-- القسم: معلومات إضافية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات إضافية</h4>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الجنسية</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="nationality">
                                        <option value="">اختر الجنسية</option>
                                        <option value="مصري">مصري</option>
                                        <option value="غير ذلك">غير ذلك</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الحالة الاجتماعية</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="marital_status">
                                        <option value="">اختر الحالة الاجتماعية</option>
                                        <option value="أعزب">أعزب</option>
                                        <option value="متزوج">متزوج</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="fw-bold" style="color: #997a44;"> المؤهل الدراسي</label>
                                <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                    name="education">
                                    <option value="">اختر المؤهل</option>
                                    <option value="محو امية">محو امية</option>
                                    <option value="مؤهل متوسط">مؤهل متوسط</option>
                                </select>
                            </div>
                            <div class="col-md-12 my-2">
                                <label class="fw-bold" style="color: #997a44;"> ملاحظات</label>
                                <textarea class="form-control fw-bold" style="height: 100px; border-color: #997a44;" placeholder="ملاحظات هنا..."
                                    name="notes"></textarea>
                            </div>
                        </div>

                        <!-- المراحل -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3"> المراحل </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> الكشف الطبي </label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="medical_examination">
                                        <option value="">اختر المرحلة</option>
                                        <option value="في انتظار الحجز">في انتظار الحجز</option>
                                        <option value="تم الحجز">تم الحجز</option>
                                        <option value="لائق">لائق</option>
                                        <option value="غير لائق">غير لائق</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> البصمة </label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="finger_print_examination">
                                        <option value="">اختر المرحلة</option>
                                        <option value="في انتظار الحجز">في انتظار الحجز</option>
                                        <option value="تم تصدير الاكسيل"> تم تصدير الاكسيل </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> كشف المعامل </label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="virus_examination">
                                        <option value="">اختر المرحلة</option>
                                        <option value="بأنتظار ايصال المعامل"> بأنتظار ايصال المعامل </option>
                                        <option value="تم اصدار ايصال المعامل"> تم اصدار ايصال المعامل</option>
                                        <option value="سالب"> سالب </option>
                                        <option value="موجب"> موجب </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> حجز النت </label>
                                    <select name="engaz_request" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;">
                                        <option value="">اختر المرحلة</option>
                                        <option value="في انتظار الطلب">في انتظار الطلب </option>
                                        <option value="تم الحجز">تم الحجز </option>
                                        <option value="تم اصدار التأشيرة">تم اصدار التأشيرة </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <!-- زر الحفظ -->
                            <button type="submit" class="btn text-white fw-bold"
                                style="background-color: #997a44; width: 50%;">حفظ البيانات</button>

                            <!--------------------------------- تظهر فقط عند اضافة المستخدم او التعديل --------------------------------------->
                            <!-- زر الحذف -->
                            <button type="button" class="btn btn-danger fw-bold" style="width: 20%;">حذف</button>

                            <!-- زر الإضافة إلى قائمة الحظر -->
                            <button type="button" class="btn btn-warning fw-bold" style="width: 25%;">إضافة إلى قائمة
                                الحظر</button>
                        </div>
                    </form>
                @else
                    <div class="modal fade" id="stepModal" tabindex="-1" aria-labelledby="stepModalLabel"
                        aria-hidden="true">
                        <form action="{{ route('customer.history', $edit->id) }}" method="POST" class="modal-dialog">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="stepModalLabel">إضافة جديد</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="stepDescription" class="form-label">الوصف</label>
                                            <textarea name="description" required class="form-control" id="historyDescription" rows="5"
                                                placeholder="أدخل الوصف"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stepDate" class="form-label">التاريخ</label>
                                            <input name="date" required type="datetime-local" class="form-control"
                                                id="historyDate">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">إغلاق</button>
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form id="personalInfo"
                        class="tab-pane fade {{ session('tap') === null || session('tap') === 'info' ? 'show active' : '' }}"
                        action="{{ route('customer.editBasicDetails', $edit->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="section-container">
                            <h4>الصورة الشخصية</h4>
                            <div class="col-md-12 d-flex align-items-center justify-content-center">
                                <div class="form-group">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <input type="file" class="form-control fw-bold" name="image">
                                            <img src="{{ asset('storage/' . $edit->image) }}" alt="معاينة"
                                                style=" width: 200px; height: 150px; object-fit: cover; margin-right: 30px; border-radius: 6px; border: 2px solid #997a44;">
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <img src="{{ asset('storage/' . $edit->image) }}" alt=""
                                                style="max-width: 50%">
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- القسم: المعلومات الأساسية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">المعلومات الأساسية</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الاسم الكامل</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" value="{{ $edit->name_ar }}"
                                        placeholder="أدخل الاسم الكامل" name="name_ar" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الرقم القومي</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" value="{{ $edit->card_id }}"
                                        placeholder="أدخل الرقم القومي" name="card_id" required>
                                </div>

                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">رقم الهاتف</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الهاتف"
                                        name="phone" value="{{ $edit->phone }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">محافظة الاقامة</label>
                                    @php
                                        $governorates = [
                                            'القاهرة',
                                            'الجيزة',
                                            'اسكندرية',
                                            'الدقهلية',
                                            'الشرقية',
                                            'القليوبية',
                                            'الغربية',
                                            'المنوفية',
                                            'البحيرة',
                                            'كفر الشيخ',
                                            'دمياط',
                                            'بورسعيد',
                                            'الإسماعيلية',
                                            'السويس',
                                            'الفيوم',
                                            'بني سويف',
                                            'المنيا',
                                            'أسيوط',
                                            'سوهاج',
                                            'قنا',
                                            'الأقصر',
                                            'أسوان',
                                            'مطروح',
                                            'البحر الأحمر',
                                            'الوادي الجديد',
                                            'شمال سيناء',
                                            'جنوب سيناء',
                                        ];
                                    @endphp

                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="governorate_live">
                                        <option value="">اختر المحافظة</option>
                                        @foreach ($governorates as $gov)
                                            <option value="{{ $gov }}"
                                                {{ $edit->governorate_live == $gov ? 'selected' : '' }}>
                                                {{ $gov }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> التقييم</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="evaluation_id">
                                        <option value="">اختر التقييم</option>
                                        @foreach ($evalutions as $evalution)
                                            <option value="{{ $evalution->id }}"
                                                {{ old('evaluation_id', $edit->evaluation_id ?? '') == $evalution->id ? 'selected' : '' }}>
                                                {{ $evalution->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> الحالة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="status">
                                        <option value="">اختر الحالة</option>
                                        <option value="جديد"
                                            {{ old('status', $edit->status ?? '') == 'جديد' ? 'selected' : '' }}>جديد
                                        </option>
                                        <option value="ناجح"
                                            {{ old('status', $edit->status ?? '') == 'ناجح' ? 'selected' : '' }}>ناجح
                                        </option>
                                        <option value="تجهيز الاوراق"
                                            {{ old('status', $edit->status ?? '') == 'تجهيز الاوراق' ? 'selected' : '' }}>
                                            تجهيز الأوراق</option>
                                    </select>

                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">عدد سنوات الخبرة</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;"
                                        value="{{ $edit->experience_years }}" placeholder="أدخل عدد سنين الخبرة"
                                        name="experience_years">
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> الخبرة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="experience">
                                        <option value="">اختر الخبرات</option>
                                        <option value="جديد"
                                            {{ old('experience', $edit->experience ?? '') == 'جديد' ? 'selected' : '' }}>
                                            جديد</option>
                                        <option value="قديم شركات"
                                            {{ old('experience', $edit->experience ?? '') == 'قديم شركات' ? 'selected' : '' }}>
                                            قديم شركات</option>
                                    </select>


                                </div>

                            </div>

                        </div>

                        <!-- القسم: معلومات العمل -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات العمل</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">اختر المندوب</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="delegate_id">
                                        <option value="">اختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{ $delegate->id }}"
                                                {{ old('delegate_id', $edit->delegate_id ?? '') == $delegate->id ? 'selected' : '' }}>
                                                {{ $delegate->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">اختر المجموعة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="customer_group_id">
                                        <option value="">اختر المجموعة</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}"
                                                {{ old('customer_group_id', $edit->customer_group_id ?? '') == $group->id ? 'selected' : '' }}>
                                                {{ $group->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <label class="fw-bold" style="color: #997a44;">اختر الوظيفة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="job_title_id">
                                        <option value="">اختر الوظيفة</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ old('job_title_id', $edit->job_title_id ?? '') == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-6 my-2">
                                    <label class="fw-bold" style="color: #997a44;">اختر الكفيل</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="sponser_id">
                                        <option value="">اختر الكفيل</option>
                                        @foreach ($sponsers as $sponser)
                                            <option value="{{ $sponser->id }}"
                                                {{ old('sponser_id', $edit->sponser_id ?? '') == $sponser->id ? 'selected' : '' }}>
                                                {{ $sponser->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>

                        <!-- القسم: البيانات الشخصية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3"> بيانات الرخصة</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="fw-bold" style="color: #997a44;">نوع الرخصة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="license_type">
                                        <option value="">اختر الرخصة</option>
                                        <option value="درجة أولي"
                                            {{ old('license_type', $edit->license_type ?? '') == 'درجة أولي' ? 'selected' : '' }}>
                                            درجة أولي</option>
                                        <option value="درجة ثانية"
                                            {{ old('license_type', $edit->license_type ?? '') == 'درجة ثانية' ? 'selected' : '' }}>
                                            درجة ثانية</option>
                                    </select>

                                </div>

                                <div class="col-md-4">
                                    <label class="fw-bold" style="color: #997a44;">تاريخ انتهاء</label>
                                    <input type="date" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم الرخصة"
                                        name="license_expire_date" value="{{ $edit->license_expire_date }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="fw-bold" style="color: #997a44;">حالة الرخصة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="license_status">
                                        <option value="">حالة الرخصة</option>
                                        <option value="سارية"
                                            {{ old('license_status', $edit->license_status ?? '') == 'سارية' ? 'selected' : '' }}>
                                            سارية</option>
                                        <option value="منتهية"
                                            {{ old('license_status', $edit->license_status ?? '') == 'منتهية' ? 'selected' : '' }}>
                                            منتهية</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <!-- القسم: معلومات الاتصال -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات الاتصال</h4>
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">رقم هاتف آخر</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم هاتف آخر"
                                        name="phone_two" value="{{ $edit->phone_two }}">
                                </div>

                            </div>
                        </div>



                        <!-- القسم: بيانات التأشيرة -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات تأشيرة السفر</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> التأشيرة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="visa_type_id">
                                        <option value="">اختر التأشيرة</option>
                                        @foreach ($visas as $visa)
                                            <option value="{{ $visa->id }}"
                                                {{ old('visa_type_id', $edit->visa_type_id ?? '') == $visa->id ? 'selected' : '' }}>
                                                {{ $visa->outgoing_number }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">رقم طلب التأشيرة</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل رقم التأشيرة"
                                        name="e_visa_number" value="{{ $edit->e_visa_number }}">
                                </div>
                            </div>
                        </div>

                        <!-- القسم: معلومات إضافية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات إضافية</h4>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الجنسية</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="nationality">
                                        <option value="">اختر الجنسية</option>
                                        <option value="مصري"
                                            {{ old('nationality', $edit->nationality ?? '') == 'مصري' ? 'selected' : '' }}>
                                            مصري</option>
                                        <option value="غير ذلك"
                                            {{ old('nationality', $edit->nationality ?? '') == 'غير ذلك' ? 'selected' : '' }}>
                                            غير ذلك</option>
                                    </select>

                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">الحالة الاجتماعية</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="marital_status">
                                        <option value="">اختر الحالة الاجتماعية</option>
                                        <option value="أعزب"
                                            {{ old('marital_status', $edit->marital_status ?? '') == 'أعزب' ? 'selected' : '' }}>
                                            أعزب</option>
                                        <option value="متزوج"
                                            {{ old('marital_status', $edit->marital_status ?? '') == 'متزوج' ? 'selected' : '' }}>
                                            متزوج</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="fw-bold" style="color: #997a44;"> المؤهل الدراسي</label>
                                <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                    name="education">
                                    <option value="">اختر المؤهل</option>
                                    <option value="محو امية"
                                        {{ old('education', $edit->education ?? '') == 'محو امية' ? 'selected' : '' }}>محو
                                        امية</option>
                                    <option value="مؤهل متوسط"
                                        {{ old('education', $edit->education ?? '') == 'مؤهل متوسط' ? 'selected' : '' }}>
                                        مؤهل متوسط</option>
                                </select>

                            </div>
                            <div class="col-md-12 my-2">
                                <label class="fw-bold" style="color: #997a44;"> ملاحظات</label>
                                <textarea class="form-control fw-bold" style="height: 100px; border-color: #997a44;" placeholder="ملاحظات هنا..."
                                    name="notes">{{ $edit->notes }}</textarea>
                            </div>
                        </div>


                        <!-- المراحل -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3"> المراحل </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> الكشف الطبي </label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="medical_examination">
                                        <option value="">اختر المرحلة</option>
                                        <option value="في انتظار الحجز"
                                            {{ old('medical_examination', $edit->medical_examination ?? '') == 'في انتظار الحجز' ? 'selected' : '' }}>
                                            في انتظار الحجز</option>
                                        <option value="تم الحجز"
                                            {{ old('medical_examination', $edit->medical_examination ?? '') == 'تم الحجز' ? 'selected' : '' }}>
                                            تم الحجز</option>
                                        <option value="لائق"
                                            {{ old('medical_examination', $edit->medical_examination ?? '') == 'لائق' ? 'selected' : '' }}>
                                            لائق</option>
                                        <option value="غير لائق"
                                            {{ old('medical_examination', $edit->medical_examination ?? '') == 'غير لائق' ? 'selected' : '' }}>
                                            غير لائق</option>
                                    </select>

                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> البصمة </label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="finger_print_examination">
                                        <option value="">اختر المرحلة</option>
                                        <option value="في انتظار الحجز"
                                            {{ old('finger_print_examination', $edit->finger_print_examination ?? '') == 'في انتظار الحجز' ? 'selected' : '' }}>
                                            في انتظار الحجز</option>
                                        <option value="تم تصدير الاكسيل"
                                            {{ old('finger_print_examination', $edit->finger_print_examination ?? '') == 'تم تصدير الاكسيل' ? 'selected' : '' }}>
                                            تم تصدير الاكسيل</option>
                                    </select>

                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">كشف المعامل</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                        name="virus_examination">
                                        <option value="">اختر المرحلة</option>
                                        <option value="بأنتظار ايصال المعامل"
                                            {{ old('virus_examination', $edit->virus_examination ?? '') == 'بأنتظار ايصال المعامل' ? 'selected' : '' }}>
                                            بأنتظار ايصال المعامل</option>
                                        <option value="تم اصدار ايصال المعامل"
                                            {{ old('virus_examination', $edit->virus_examination ?? '') == 'تم اصدار ايصال المعامل' ? 'selected' : '' }}>
                                            تم اصدار ايصال المعامل</option>
                                        <option value="سالب"
                                            {{ old('virus_examination', $edit->virus_examination ?? '') == 'سالب' ? 'selected' : '' }}>
                                            سالب</option>
                                        <option value="موجب"
                                            {{ old('virus_examination', $edit->virus_examination ?? '') == 'موجب' ? 'selected' : '' }}>
                                            موجب</option>
                                    </select>

                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;"> حجز النت </label>
                                    <select name="engaz_request" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;">
                                        <option value="">اختر المرحلة</option>
                                        <option value="في انتظار الطلب"
                                            {{ old('engaz_request', $edit->engaz_request ?? '') == 'في انتظار الطلب' ? 'selected' : '' }}>
                                            في انتظار الطلب</option>
                                        <option value="تم الحجز"
                                            {{ old('engaz_request', $edit->engaz_request ?? '') == 'تم الحجز' ? 'selected' : '' }}>
                                            تم الحجز</option>
                                        <option value="تم اصدار التأشيرة"
                                            {{ old('engaz_request', $edit->engaz_request ?? '') == 'تم اصدار التأشيرة' ? 'selected' : '' }}>
                                            تم اصدار التأشيرة</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <!-- زر الحفظ -->
                            <button type="submit" class="btn text-white fw-bold"
                                style="background-color: #997a44; width: 50%;">حفظ البيانات</button>

                            <!--------------------------------- تظهر فقط عند اضافة المستخدم او التعديل --------------------------------------->
                            <!-- زر الحذف -->
                            <button type="button" class="btn btn-danger fw-bold" style="width: 20%;">حذف</button>

                            <!-- زر الإضافة إلى قائمة الحظر -->
                            <button type="button" class="btn btn-warning fw-bold" style="width: 25%;">إضافة إلى قائمة
                                الحظر</button>
                        </div>
                    </form>
                @endif

                @if ($edit != null)
                    <!----------------------------------------------------------------- تفاصيل جواز السفر ------------------------------------------------------------------------------------------------------------->
                    <div id="passportDetails" class="tab-pane fade  {{ session('tap') == 'mrz' ? 'show active' : '' }}">
                        <form action="{{ route('customer.mrz', $edit->id) }}" method="POST" class="table-wrapper"
                            enctype="multipart/form-data">
                            <!-- حقل MRZ -->
                            @csrf
                            <div class="d-flex align-items-start gap-4">
                                <!-- MRZ input + button -->
                                <div class="form-group flex-grow-1">
                                    <label class="fw-bold" style="color: #997a44;" for="mrz_input">أدخل بيانات
                                        MRZ</label>
                                    <textarea id="mrz_input" name="mrz" class="form-control fw-bold" style="border-color: #997a44; height: 110px;"
                                        rows="2" placeholder="ضع هنا منطقة القراءة الآلية من جواز السفر">{{ $edit->mrz }}</textarea>

                                    <button type="button" class="btn text-white fw-bold mt-2"
                                        style="background-color: #997a44;" onclick="extractMRZData()">
                                        استخراج البيانات
                                    </button>
                                </div>

                                <!-- الفاصل -->
                                <div style="width: 60px; background-color: #ccc; height: auto;"></div>

                                <!-- مربع رفع الصورة -->
                                <div class="form-group" style="width: 50%;">
                                    <label class="fw-bold d-block mb-2" style="color: #997a44;" for="passport_image">صورة
                                        الجواز</label>
                                    <div
                                        style="width: 100%; height: 150px; position: relative; border: 2px dashed #997a44; border-radius: 8px; overflow: hidden;">
                                        <input type="file" id="passport_image" name="mrz_image"
                                            onchange="previewImage(event)"
                                            style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;">
                                        <img id="imagePreview" src="{{ asset('storage/' . $edit->mrz_image) }}"
                                            alt="معاينة الصورة"
                                            style="width: 100%; height: 100%; object-fit: cover; position: absolute; z-index: 1;">
                                        <div id="uploadText"
                                            style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #997a44; font-size: 14px; position: absolute; z-index: 0;">
                                            اختيار صورة
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- ترتيب الحقول بحيث يكون كل 2 input جنبًا إلى جنب -->
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #997a44;" for="full_name">الاسم الكامل علي
                                            الجواز</label>
                                        <div class="input-group rounded">
                                            <input type="text" value="{{ $edit->name_en_mrz }}" id="full_name"
                                                name="name_en_mrz" class=" form-control fw-bold"
                                                style="height: 60px; border-color: #997a44;" readonly>
                                            <button class="btn btn-primary copy-btn ml-1" type="button"
                                                onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #997a44;" for="passport_number">رقم
                                            الجواز</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="passport_number" value="{{ $edit->passport_id }}"
                                                name="passport_id" class=" form-control fw-bold"
                                                style="height: 60px; border-color: #997a44;" readonly>
                                            <button class="btn btn-primary copy-btn ml-1" type="button"
                                                onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #997a44;" for="nationality">الجنسية</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="nationality" value="{{ $edit->nationality }}"
                                                name="nationality" class=" form-control fw-bold"
                                                style="height: 60px; border-color: #997a44;" readonly>
                                            <button class="btn btn-primary copy-btn ml-1" type="button"
                                                onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #997a44;" for="dob">تاريخ
                                            الميلاد</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="dob" name="date_birth"
                                                class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                                readonly
                                                value="{{ $edit->date_birth ? \Carbon\Carbon::parse($edit->date_birth)->format('d/m/Y') : '' }}">
                                            <button class="btn btn-primary copy-btn ml-1" type="button"
                                                onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #997a44;" for="expiry_date">تاريخ انتهاء
                                            الصلاحية</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="expiry_date" name="passport_expire_date"
                                                class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                                readonly
                                                value="{{ $edit->passport_expire_date ? \Carbon\Carbon::parse($edit->passport_expire_date)->format('d/m/Y') : '' }}">
                                            <button class="btn btn-primary copy-btn ml-1" type="button"
                                                onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #997a44;" for="gender">النوع</label>
                                        <div class="input-group rounded">
                                            <input type="text" name="gender" value="{{ $edit->gender }}"
                                                id="gender" class=" form-control fw-bold"
                                                style="height: 60px; border-color: #997a44;" readonly>
                                            <button class="btn btn-primary copy-btn ml-1" type="button"
                                                onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">السن</label>
                                    <div class="input-group rounded">
                                        <input type="text" id="age" value="{{ $edit->age }}"
                                            class="form-control fw-bold" style="height: 60px; border-color: #997a44;"
                                            name="age" readonly>
                                        <button class="btn btn-primary copy-btn ml-1" type="button" onclick="copyText()"
                                            title="نسخ">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #997a44;">جهة الاصدار</label>
                                    <div class="input-group rounded">
                                        <input type="text" class="form-control fw-bold"
                                            style="height: 60px; border-color: #997a44;" name="issue_place"
                                            value="{{ $edit->issue_place }}" id="eg_code" readonly>
                                        <button class="btn btn-primary copy-btn ml-1" type="button" onclick="copyText()"
                                            title="نسخ">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <!-- زر الحفظ -->
                                <button type="submit" class="btn text-white fw-bold"
                                    style="background-color: #997a44; width: 50%;">حفظ البيانات</button>

                                <!--------------------------------- تظهر فقط عند اضافة المستخدم او التعديل --------------------------------------->
                                <!-- زر الحذف -->
                                <button type="button" class="btn btn-danger fw-bold" style="width: 20%;">حذف</button>

                                <!-- زر الإضافة إلى قائمة الحظر -->
                                <button type="button" class="btn btn-warning fw-bold" style="width: 25%;">إضافة إلى
                                    قائمة
                                    الحظر</button>
                            </div>
                        </form>
                    </div>

                    <!-- المرفقات -->
                    <form action="{{ route('customer.attachments', $edit->id) }}" method="POST"
                        enctype="multipart/form-data" id="attachments"
                        class="tab-pane fade {{ session('tap') == 'attach' ? 'show active' : '' }}">
                        <h4>إضافة مرفقات</h4>
                        @csrf
                        <div class="row">
                            <!-- حقل عنوان المرفق -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold" style="color: #997a44;">عنوان المرفق</label>
                                    <select id="attachmentTitle" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" name="document_type" required>
                                        <option value="">اختر نوع المستند</option>
                                        @foreach ($fileTitles as $fileTitle)
                                            <option value="{{ $fileTitle->title }}">{{ $fileTitle->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- حقل رفع المرفق -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold" style="color: #997a44;">رفع المرفق</label>
                                    <input type="file" class="form-control fw-bold" name="file"
                                        style="border-color: #997a44; height: 60px;" id="attachmentFile">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold" style="color: #997a44;">حالة المرفق</label>
                                    <select id="attachmentTitle" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" name="status" required>
                                        <option value="">اختر حالة المرفق</option>
                                        <option value="لا يوجد بالمكتب"> لا يوجد بالمكتب </option>
                                        <option value="موجود بالمكتب">موجود بالمكتب</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold" style="color: #997a44;">الحالة علي التطبيق </label>
                                    <select id="attachmentTitle" class="form-control fw-bold"
                                        style="height: 60px; border-color: #997a44;" name="required" required>
                                        <option selected value="true">اجباري</option>
                                        <option value="false">اختياري</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold" style="color: #997a44;">ملحوظة </label>
                                    <input type="text" class="form-control fw-bold" name="note"
                                        style="border-color: #997a44; height: 60px;" id="attachmentFile">
                                </div>
                            </div>
                        </div>

                        <!-- زر إضافة مرفق -->
                        <button type="submit" class="btn text-white fw-bold mt-2" style="background-color: #997a44;"
                            id="addAttachment">إضافة مرفق</button>

                        <!-- جدول المرفقات -->
                        <table class="table table-bordered mt-3">
                            <thead style="background-color: #997a44; color: white;">
                                <tr>
                                    <th>عنوان المرفق</th>
                                    <th>المرفق</th>
                                    <th>حالة المرفق</th>
                                    <th>الحالة علي التطبيق</th>
                                    <th>ملحوظة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="attachmentTable">
                                <!-- بيانات المرفقات ستتم إضافتها هنا -->
                                @foreach ($files as $file)
                                    <tr>
                                        <th class="text-success">{{ $file->document_type }}</th>
                                        <th><a href="{{ asset('storage/' . $file->file) }}" target="_blank"><img
                                                    src="{{ asset('storage/' . $file->file) }}" alt=""
                                                    style="width: 100px; height: auto; margin: 0 auto; display: block;"></a>
                                        </th>
                                        <th>
                                            <span
                                                class="badge 
                            @if ($file->status == 'موجود بالمكتب') bg-success 
                            @elseif ($file->status == 'لا يوجد بالمكتب') bg-warning text-dark 
                            @else bg-secondary @endif">
                                                {{ $file->status }}
                                            </span>
                                        </th>
                                        <th>{{ $file->required ? 'اجباري' : 'اختياري' }}</th>
                                        <th>{{ $file->note }}</th>
                                        <td>
                                            @if ($file->order_status == 'panding')
                                                <a href="{{ route('document-type.accept', $file->id) }}">
                                                    <button class="btn btn-success btn-sm" type="button">
                                                        موافقة
                                                    </button>
                                                </a>
                                                <a href="{{ route('document-type.reject', $file->id) }}">
                                                    <button class="btn btn-danger btn-sm" type="button">
                                                        رفض
                                                    </button>
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/' . $file->file) }}" download>
                                                    <button class="btn btn-success btn-sm" type="button">
                                                        <i class="fa-solid fa-download"></i> تحميل
                                                    </button>
                                                </a>
                                                <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <button class="btn btn-primary btn-sm" type="button">
                                                        <i class="fa-solid fa-eye"></i> عرض
                                                    </button>
                                                </a>
                                                {{-- <button class="btn btn-warning btn-sm" type="button">
                                                    <i class="fa-solid fa-pen"></i> تعديل
                                                </button> --}}
                                                <a href="{{ route('attachments.delete', $file->id) }}"><button
                                                        class="btn btn-danger btn-sm" type="button">
                                                        <i class="fa-solid fa-trash"></i> حذف
                                                    </button></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>

                    <!-- المدفوعات -->
                    <form action="{{ route('customer.payments', $edit->id) }}" method="POST" id="payments"
                        class="tab-pane fade {{ session('tap') == 'payment' ? 'show active' : '' }}">
                        @csrf
                        <h4>إضافة مدفوعات</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <label style="color: #997a44;">عنوان الدفع</label>
                                <select id="paymentTitle" class="form-control fw-bold"
                                    style="height: 60px; border-color: #997a44;" required name="payment_title_id">
                                    <option value="">اختر نوع المعاملة</option>
                                    @foreach ($paymentTitles as $paymentTitle)
                                        <option value="{{ $paymentTitle->id }}">{{ $paymentTitle->title }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="color: #997a44;">قيمة الدفع</label>
                                <input type="number" required name="amount" class="form-control "
                                    style="border-color: #997a44; height: 60px;" id="paymentAmount"
                                    placeholder="أدخل القيمة">
                            </div>
                            <div class="col-md-6">
                                <label style="color: #997a44;"> المتبقي</label>
                                <input type="number" name="amoun_rest" class="form-control "
                                    style="border-color: #997a44; height: 60px;" id="paymentAmount" value="0"
                                    placeholder="أدخل المتبقي">
                            </div>
                        </div>

                        <button type="submit" class="btn text-white fw-bold mt-2" style="background-color: #997a44;"
                            id="addPayment">إضافة دفعة</button>


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
                                @foreach ($payments as $payment)
                                    <tr>
                                        <th class="text-success">{{ $payment->paymentTitle->title }}</th>
                                        <th>{{ $payment->amount }} جنية</th>
                                        <th>{{ $payment->amoun_rest }} جنية</th>
                                        <td>
                                            <button class="btn btn-warning btn-sm">
                                                <i class="fa-solid fa-pen"></i> تعديل
                                            </button>
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash"></i> حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                @endif

                <div id="timelineTab" class="tab-pane fade">
                    <h5 class="text-success">مخطط التقدم</h5>
                    <ul class="timeline" id="timeline">
                        <li class="timeline-item">
                            <span class="timeline-icon bg-success"></span>
                            <div class="timeline-content">
                                <h6>الخطوة الأولى</h6>
                                <p>تم تسجيل البيانات الأساسية</p>
                            </div>
                        </li>
                    </ul>
                    <button class="btn btn-success btn-sm mt-3" id="addStep">إضافة خطوة جديدة</button>
                </div>
            </div>

            <!-- <button class="btn btn-success btn-block mt-3">حفظ البيانات</button> -->
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
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
        .section-container {
            background: #f8f9fa;
            /* لون فاتح */
            padding: 20px;
            border-radius: 10px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
            margin-bottom: 20px;
            /* تباعد بين الأقسام */
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        document.getElementById('addStep').addEventListener('click', function() {
            const timeline = document.getElementById('timeline');
            const stepNumber = timeline.children.length + 1;
            const icons = ['fa-passport', 'fa-plane', 'fa-file-alt', 'fa-times-circle'];
            const texts = ['تم تقديم الطلب', 'تمت الموافقة على الطلب', 'تم إصدار التأشيرة', 'تم رفض الطلب'];
            const colors = ['step-1', 'step-2', 'step-3', 'step-4'];

            const newStep = document.createElement('li');
            newStep.classList.add('timeline-item');
            newStep.innerHTML = `
            <span class="timeline-icon ${colors[stepNumber % 4]}"><i class="fas ${icons[stepNumber % 4]}"></i></span>
            <div class="timeline-content">
                <h4> تم اصدار تأشيرة السفر</h4>
                <p>${texts[stepNumber % 4]}</p>
            </div>
        `;
            timeline.appendChild(newStep);
        });

        $(document).ready(function() {
            $('.nav-tabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

        });

        //استخراج بيانات جواز السفر
        function extractMRZData() {
            let mrz = document.getElementById("mrz_input").value;
            let lines = mrz.split("\n");
            if (lines.length < 2) {
                alert("يرجى إدخال MRZ صالح");
                return;
            }

            let passportNumber = lines[1].substring(0, 9).replace(/</g, ""); // رقم الجواز
            let nationality = lines[1].substring(10, 13).replace(/</g, ""); // الجنسية

            // استخراج تاريخ الميلاد
            let rawBirthDate = lines[1].substring(13, 19).replace(/</g, ""); // YYMMDD
            let birthYear = parseInt(rawBirthDate.substring(0, 2), 10);
            birthYear = birthYear >= 50 ? 1900 + birthYear : 2000 + birthYear;
            let birthMonth = rawBirthDate.substring(2, 4);
            let birthDay = rawBirthDate.substring(4, 6);
            let birthDate = `${birthDay}/${birthMonth}/${birthYear}`;

            // استخراج النوع (M/F)
            let genderChar = lines[1].charAt(20);
            let gender = genderChar === "M" ? "ذكر" : genderChar === "F" ? "انثي" : "غير معروف";

            // حساب العمر
            let today = new Date();
            let age = today.getFullYear() - birthYear;
            if (
                today.getMonth() + 1 < parseInt(birthMonth) ||
                (today.getMonth() + 1 === parseInt(birthMonth) && today.getDate() < parseInt(birthDay))
            ) {
                age--; // تقليل العمر إذا لم يصل الشخص إلى عيد ميلاده بعد هذا العام
            }

            // استخراج تاريخ انتهاء الصلاحية
            let rawExpiryDate = lines[1].substring(21, 27).replace(/</g, ""); // YYMMDD
            let expiryYear = 2000 + parseInt(rawExpiryDate.substring(0, 2), 10);
            let expiryMonth = rawExpiryDate.substring(2, 4);
            let expiryDay = rawExpiryDate.substring(4, 6);
            let expiryDate = `${expiryDay}/${expiryMonth}/${expiryYear}`;

            // استخراج الاسم
            let nameParts = lines[0].substring(5).split("<<");
            let surname = nameParts[0].replace(/</g, " ");
            let givenNames = nameParts[1].replace(/</g, " ");
            let fullName = givenNames + " " + surname;

            // استخراج كود الدولة من آخر رقم في MRZ
            let countryCode = lines[1].slice(-1); // آخر رقم في السطر الثاني من MRZ

            // تعبئة الحقول
            document.getElementById("passport_number").value = passportNumber;
            document.getElementById("full_name").value = fullName;
            document.getElementById("nationality").value = "مصري";
            document.getElementById("dob").value = birthDate;
            document.getElementById("expiry_date").value = expiryDate;
            document.getElementById("age").value = age;
            document.getElementById("eg_code").value = countryCode;
            document.getElementById("gender").value = gender;
            console.log("Birth Date:", birthDate);
            console.log("Gender:", gender);
            console.log("Age:", age);
            console.log("Issue Place:", countryCode);


        }

        // عرض الصورة بعد رفعها
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            const image = document.getElementById('imagePreview');
            const uploadText = document.getElementById('uploadText');

            reader.onload = function() {
                image.src = reader.result;
                image.style.display = 'block';
                uploadText.style.display = 'none';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

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

        // التاريخ والوقت الحالي
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("stepModal").addEventListener("show.bs.modal", function() {
                let now = new Date();
                let year = now.getFullYear();
                let month = String(now.getMonth() + 1).padStart(2, '0');
                let day = String(now.getDate()).padStart(2, '0');
                let hours = String(now.getHours()).padStart(2, '0');
                let minutes = String(now.getMinutes()).padStart(2, '0');

                let currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                document.getElementById("historyDate").value = currentDateTime;
            });
        });

        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            const image = document.getElementById('imagePreview');
            const uploadText = document.getElementById('uploadText');

            reader.onload = function() {
                image.src = reader.result;
                image.style.display = 'block';
                uploadText.style.display = 'none';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop
