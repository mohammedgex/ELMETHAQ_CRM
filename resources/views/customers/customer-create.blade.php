@extends('adminlte::page')

@section('title', 'إدارة بيانات العمال')

@section('content_header')
    @if ($edit)
        <div class="row justify-content-between px-4">
            <h1> تعديل "{{ $edit->name_ar }}"</h1>
            <h4>(F4 للرجوع)</h4>
        </div>
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
                        style="color: #343a40;" data-toggle="tab" href="#personalInfo">التفاصيل الشخصية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ session('tap') == 'mrz' ? ' active' : '' }}" style="color: #343a40;"
                        data-toggle="tab" href="#passportDetails">تفاصيل جواز السفر</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ session('tap') == 'attach' ? ' active' : '' }}" style="color: #343a40;"
                        data-toggle="tab" href="#attachments">المرفقات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ session('tap') == 'payment' ? ' active' : '' }}" style="color: #343a40;"
                        data-toggle="tab" href="#payments">المدفوعات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ session('tap') == 'history' ? 'active' : '' }}" style="color: #343a40;"
                        data-bs-toggle="tab" href="#timelineTab">تقدم العميل</a>
                </li>
            </ul>



            <div class="tab-content mt-3">

                <div id="timelineTab" class="tab-pane fade {{ session('tap') == 'history' ? 'show active' : '' }}">
                    <!-- Timeline Container -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-dark text-white">
                            <h4 class="card-title mb-0">تاريخ العميل</h4>
                        </div>
                        <div class="card-body">
                            <ul class="timeline">
                                @foreach ($histories as $history)
                                    <li class="timeline-item">
                                        <span class="timeline-icon bg-dark"><i class="fas fa-user"></i></span>
                                        <div class="timeline-content p-3 bg-light rounded shadow-sm">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><i class="fas fa-user text-primary"></i> الموظف:
                                                    <strong>{{ $history->user->name }}</strong></span>
                                                <span><i class="fas fa-calendar-alt text-primary"></i>
                                                    {{ \Carbon\Carbon::parse($history->date)->format('Y-m-d H:i') }}</span>
                                            </div>
                                            <p class="mb-0">{{ $history->description }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-center mt-3">
                                <button class="btn btn-success" id="addHistory" data-bs-toggle="modal"
                                    data-bs-target="#stepModal">
                                    <i class="fas fa-plus"></i> إضافة جديد
                                </button>
                            </div>
                        </div>
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
                                        <img id="imagePreviewl" src="" alt="معاينة"
                                            style=" width: 200px; height: 150px; object-fit: cover; margin-right: 30px; border-radius: 6px; border: 2px solid #997a44;">
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
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold mb-2" style="color: #997a44;">الرقم القومي</label>
                                    <input type="text"
                                        class="form-control fw-bold @error('card_id') is-invalid @enderror"
                                        style="height: 60px; border-color: #997a44;" placeholder="أدخل الرقم القومي"
                                        name="card_id" value="{{ old('card_id') }}" required>
                                    @error('card_id')
                                        <div class="invalid-feedback d-block mt-1" style="color: #dc3545;">
                                            الرقم القومي موجود من قبل
                                        </div>
                                    @enderror
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
                                        <option value="unmarried">أعزب</option>
                                        <option value="married">متزوج</option>
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
                                style="background-color: #997a44; width: 50%;">حفظ البيانات (F1)</button>
                        </div>
                    </form>
                @else
                    <div class="modal fade" id="stepModal" tabindex="-1" aria-labelledby="stepModalLabel"
                        aria-hidden="true">
                        <form action="{{ route('customer.history', $edit->id) }}" method="POST"
                            class="modal-dialog modal-lg">
                            @csrf
                            <div class="modal-content shadow-lg">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title fw-bold" id="stepModalLabel">
                                        <i class="fas fa-plus-circle me-2"></i> إضافة جديد
                                    </h5>
                                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body bg-light">
                                    <div class="mb-3">
                                        <label for="historyDescription" class="form-label fw-bold text-dark">الوصف</label>
                                        <textarea name="description" required class="form-control border-dark shadow-sm" id="historyDescription"
                                            rows="5" placeholder="أدخل الوصف" style="resize: none;"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="historyDate" class="form-label fw-bold text-dark">التاريخ</label>
                                        <input name="date" required type="datetime-local"
                                            class="form-control border-dark shadow-sm" id="historyDate">
                                    </div>
                                </div>
                                <div class="modal-footer bg-white">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times-circle me-1"></i> إغلاق
                                    </button>
                                    <button type="submit" class="btn text-white fw-bold"
                                        style="background-color: #28a745;">
                                        <i class="fas fa-save me-1"></i> حفظ
                                    </button>
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
                            <div class="row">
                                <!-- الصورة الشخصية -->
                                <div class="col-md-6">
                                    <div class="form-group p-3 bg-white rounded border shadow-sm">
                                        <label for="imageInput" class="form-label fw-bold">الصورة الشخصية</label>

                                        <div class="custom-file mb-3">
                                            <input type="file" name="image" class="custom-file-input"
                                                id="imageInput" data-preview="#personal_preview" accept="image/*">
                                            <label class="custom-file-label" for="imageInput">اختر صورة</label>
                                        </div>

                                        <div id="" class="border rounded p-2 text-center bg-light"
                                            style="min-height: 130px;">
                                            <img id="imagePreview"
                                                src="{{ $edit->image ? asset('storage/' . $edit->image) : 'https://via.placeholder.com/100x100?text=No+Image' }}"
                                                class="img-thumbnail"
                                                style="max-width: 100px; {{ $edit->image ? '' : 'display: none;' }}"
                                                alt="Preview">
                                        </div>
                                    </div>
                                </div>

                                <!-- صورة جواز السفر -->
                                <div class="col-md-6">
                                    <div class="form-group p-3 bg-white rounded border shadow-sm">
                                        <label for="passportInput" class="form-label fw-bold">صورة جواز السفر</label>
                                        {{-- 
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input" accept="image/*">
                                            <label class="custom-file-label" for="passportInput">اختر صورة</label>
                                        </div> --}}

                                        <div class="border rounded p-2 text-center bg-light" style="min-height: 130px;">
                                            @if ($edit->mrz_image)
                                                <img src="{{ $edit->mrz_image ? asset('storage/' . $edit->mrz_image) : 'https://via.placeholder.com/100x100?text=No+Image' }}"
                                                    class="img-thumbnail"
                                                    style="max-width: 100px; {{ $edit->mrz_image ? '' : 'display: none;' }}"
                                                    alt="Preview">
                                            @else
                                                <span>لا توجد صورة جواز سفر</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- القسم: المعلومات الأساسية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">المعلومات الأساسية</h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">الاسم الكامل *</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;" value="{{ $edit->name_ar }}"
                                        placeholder="أدخل الاسم الكامل" name="name_ar" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold mb-2" style="color: #343a40;">* الرقم القومي</label>
                                    <input type="text"
                                        class="form-control fw-bold @error('card_id') is-invalid @enderror"
                                        style="height: 60px; border-color: #343a40;" placeholder="أدخل الرقم القومي"
                                        name="card_id" value="{{ old('card_id', $edit->card_id) }}" required>
                                    @error('card_id')
                                        <div class="invalid-feedback d-block mt-1" style="color: #dc3545;">
                                            الرقم القومي موجود من قبل
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">رقم الهاتف *</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;" placeholder="أدخل رقم الهاتف"
                                        name="phone" value="{{ $edit->phone }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">رقم هاتف آخر</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;" placeholder="أدخل رقم هاتف آخر"
                                        name="phone_two" value="{{ $edit->phone_two }}">
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">رقم التاشيرة</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;" name="visa_number"
                                        value="{{ $edit->visa_number }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">رقم طلب التاشيرة</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;" name="e_visa_number"
                                        value="{{ $edit->e_visa_number }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">الحالة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">محافظة الاقامة</label>
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

                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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
                        </div>

                        <!-- القسم: معلومات العمل -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات العمل</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">اختر المندوب</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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
                                    <label class="fw-bold" style="color: #343a40;">اختر المجموعة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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
                                    <label class="fw-bold" style="color: #343a40;">اختر الوظيفة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">عدد سنوات الخبرة</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;"
                                        value="{{ $edit->experience_years }}" placeholder="أدخل عدد سنين الخبرة"
                                        name="experience_years">
                                </div>
                                <div class="col-md-12">
                                    <label class="fw-bold" style="color: #343a40;">عنوان المستشفي</label>
                                    <input type="text" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;"
                                        value="{{ $edit->hospital_address }}" name="hospital_address">
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">الخبرة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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

                        <!-- القسم: معلومات إضافية -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">معلومات إضافية</h4>
                            <div class="row my-2">

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">الحالة الاجتماعية</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
                                        name="marital_status">
                                        <option value="">اختر الحالة الاجتماعية</option>
                                        <option value="unmarried"
                                            {{ old('marital_status', $edit->marital_status ?? '') == 'unmarried' ? 'selected' : '' }}>
                                            أعزب</option>
                                        <option value="married"
                                            {{ old('marital_status', $edit->marital_status ?? '') == 'married' ? 'selected' : '' }}>
                                            متزوج</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">المؤهل الدراسي</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
                                        name="education">
                                        <option value="">اختر المؤهل</option>
                                        <option value="محو امية"
                                            {{ old('education', $edit->education ?? '') == 'محو امية' ? 'selected' : '' }}>
                                            محو
                                            امية</option>
                                        <option value="مؤهل متوسط"
                                            {{ old('education', $edit->education ?? '') == 'مؤهل متوسط' ? 'selected' : '' }}>
                                            مؤهل متوسط</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 my-2">
                                <label class="fw-bold" style="color: #343a40;">ملاحظات</label>
                                <textarea class="form-control fw-bold" style="height: 100px; border-color: #343a40;" placeholder="ملاحظات هنا..."
                                    name="notes">{{ $edit->notes }}</textarea>
                            </div>
                        </div>

                        <!-- المراحل -->
                        <div class="section-container">
                            <h4 class="fw-bold mb-3">المراحل</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">الكشف الطبي</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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
                                    <label class="fw-bold" style="color: #343a40;">البصمة</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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
                                    <label class="fw-bold" style="color: #343a40;">كشف المعامل</label>
                                    <select class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
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
                                    <label class="fw-bold" style="color: #343a40;">حجز النت</label>
                                    <select name="engaz_request" class="form-control fw-bold"
                                        style="height: 60px; border-color: #343a40;">
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
                            <button type="submit" class="btn text-white fw-bold w-100" id="saveData"
                                style="background-color: #28a745; width: 50%;">حفظ البيانات (F2)</button>
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
                            <input type="hidden" id="name_ar" name="name_ar" value="">
                            <div class="d-flex align-items-start gap-4">
                                <!-- MRZ input + button -->
                                <div class="form-group flex-grow-1">
                                    <label class="fw-bold" style="color: #997a44;" for="mrz_input">أدخل بيانات
                                        MRZ</label>
                                    <textarea id="mrz_input" name="mrz" class="form-control fw-bold" style="border-color: #997a44; height: 110px;"
                                        rows="2" placeholder="ضع هنا منطقة القراءة الآلية من جواز السفر">{{ $edit->mrz }}</textarea>
                                </div>

                                <!-- الفاصل -->
                                <div style="width: 60px; background-color: #ccc; height: auto;"></div>

                                <!-- مربع رفع الصورة -->
                                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm"
                                    style="width: 50%; margin: auto;">
                                    <label for="passportInput" class="fw-bold d-block mb-2" style="color: #343a40;">صورة
                                        جواز السفر</label>

                                    <div class="custom-file mb-2">
                                        <input type="file" name="mrz_image"
                                            class="custom-file-input preview-image-input" id="passportInput"
                                            data-preview="#preview_passport_photo">
                                        <label class="custom-file-label">اختر صورة</label>
                                    </div>

                                    <div id="preview_passport_photo" class="border rounded p-2 text-center bg-light"
                                        style="min-height: 130px;">
                                        <img id="imagePreviewpass" src="{{ asset('storage/' . $edit->mrz_image) }}"
                                            class="img-thumbnail"
                                            style="max-width: 100px; {{ $edit->mrz_image ? '' : 'display: none;' }}"
                                            alt="Preview">
                                    </div>

                                    <div class="mt-3 d-flex align-items-center gap-3 flex-wrap justify-content-between">
                                        <button type="button" id="analyzeBtn"
                                            style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                            فك البيانات
                                        </button>

                                        <div class="d-flex align-items-center">
                                            <div id="gggg" class="loader mr-1"
                                                style="display: none; border: 4px solid #f3f3f3; border-top: 4px solid #007bff; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite;">
                                            </div>

                                            <div id="hhhh" class="loading-text mr-1"
                                                style="display: none; font-size: 14px; color: #007bff;">
                                                الرجاء الانتظار...
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <style>
                                    @keyframes spin {
                                        0% {
                                            transform: rotate(0deg);
                                        }

                                        100% {
                                            transform: rotate(360deg);
                                        }
                                    }
                                </style>

                            </div>



                            <!-- ترتيب الحقول بحيث يكون كل 2 input جنبًا إلى جنب -->
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #343a40;" for="full_name">الاسم الكامل علي
                                            الجواز</label>
                                        <div class="input-group rounded">
                                            <input type="text" value="{{ $edit->name_en_mrz }}" id="full_name"
                                                name="name_en_mrz" class="form-control fw-bold"
                                                style="height: 60px; border-color: #343a40;" readonly>
                                            <button class="btn" style="background-color: #343a40; color: white;"
                                                type="button" onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #343a40;" for="passport_number">رقم
                                            الجواز</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="passport_number" value="{{ $edit->passport_id }}"
                                                name="passport_id" class="form-control fw-bold"
                                                style="height: 60px; border-color: #343a40;" readonly>
                                            <button class="btn" style="background-color: #343a40; color: white;"
                                                type="button" onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #343a40;" for="nationality">الجنسية</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="nationality" value="{{ $edit->nationality }}"
                                                name="nationality" class="form-control fw-bold"
                                                style="height: 60px; border-color: #343a40;" readonly>
                                            <button class="btn" style="background-color: #343a40; color: white;"
                                                type="button" onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #343a40;" for="dob">تاريخ
                                            الميلاد</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="dob" name="date_birth"
                                                class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
                                                readonly
                                                value="{{ $edit->date_birth ? \Carbon\Carbon::parse($edit->date_birth)->format('d/m/Y') : '' }}">
                                            <button class="btn" style="background-color: #343a40; color: white;"
                                                type="button" onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #343a40;" for="expiry_date">تاريخ انتهاء
                                            الصلاحية</label>
                                        <div class="input-group rounded">
                                            <input type="text" id="expiry_date" name="passport_expire_date"
                                                class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
                                                readonly
                                                value="{{ $edit->passport_expire_date ? \Carbon\Carbon::parse($edit->passport_expire_date)->format('d/m/Y') : '' }}">
                                            <button class="btn" style="background-color: #343a40; color: white;"
                                                type="button" onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #343a40;" for="gender">النوع</label>
                                        <div class="input-group rounded">
                                            <input type="text" name="gender" value="{{ $edit->gender }}"
                                                id="gender" class="form-control fw-bold"
                                                style="height: 60px; border-color: #343a40;" readonly>
                                            <button class="btn" style="background-color: #343a40; color: white;"
                                                type="button" onclick="copyText()" title="نسخ">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">السن</label>
                                    <div class="input-group rounded">
                                        <input type="text" id="age" value="{{ $edit->age }}"
                                            class="form-control fw-bold" style="height: 60px; border-color: #343a40;"
                                            name="age" readonly>
                                        <button class="btn" style="background-color: #343a40; color: white;"
                                            type="button" onclick="copyText()" title="نسخ">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold" style="color: #343a40;">جهة الاصدار</label>
                                    <div class="input-group rounded">
                                        <input type="text" class="form-control fw-bold"
                                            style="height: 60px; border-color: #343a40;" id="issue_place"
                                            name="issue_place" value="{{ $edit->issue_place }}" readonly>
                                        <button class="btn" style="background-color: #343a40; color: white;"
                                            type="button" onclick="copyText()" title="نسخ">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="card_id" name="card_id" value="">
                            <input type="hidden" id="date_of_issue" name="passport_issuance_date" value="">
                            <div class="d-flex justify-content-between mt-5">
                                <!-- زر الحفظ -->
                                <button type="submit" class="btn text-white fw-bold w-100"
                                    style="background-color: #28a745; width: 50%;">حفظ البيانات</button>
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
                            <!-- عمود المعاينة (يسار) -->
                            <div class="col-md-4">
                                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm h-100">
                                    <label for="attachmentFile">رفع المرفق</label>

                                    <div class="custom-file mb-2">
                                        <input type="file" name="file"
                                            class="custom-file-input preview-image-input"
                                            data-preview="#preview_attachment_file" id="attachmentFile">
                                        <label class="custom-file-label">اختر ملف</label>
                                    </div>

                                    <div id="preview_attachment_file" class="border rounded p-2 text-center bg-light"
                                        style="min-height: 130px;">
                                        <img src="https://via.placeholder.com/100x100?text=No+File" class="img-thumbnail"
                                            style="max-width: 100px; display: none;" alt="Preview">
                                    </div>
                                </div>
                            </div>

                            <!-- عمود الحقول (يمين) -->
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- عنوان المرفق -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold" style="color: #343a40;">عنوان المرفق</label>
                                            <select id="attachmentTitle" class="form-control fw-bold"
                                                style="height: 60px; border-color: #343a40;" name="document_type"
                                                required>
                                                <option value="">اختر نوع المستند</option>
                                                @foreach ($fileTitles as $fileTitle)
                                                    <option value="{{ $fileTitle->title }}">{{ $fileTitle->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- حالة المرفق -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold" style="color: #343a40;">حالة المرفق</label>
                                            <select id="attachmentStatus" class="form-control fw-bold"
                                                style="height: 60px; border-color: #343a40;" name="status" required>
                                                <option value="">اختر حالة المرفق</option>
                                                <option value="لا يوجد بالمكتب"> لا يوجد بالمكتب </option>
                                                <option value="موجود بالمكتب">موجود بالمكتب</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- الحالة على التطبيق -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold" style="color: #343a40;">الحالة على التطبيق</label>
                                            <select id="attachmentRequired" class="form-control fw-bold"
                                                style="height: 60px; border-color: #343a40;" name="required" required>
                                                <option selected value="true">اجباري</option>
                                                <option value="false">اختياري</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- الملحوظة -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-bold" style="color: #343a40;">ملحوظة</label>
                                            <input type="text" class="form-control fw-bold" name="note"
                                                style="border-color: #343a40; height: 60px;" id="attachmentNote">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- زر إضافة مرفق -->
                        <button type="submit" class="btn text-white fw-bold my-6 w-100" id="addAttachmentFile"
                            style="background-color:#28a745;margin:  15px 0;padding:7px;font-size:20px;"
                            id="addAttachment"> إضافة مرفق (F2)</button>

                        <!-- جدول المرفقات -->
                        <div class="card mt-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="card-title mb-0">قائمة المرفقات</h5>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped text-center m-0">
                                        <thead style="background-color: #343a40; color: white;">
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
                                            @foreach ($files as $file)
                                                <tr>
                                                    <td class="text-success fw-bold">{{ $file->document_type }}</td>

                                                    <td>
                                                        @php
                                                            $extension = pathinfo($file->file, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if (!empty($extension))
                                                            <a href="{{ asset('storage/' . $file->file) }}"
                                                                target="_blank">
                                                                @if (strtolower($extension) === 'pdf')
                                                                    <img src="https://cdn-icons-png.freepik.com/512/4726/4726010.png"
                                                                        alt="PDF" class="img-fluid"
                                                                        style="width: 40px;">
                                                                @else
                                                                    <img src="{{ asset('storage/' . $file->file) }}"
                                                                        alt="File" class="img-thumbnail"
                                                                        style="max-width: 100px;">
                                                                @endif
                                                            </a>
                                                        @elseif (empty($extension) && $file->file != null)
                                                            <a href="{{ $file->file }}" target="_blank">
                                                                <img src="" alt="PDF" class="img-fluid"
                                                                    style="width: 40px;">
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <span
                                                            class="badge 
                                                            @if ($file->status == 'موجود بالمكتب') bg-success 
                                                            @elseif ($file->status == 'لا يوجد بالمكتب') bg-warning text-dark 
                                                            @else bg-secondary @endif">
                                                            {{ $file->status }}
                                                        </span>
                                                    </td>

                                                    <td class="fw-bold">
                                                        {{ $file->required ? 'اجباري' : 'اختياري' }}
                                                    </td>

                                                    <td>{{ $file->note }}</td>

                                                    <td class="d-flex flex-wrap justify-content-center gap-1">
                                                        @if ($file->order_status == 'panding')
                                                            <a href="{{ route('document-type.accept', $file->id) }}"
                                                                class="btn btn-success btn-sm btn-flat">
                                                                <i class="fas fa-check"></i> موافقة
                                                            </a>
                                                            <a href="{{ route('document-type.reject', $file->id) }}"
                                                                class="btn btn-danger btn-sm btn-flat">
                                                                <i class="fas fa-times"></i> رفض
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('storage/' . $file->file) }}" download
                                                                class="btn btn-success btn-sm btn-flat" title="تحميل">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <a href="{{ asset('storage/' . $file->file) }}"
                                                                target="_blank" class="btn btn-primary btn-sm btn-flat"
                                                                title="عرض">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('attachments.show', $file->id) }}"
                                                                class="btn btn-warning btn-sm btn-flat text-white"
                                                                title="تعديل">
                                                                <i class="fas fa-pen"></i>
                                                            </a>
                                                            <a href="{{ route('attachments.delete', $file->id) }}"
                                                                class="btn btn-danger btn-sm btn-flat" title="حذف">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </form>

                    <!-- المدفوعات -->
                    <form action="{{ route('customer.payments', $edit->id) }}" method="POST" id="payments"
                        class="tab-pane fade {{ session('tap') == 'payment' ? 'show active' : '' }}">
                        @csrf
                        <h4>إضافة مدفوعات</h4>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="fw-bold" style="color: #343a40;">عنوان الدفع</label>
                                <select id="paymentTitle" class="form-control fw-bold"
                                    style="height: 60px; border-color: #343a40;" required name="payment_title_id">
                                    <option value="">اختر نوع المعاملة</option>
                                    @foreach ($paymentTitles as $paymentTitle)
                                        <option value="{{ $paymentTitle->id }}">{{ $paymentTitle->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- قيمة الدفع -->
                            <div class="col-md-6">
                                <label class="fw-bold" style="color: #343a40;">قيمة الدفع</label>
                                <input type="number" required name="amount" class="form-control fw-bold"
                                    style="border-color: #343a40; height: 60px;" id="paymentAmount"
                                    placeholder="أدخل القيمة">
                            </div>

                            <!-- المتبقي -->
                            <div class="col-md-6">
                                <label class="fw-bold" style="color: #343a40;">المتبقي</label>
                                <input type="number" name="amoun_rest" class="form-control fw-bold"
                                    style="border-color: #343a40; height: 60px;" id="paymentRest" value="0"
                                    placeholder="أدخل المتبقي">
                            </div>
                        </div>


                        <button type="submit" class="btn text-white fw-bold mt-4 w-100"
                            style="background-color: #28a745; padding: 15px; font-size: 18px;" id="addPayment">
                            إضافة دفعة
                        </button>



                        <div class="card mt-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">جدول المدفوعات</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0 text-center align-middle">
                                        <thead class="bg-dark text-white">
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
                                                    <td class="fw-bold text-success">{{ $payment->paymentTitle->title }}
                                                    </td>
                                                    <td>{{ $payment->amount }} جنية</td>
                                                    <td>{{ $payment->amoun_rest }} جنية</td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

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

        </div>
    </div>


    <!-- مؤشر التحميل -->
    <div id="loadingIndicator" style="display: none; color: #997a44; font-weight: bold;">
        جاري استخراج بيانات الجواز...
    </div>

    <!-- رسالة النجاح -->
    <div id="successMessage" style="display: none; color: green; font-weight: bold;">
        تم استخراج البيانات بنجاح!
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




        /* body,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                html {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    height: 100%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    margin: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    display: flex;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    justify-content: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    align-items: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    background-color: #fff;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    font-family: Arial, sans-serif;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    color: #333;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } */

        .loader {
            border: 5px solid #f3f3f3;
            /* لون الخلفية */
            border-top: 5px solid #4caf50;
            /* لون الدائرة المتحركة */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 16px;
            text-align: center;
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

        document.addEventListener('keydown', function(event) {
            if (event.key == 'F1') {
                event.preventDefault();
                document.getElementById("saveData").click();
            }
            if (event.key == 'F2') {
                event.preventDefault();
                document.getElementById("addAttachmentFile").click();
            }
            if (event.key === 'F4') {
                event.preventDefault();
                window.history.back();
            }
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
            // console.log("Birth Date:", birthDate);
            // console.log("Gender:", gender);
            // console.log("Age:", age);
            // console.log("Issue Place:", countryCode);


        }

        async function previewImage(event) {

            const file = event.target.files[0];
            // console.log("File:", file);

            if (!file) return;

            // عرض الصورة المختارة
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("imagePreview").src = e.target.result;
            };
            reader.readAsDataURL(file);

            // إظهار مؤشر التحميل وإخفاء رسالة النجاح
            document.getElementById("loadingIndicator").style.display = "block";
            document.getElementById("successMessage").style.display = "none";

            const formData = new FormData();
            formData.append("imageUrl", file);

            try {
                const response = await fetch("http://localhost:3000/extract-passport", {
                    method: "POST",
                    body: formData,
                });

                const result = await response.json();

                // تعبئة الحقول
                document.getElementById("passport_number").value = result.passport_number || "";
                document.getElementById("full_name").value = result.full_name_english || "";
                document.getElementById("nationality").value = result.nationality || "";
                document.getElementById("dob").value = result.date_of_birth || "";
                document.getElementById("expiry_date").value = result.date_of_expiry || "";
                document.getElementById("eg_code").value = result.country_code || "";
                document.getElementById("gender").value = result.sex || "";

                const birthDate = new Date(result.date_of_birth);
                const age = new Date().getFullYear() - birthDate.getFullYear();
                document.getElementById("age").value = age;

                // عرض رسالة النجاح
                document.getElementById("successMessage").style.display = "block";
                setTimeout(() => {
                    document.getElementById("successMessage").style.display = "none";
                }, 3000); // تختفي بعد 3 ثوانٍ

            } catch (error) {
                // console.error("Failed to extract passport data:", error);
                alert("فشل في استخراج البيانات. تأكد من وضوح الصورة.");
            } finally {
                document.getElementById("loadingIndicator").style.display = "none";
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
    </script>


    <script type="module">
        function calculateAgeFromDMY(dateStr) {
            const [day, month, year] = dateStr.split('/').map(Number);
            const birthDate = new Date(year, month - 1, day); // الشهر يبدأ من 0 في JavaScript
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            return age;
        }

        import {
            GoogleGenerativeAI
        } from "https://esm.sh/@google/generative-ai";

        const genAI = new GoogleGenerativeAI("AIzaSyDjk68-pr2IRQ5oJOb6AkAZe219EpJAHh4");

        async function convertImageUrlToBase64(imageUrl) {
            const response = await fetch(imageUrl);
            const blob = await response.blob();
            return await fileToBase64(blob);
        }

        async function fileToBase64(file) {
            const buffer = await file.arrayBuffer();
            const bytes = new Uint8Array(buffer);
            let binary = "";
            bytes.forEach((b) => binary += String.fromCharCode(b));
            return btoa(binary);
        }

        document.getElementById("analyzeBtn").addEventListener("click", async () => {
            document.getElementById("hhhh").style.display = "block";
            document.getElementById("gggg").style.display = "block";

            const fileInput = document.getElementById("passportInput");
            const file = fileInput.files[0];
            const resultBox = document.getElementById("resultBox");

            let base64Image = "";
            let mimeType = "image/jpeg"; // default

            try {
                if (file) {
                    base64Image = await fileToBase64(file);
                    mimeType = file.type;
                } else {
                    const imageUrl = document.getElementById('imagePreviewpass').src;
                    base64Image = await convertImageUrlToBase64(imageUrl);
                    // ممكن نحاول تحديد نوع الصورة من الامتداد
                    mimeType = imageUrl.endsWith(".png") ? "image/png" : "image/jpeg";
                }

                const model = genAI.getGenerativeModel({
                    model: "gemini-2.0-flash"
                });

                const prompt = `
                                    Extract all data from this passport in English. Convert the national ID to English digits if it's in Arabic. Return response as clean JSON only with these keys:
                                    {
                                    "passport_type",
                                    "country_code",
                                    "passport_number",
                                    "full_name_arabic"=>ترجمه من الاسم الانجليزي لازالة المسافات في الاسماء المركبة,
                                    "full_name_english",
                                    "date_of_birth",
                                    "place_of_birth",
                                    "nationality_ar",
                                    "sex_ar",
                                    "date_of_issue",
                                    "date_of_expiry",
                                    "issuing_office",
                                    "national_id",
                                    "profession",
                                    "military_status",
                                    "address",
                                    "full_mrz"=> اريده بدون مسافات,
                                    "age"
                                    }
                                    `;

                const result = await model.generateContent({
                    contents: [{
                        role: "user",
                        parts: [{
                                inlineData: {
                                    mimeType: mimeType,
                                    data: base64Image,
                                },
                            },
                            {
                                text: prompt,
                            },
                        ],
                    }],
                });

                let text = await result.response.text();
                text = text.trim();

                if (text.startsWith("```json")) {
                text = text.replace(/^```json/, "").replace(/```$/, "").trim();
                }

                const data = JSON.parse(text);
                console.log(data);

                if (data.passport_type !== 'null') {
                    document.getElementById("mrz_input").value = data.full_mrz;
                    document.getElementById("issue_place").value = data.issuing_office;
                    document.getElementById("full_name").value = data.full_name_english;
                    document.getElementById("passport_number").value = data.passport_number;
                    document.getElementById("nationality").value = data.nationality_ar;
                    document.getElementById("dob").value = data.date_of_birth;
                    document.getElementById("expiry_date").value = data.date_of_expiry;
                    document.getElementById("gender").value = data.sex_ar;
                    document.getElementById("age").value = calculateAgeFromDMY(data.date_of_birth);
                    document.getElementById("card_id").value = data.national_id;
                    document.getElementById("date_of_issue").value = data.date_of_issue;
                    document.getElementById("name_ar").value = data.full_name_arabic;
                } else {
                    Swal.fire({
                        title: "هناك خطا في الصورة",
                        icon: "error",
                        draggable: true
                    });
                    document.getElementById("hhhh").style.display = "none";
                    document.getElementById("gggg").style.display = "none";
                }
            } catch (error) {
                console.error("❌ Error:", error);
                Swal.fire({
                    title: "هناك خطا في الصورة",
                    icon: "error",
                    draggable: true
                });
                document.getElementById("hhhh").style.display = "none";
                document.getElementById("gggg").style.display = "none";
            } finally {
                document.getElementById("hhhh").style.display = "none";
                document.getElementById("gggg").style.display = "none";
            }
        });

        document.getElementById('imageInput').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'inline-block'; // في حال كانت مخفية
                }

                reader.readAsDataURL(input.files[0]);
            }
        });
        document.getElementById('passportInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.getElementById('imagePreviewpass');
                    img.setAttribute('src', event.target.result);
                    img.style.display = 'inline-block'; // عرض الصورة
                };
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const fileInputs = document.querySelectorAll('.preview-image-input');

            fileInputs.forEach(function(input) {
                input.addEventListener('change', function(e) {
                    const previewSelector = input.getAttribute('data-preview');
                    const previewContainer = document.querySelector(previewSelector);
                    const img = previewContainer.querySelector('img');

                    const file = input.files[0];

                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            img.src = e.target.result;
                            img.style.display = 'inline-block';
                        };

                        reader.readAsDataURL(file);
                    } else {
                        // إذا لم تكن صورة، نخفي المعاينة
                        img.src = "https://via.placeholder.com/100x100?text=No+File";
                        img.style.display = 'none';
                    }
                });
            });
        });
    </script>


@stop
