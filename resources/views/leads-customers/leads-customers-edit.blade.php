@extends('adminlte::page')

@section('title', 'تعديل العميل المحتمل')

@section('content_header')
    <h1 class="text-center font-weight-bold d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-user-edit ml-2"></i>
            تعديل العميل ({{ $lead->name }})
        </div>
        <div>
            <a href="{{ route('leads-customers.index') }}">
                <button type="submit" class="btn btn-success btn-block font-weight-bold">
                    رجوع الي العملاء المحتملون
                </button>
            </a>
        </div>
    </h1>
@stop

@section('content')
    <div class="card card-primary card-outline shadow">
        <div class="card-body">
            <form id="myForm" action="{{ route('leads-customers.edit', $lead->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- معلومات أساسية --}}
                    <div class="col-md-12">
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-primary text-white">
                                <strong><i class="fas fa-id-card-alt ml-2"></i> بيانات العميل</strong>
                            </div>
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <label>الاسم الكامل</label>
                                    <input type="text" id="name" class="form-control" name="name"
                                        value="{{ $lead->name }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>الوظيفة المقدم عليها</label>
                                    <select class="form-control" name="job_title_id">
                                        <option value="">اختر الوظيفة</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ $lead->job_title_id == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>السن</label>
                                    <input type="number" id="age" class="form-control" name="age"
                                        value="{{ $lead->age }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>رقم الهاتف</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $lead->phone }}">
                                        <div class="input-group-append">
                                            <a href="{{ route('reset.password.lead', $lead->id) }}" class="btn btn-warning">
                                                إعادة تعيين الباسورد
                                            </a>
                                        </div>
                                    </div>
                                    @if ($errors->has('phone'))
                                        <div class="text-danger">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>رقم هاتف اخر</label>
                                    <input type="text" class="form-control" name="phone_two"
                                        value="{{ $lead->phone_two }}">
                                    @if ($errors->has('phone_two'))
                                        <div class="text-danger">
                                            {{ $errors->first('phone_two') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label>الرقم القومي</label>
                                    <input type="text" class="form-control" id="card_id" name="card_id"
                                        value="{{ $lead->card_id }}">
                                    @if ($errors->has('card_id'))
                                        <div class="text-danger">
                                            {{ $errors->first('card_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>رقم جواز السفر</label>
                                    <input type="text" class="form-control" id="passport_numder" name="passport_numder"
                                        value="{{ $lead->passport_numder }}">
                                    @if ($errors->has('passport_numder'))
                                        <div class="text-danger">
                                            {{ $errors->first('passport_numder') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>تاريخ الميلاد</label>
                                    @if ($lead->date_of_birth)
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                            value="{{ \Carbon\Carbon::hasFormat($lead->date_of_birth, 'Y-m-d') ? $lead->date_of_birth : \Carbon\Carbon::createFromFormat('d/m/Y', $lead->date_of_birth)->format('Y-m-d') }}">
                                    @else
                                        <input type="date" id="date_of_birth" class="form-control" name="date_of_birth"
                                            value="">
                                    @endif
                                    @if ($errors->has('date_of_birth'))
                                        <div class="text-danger">
                                            {{ $errors->first('date_of_birth') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- معلومات إضافية --}}
                    <div class="col-md-12">
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-info text-white">
                                <strong><i class="fas fa-info-circle ml-2"></i> تفاصيل إضافية</strong>
                            </div>
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <label>المندوب</label>
                                    <select class="form-control" name="delegate_id">
                                        <option value="">اختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{ $delegate->id }}"
                                                {{ $lead->delegate_id == $delegate->id ? 'selected' : '' }}>
                                                {{ $delegate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>نوع الاختبار</label>
                                    <select class="form-control" name="test_type">
                                        <option value="">اختر النوع</option>
                                        @foreach (['اول اختبار', 'اعادة اختبار', 'قيادة امنة'] as $type)
                                            <option value="{{ $type }}"
                                                {{ $lead->test_type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label>التقييم</label>
                                    <select class="form-control" name="evaluation">
                                        <option value="">اختر التقييم</option>
                                        @foreach (['جارى المعالجة', 'مقبول', 'احتياطي', 'غير مقبول'] as $eval)
                                            <option value="{{ $eval }}"
                                                {{ $lead->evaluation == $eval ? 'selected' : '' }}>
                                                {{ $eval }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label>المحافظة</label>
                                    <select class="form-control" id="governorate" name="governorate">
                                        <option value="">اختر المحافظة</option>
                                        @foreach ($governorates as $gov)
                                            <option value="{{ $gov }}"
                                                {{ $lead->governorate == $gov ? 'selected' : '' }}>
                                                {{ $gov }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>موعد التسجيل</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" name="registration_date"
                                            value="{{ $lead->registration_date }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تحسين تخطيط قسم الصور -->
                    <!-- تحسين تخطيط قسم الصور -->
                    <div class="col-md-12">
                        <div class="card bg-light mb-4">
                            <div class="card-header bg-warning text-dark">
                                <strong><i class="fas fa-images ml-2"></i> المستندات والصور</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <!-- الصورة الشخصية -->
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group p-3 bg-white rounded border shadow-sm h-100">
                                            <label for="dd" class="font-weight-bold text-dark">
                                                <i class="fas fa-user-circle mr-2"></i>الصورة الشخصية
                                            </label>

                                            <div class="custom-file mb-3">
                                                <input type="file" name="image"
                                                    class="custom-file-input preview-image-input"
                                                    data-preview="#preview_image" id="dd" accept="image/*">
                                                <label class="custom-file-label" for="dd">اختر الصورة
                                                    الشخصية</label>
                                            </div>

                                            <div id="preview_image" class="border rounded p-3 text-center bg-light"
                                                style="min-height: 200px;">
                                                <img src="{{ $lead->image ? asset('storage/' . $lead->image) : 'https://via.placeholder.com/150x150?text=الصورة+الشخصية' }}"
                                                    class="img-fluid rounded-circle"
                                                    style="max-height: 180px; display: {{ $lead->image ? 'block' : 'none' }} !important;"
                                                    alt="Preview">
                                                @if (!$lead->image)
                                                    <div class="text-muted placeholder-text mt-3">
                                                        <i class="fas fa-user-circle fa-2x"></i>
                                                        <p class="mt-2">لم يتم اختيار صورة</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <button type="button" class="btn btn-primary btn-sm mt-3 crop-image-btn"
                                                data-input="#dd" data-preview="#preview_image">
                                                <i class="fas fa-crop-alt mr-1"></i> اقتصاص
                                            </button>
                                        </div>
                                    </div>

                                    <!-- صورة جواز السفر -->
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group p-3 bg-white rounded border shadow-sm h-100">
                                            <label for="passportInput" class="font-weight-bold text-primary">
                                                <i class="fas fa-passport mr-2"></i>صورة جواز السفر
                                            </label>

                                            <div class="custom-file mb-3">
                                                <input type="file" name="passport_photo"
                                                    class="custom-file-input preview-image-input"
                                                    data-preview="#preview_passport_photo" id="passportInput"
                                                    accept="image/*">
                                                <label class="custom-file-label" for="passportInput">اختر صورة جواز
                                                    السفر</label>
                                            </div>

                                            <div id="preview_passport_photo"
                                                class="border rounded p-3 text-center bg-light"
                                                style="min-height: 200px;">
                                                <img id="imagePreviewpass"
                                                    src="{{ $lead->passport_photo ? asset('storage/' . $lead->passport_photo) : 'https://via.placeholder.com/150x150?text=صورة+جواز+السفر' }}"
                                                    class="img-fluid rounded"
                                                    style="max-height: 180px; display: {{ $lead->passport_photo ? 'block' : 'none' }} !important;"
                                                    alt="Preview">

                                                @if (!$lead->passport_photo)
                                                    <div class="text-muted placeholder-text mt-3">
                                                        <i class="fas fa-image fa-2x"></i>
                                                        <p class="mt-2">لم يتم اختيار صورة</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                                <button type="button" class="btn btn-primary btn-sm crop-image-btn"
                                                    data-input="#passportInput" data-preview="#preview_passport_photo">
                                                    <i class="fas fa-crop-alt mr-1"></i> اقتصاص
                                                </button>

                                                <button type="button" id="analyzeBtn" class="btn btn-success btn-sm">
                                                    <i class="fas fa-magic mr-1"></i> فك البيانات
                                                </button>
                                            </div>

                                            <!-- محمل التحليل -->
                                            <div id="passportInput_loader" class="text-center mt-3"
                                                style="display: none;">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only">جاري التحليل...</span>
                                                </div>
                                                <p class="text-primary mt-2" id="passportInput_loader_text">الرجاء
                                                    الانتظار...</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- صورة إثبات المهنة -->
                                    <div class="col-md-4 mb-4">
                                        <div class="form-group p-3 bg-white rounded border shadow-sm h-100">
                                            <label for="ff" class="font-weight-bold text-success">
                                                <i class="fas fa-certificate mr-2"></i>اثبات مهنة (رخصة أو شهادة)
                                            </label>

                                            <div class="custom-file mb-3">
                                                <input type="file" name="license_photo"
                                                    class="custom-file-input preview-image-input"
                                                    data-preview="#preview_license_photo" id="ff"
                                                    accept="image/*">
                                                <label class="custom-file-label" for="ff">اختر صورة إثبات
                                                    المهنة</label>
                                            </div>

                                            <div id="preview_license_photo"
                                                class="border rounded p-3 text-center bg-light"
                                                style="min-height: 200px;">
                                                <img src="{{ $lead->license_photo ? asset('storage/' . $lead->license_photo) : 'https://via.placeholder.com/150x150?text=إثبات+المهنة' }}"
                                                    class="img-fluid rounded"
                                                    style="max-height: 180px; display: {{ $lead->license_photo ? 'block' : 'none' }} !important;"
                                                    alt="Preview">

                                                @if (!$lead->license_photo)
                                                    <div class="text-muted placeholder-text mt-3">
                                                        <i class="fas fa-image fa-2x"></i>
                                                        <p class="mt-2">لم يتم اختيار صورة</p>
                                                    </div>
                                                @endif

                                            </div>

                                            <button type="button" class="btn btn-primary btn-sm mt-3 crop-image-btn"
                                                data-input="#ff" data-preview="#preview_license_photo">
                                                <i class="fas fa-crop-alt mr-1"></i> اقتصاص
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <!-- صور البطاقة الشخصية -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group p-3 bg-white rounded border shadow-sm">
                                            <label for="ss" class="font-weight-bold text-info">
                                                <i class="fas fa-id-card mr-2"></i>بطاقة الرقم القومي (الأمام)
                                            </label>

                                            <div class="custom-file mb-3">
                                                <input type="file" name="img_national_id_card"
                                                    class="custom-file-input preview-image-input"
                                                    data-preview="#preview_img_national_id_card" id="ss"
                                                    accept="image/*">
                                                <label class="custom-file-label" for="ss">اختر صورة البطاقة من
                                                    الأمام</label>
                                            </div>

                                            <div id="preview_img_national_id_card"
                                                class="border rounded p-3 text-center bg-light"
                                                style="min-height: 160px;">
                                                <img src="{{ $lead->img_national_id_card ? asset('storage/' . $lead->img_national_id_card) : 'https://via.placeholder.com/200x120?text=البطاقة+من+الأمام' }}"
                                                    class="img-fluid rounded"
                                                    style="max-height: 140px; display: {{ $lead->img_national_id_card ? 'block' : 'none' }} !important;"
                                                    alt="Preview">

                                                @if (!$lead->img_national_id_card)
                                                    <div class="text-muted placeholder-text mt-3">
                                                        <i class="fas fa-image fa-2x"></i>
                                                        <p class="mt-2">لم يتم اختيار صورة</p>
                                                    </div>
                                                @endif

                                            </div>

                                            <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                                data-input="#ss" data-preview="#preview_img_national_id_card">
                                                <i class="fas fa-crop-alt mr-1"></i> اقتصاص
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group p-3 bg-white rounded border shadow-sm">
                                            <label for="aa" class="font-weight-bold text-info">
                                                <i class="fas fa-id-card mr-2"></i>بطاقة الرقم القومي (الخلف)
                                            </label>

                                            <div class="custom-file mb-3">
                                                <input type="file" name="img_national_id_card_back"
                                                    class="custom-file-input preview-image-input"
                                                    data-preview="#preview_img_national_id_card_back" id="aa"
                                                    accept="image/*">
                                                <label class="custom-file-label" for="aa">اختر صورة البطاقة من
                                                    الخلف</label>
                                            </div>

                                            <div id="preview_img_national_id_card_back"
                                                class="border rounded p-3 text-center bg-light"
                                                style="min-height: 160px;">
                                                <img src="{{ $lead->img_national_id_card_back ? asset('storage/' . $lead->img_national_id_card_back) : 'https://via.placeholder.com/200x120?text=البطاقة+من+الخلف' }}"
                                                    class="img-fluid rounded"
                                                    style="max-height: 140px; display: {{ $lead->img_national_id_card_back ? 'block' : 'none' }} !important;"
                                                    alt="Preview">

                                                @if (!$lead->img_national_id_card_back)
                                                    <div class="text-muted placeholder-text mt-3">
                                                        <i class="fas fa-image fa-2x"></i>
                                                        <p class="mt-2">لم يتم اختيار صورة</p>
                                                    </div>
                                                @endif

                                            </div>

                                            <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                                data-input="#aa" data-preview="#preview_img_national_id_card_back">
                                                <i class="fas fa-crop-alt mr-1"></i> اقتصاص
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- زر الحفظ --}}
                    <div class="col-md-12">
                        <button type="submit" id="save-button" class="btn btn-success btn-block font-weight-bold">
                            <i class="fas fa-save ml-2"></i> حفظ التعديلات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="loading-overlay"
        style="display: none; position: fixed; z-index: 9999; top:0; left:0; width:100%; height:100%; background: rgba(255,255,255,0.8);">
        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
            <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                <span class="sr-only">جارٍ التحميل...</span>
            </div>
        </div>
    </div>

    <!-- نافذة اقتصاص محسّنة متوافقة مع Bootstrap 4 -->
    <div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 90vw;">
            <div class="modal-content" style="height: 80vh;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="cropperModalLabel">
                        <i class="fas fa-crop-alt mr-2"></i>
                        اقتصاص الصورة
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0 bg-dark d-flex align-items-center justify-content-center"
                    style="height: calc(100% - 130px); overflow: hidden;">
                    <img id="cropperImage" style="max-width: 100%; max-height: 100%; display: block;">
                </div>

                <div class="modal-footer d-flex justify-content-between flex-wrap">
                    <div class="btn-group mb-2 mb-md-0" role="group">
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomIn" title="تكبير">
                            <i class="fas fa-search-plus"></i> تكبير
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomOut" title="تصغير">
                            <i class="fas fa-search-minus"></i> تصغير
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="rotateLeft" title="تدوير">
                            <i class="fas fa-undo"></i> تدوير
                        </button>
                        <button type="button" class="btn btn-info btn-sm" id="reset" title="إعادة ضبط">
                            <i class="fas fa-refresh"></i> إعادة ضبط
                        </button>
                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            <i class="fas fa-times"></i> إلغاء
                        </button>
                        <button type="button" id="cropConfirm" class="btn btn-success">
                            <i class="fas fa-check"></i> تأكيد الاقتصاص
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'نجاح',
                text: '{{ session('success') }}',
                confirmButtonText: 'حسناً'
            });
        </script>
    @endif
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" rel="stylesheet" />
    <style>
        /* تحسينات CSS للمودال وتخطيط الصور */
        #cropperModal .modal-content {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        #cropperImage {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .preview-image-input+.custom-file-label::after {
            content: "تصفح";
        }

        .form-group.shadow-sm {
            transition: all 0.3s ease;
        }

        .form-group.shadow-sm:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-2px);
        }

        .crop-image-btn {
            transition: all 0.3s ease;
        }

        .crop-image-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        #analyzeBtn {
            transition: all 0.3s ease;
        }

        #analyzeBtn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        /* تحسين مظهر الصورة الشخصية */
        #preview_image img {
            border-radius: 50% !important;
            border: 3px solid #17a2b8;
            width: 120px !important;
            height: 120px !important;
            object-fit: cover;
        }

        #preview_image img:hover {
            border-color: #138496;
            transform: scale(1.05);
        }

        [id^="preview_"] {
            transition: all 0.3s ease;
            position: relative;
        }

        [id^="preview_"] img {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        [id^="preview_"] img:hover {
            border-color: #007bff;
            transform: scale(1.02);
        }

        /* تحسين الألوان */
        .card-header.bg-warning {
            background: linear-gradient(45deg, #ffc107, #fd7e14) !important;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }

        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            border: none;
        }

        /* محمل دوار محسّن */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .spinner-border {
            width: 2rem;
            height: 2rem;
        }

        /* تحسين responsiveness */
        @media (max-width: 768px) {
            #cropperModal .modal-dialog {
                max-width: 95vw;
                margin: 10px auto;
            }

            #cropperModal .modal-content {
                height: 90vh;
            }

            .modal-footer {
                flex-direction: column;
                gap: 10px;
            }

            .btn-group {
                width: 100%;
            }

            .btn-group .btn {
                flex: 1;
            }
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>
        // إصلاح مشاكل اقتصاص الصورة
        // إصلاح مشاكل اقتصاص الصورة
        let cropper;
        let currentInputFile = null;
        let currentPreviewId = null;
        const cropperModal = document.getElementById("cropperModal");
        const cropperImage = document.getElementById("cropperImage");

        // معالج اختيار الصورة وعرضها في المعاينة
        document.querySelectorAll('.preview-image-input').forEach(input => {
            const previewSelector = input.getAttribute('data-preview');
            const previewDiv = document.querySelector(previewSelector);
            const previewImg = previewDiv.querySelector('img');
            const placeholderText = previewDiv.querySelector('.text-muted');

            // عرض الصورة الموجودة مسبقًا إذا كانت موجودة
            if (previewImg && previewImg.src && !previewImg.src.includes('placeholder')) {
                previewImg.style.display = 'block';
                if (placeholderText) placeholderText.style.display = 'none';
            } else {
                previewImg.style.display = 'none';
                if (placeholderText) placeholderText.style.display = 'block';
            }

            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                        if (placeholderText) placeholderText.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    // إذا لم يتم اختيار صورة جديدة
                    if (previewImg.src && !previewImg.src.includes('placeholder')) {
                        previewImg.style.display = 'block';
                        if (placeholderText) placeholderText.style.display = 'none';
                    } else {
                        previewImg.style.display = 'none';
                        if (placeholderText) placeholderText.style.display = 'block';
                    }
                }

                // تحديث label كما هو موجود في الكود الحالي
                const label = this.nextElementSibling;
                if (label && this.files[0]) {
                    label.textContent = this.files[0].name;
                } else if (label) {
                    const inputId = this.id;
                    switch (inputId) {
                        case 'dd':
                            label.textContent = 'اختر الصورة الشخصية';
                            break;
                        case 'passportInput':
                            label.textContent = 'اختر صورة جواز السفر';
                            break;
                        case 'ff':
                            label.textContent = 'اختر صورة إثبات المهنة';
                            break;
                        case 'ss':
                            label.textContent = 'اختر صورة البطاقة من الأمام';
                            break;
                        case 'aa':
                            label.textContent = 'اختر صورة البطاقة من الخلف';
                            break;
                        default:
                            label.textContent = 'اختر صورة';
                    }
                }
            });
        });

        // معالج أزرار الاقتصاص
        document.querySelectorAll(".crop-image-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const inputSelector = this.getAttribute("data-input");
                const previewSelector = this.getAttribute("data-preview");

                currentInputFile = document.querySelector(inputSelector);
                currentPreviewId = previewSelector;

                const previewDiv = document.querySelector(previewSelector);
                const previewImg = previewDiv.querySelector('img');

                // إذا لم يتم اختيار ملف جديد، استخدم الصورة الحالية
                if (!currentInputFile.files[0] && previewImg && previewImg.src && !previewImg.src.includes(
                        'placeholder')) {
                    cropperImage.src = previewImg.src;
                    $(cropperModal).modal('show');
                    return;
                }

                if (!currentInputFile.files[0]) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تنبيه',
                        text: 'اختر صورة أولاً قبل الاقتصاص!',
                        confirmButtonText: 'حسناً'
                    });
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    $(cropperModal).modal('show');
                };
                reader.readAsDataURL(currentInputFile.files[0]);
            });
        });

        // تهيئة Cropper عند فتح المودال
        $(cropperModal).on('shown.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            cropper = new Cropper(cropperImage, {
                aspectRatio: NaN, // حرية الاقتصاص
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.8,
                responsive: true,
                restore: false,
                guides: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                minCropBoxWidth: 50,
                minCropBoxHeight: 50,
                ready: function() {
                    console.log('Cropper ready');
                }
            });
        });

        // تنظيف Cropper عند إغلاق المودال
        $(cropperModal).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        // زر تأكيد الاقتصاص
        document.getElementById("cropConfirm").addEventListener("click", function() {
            if (cropper && currentPreviewId && currentInputFile) {
                const canvas = cropper.getCroppedCanvas({
                    width: 800,
                    height: 600,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });

                canvas.toBlob(function(blob) {
                    if (!blob) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'فشل في اقتصاص الصورة',
                            confirmButtonText: 'حسناً'
                        });
                        return;
                    }

                    const fileName = (currentInputFile.files[0]?.name) || 'cropped_image.jpg';
                    const file = new File([blob], fileName, {
                        type: "image/jpeg",
                        lastModified: Date.now()
                    });

                    // إذا لم يكن هناك ملف جديد في input، نضيف الملف الجديد
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentInputFile.files = dataTransfer.files;

                    // تحديث المعاينة
                    const previewDiv = document.querySelector(currentPreviewId);
                    const previewImg = previewDiv.querySelector('img');
                    const placeholderText = previewDiv.querySelector('.text-muted');

                    if (previewImg) {
                        previewImg.src = URL.createObjectURL(file);
                        previewImg.style.display = "block";
                        if (placeholderText) placeholderText.style.display = 'none';
                    }

                    // تحديث label
                    const label = currentInputFile.nextElementSibling;
                    if (label) {
                        label.textContent = fileName;
                    }

                    // إغلاق المودال
                    $(cropperModal).modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'تم',
                        text: 'تم اقتصاص الصورة بنجاح',
                        timer: 2000,
                        showConfirmButton: false
                    });

                }, "image/jpeg", 0.9);
            }
        });


        // أدوات التحكم في Cropper
        document.getElementById("zoomIn").addEventListener("click", function() {
            if (cropper) {
                cropper.zoom(0.1);
            }
        });

        document.getElementById("zoomOut").addEventListener("click", function() {
            if (cropper) {
                cropper.zoom(-0.1);
            }
        });

        document.getElementById("rotateLeft").addEventListener("click", function() {
            if (cropper) {
                cropper.rotate(-90);
            }
        });

        document.getElementById("reset").addEventListener("click", function() {
            if (cropper) {
                cropper.reset();
            }
        });

        // إضافة زر إغلاق للمودال
        document.querySelector('#cropperModal .btn-close, #cropperModal [data-bs-dismiss="modal"]')?.addEventListener(
            'click',
            function() {
                $(cropperModal).modal('hide');
            });

        // معالج تحميل النموذج
        document.getElementById('myForm').addEventListener('submit', function() {
            document.getElementById('loading-overlay').style.display = 'block';
            document.getElementById('save-button').disabled = true;
        });

        // Animation للـ loader
        const style = document.createElement('style');
        style.textContent = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                
                .custom-file-input:focus ~ .custom-file-label {
                    border-color: #007bff;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                }
                
                .crop-image-btn:hover {
                    background-color: #0056b3;
                }
                
                #cropperModal .modal-body {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            `;
        document.head.appendChild(style);
    </script>

    <script type="module">
        function calculateAge(dateOfBirthStr) {
            // تحويل التاريخ إلى أجزاء
            const [day, month, year] = dateOfBirthStr.split('/').map(Number);
            const birthDate = new Date(year, month - 1, day);
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();

            // لو لسه ما جاش تاريخ الميلاد في السنة الحالية
            const hasBirthdayPassedThisYear =
                today.getMonth() > birthDate.getMonth() ||
                (today.getMonth() === birthDate.getMonth() && today.getDate() >= birthDate.getDate());

            if (!hasBirthdayPassedThisYear) {
                age--;
            }

            return age;
        }

        import {
            GoogleGenerativeAI
        } from "https://esm.sh/@google/generative-ai";

        const genAI = new GoogleGenerativeAI("AIzaSyDjk68-pr2IRQ5oJOb6AkAZe219EpJAHh4");

        async function fileToBase64(file) {
            const buffer = await file.arrayBuffer();
            const bytes = new Uint8Array(buffer);
            let binary = "";
            bytes.forEach((b) => binary += String.fromCharCode(b));
            return btoa(binary);
        }

        // ✅ للـ Blob اللي جاي من fetch
        async function blobToBase64(blob) {
            const buffer = await blob.arrayBuffer();
            const bytes = new Uint8Array(buffer);
            let binary = "";
            bytes.forEach((b) => binary += String.fromCharCode(b));
            return btoa(binary);
        }

        async function convertImageUrlToBase64(url) {
            const response = await fetch(url);
            const blob = await response.blob();
            return await blobToBase64(blob); // ✨ هنا التعديل
        }


        document.getElementById("analyzeBtn").addEventListener("click", async () => {
            document.getElementById("passportInput_loader").style.display = "block";
            document.getElementById("passportInput_loader_text").style.display = "block";
            const fileInput = document.getElementById("passportInput");
            const file = fileInput.files[0];
            const imageUrl = document.getElementById('imagePreviewpass')?.src || "";

            let base64Image, mimeType;

            if (file) {
                // ✅ لو فيه ملف مرفوع
                base64Image = await fileToBase64(file);
                mimeType = file.type;
            } else if (imageUrl && (imageUrl.startsWith("data:") || imageUrl.startsWith("http"))) {
                // ✅ لو فيه صورة في الـ preview
                base64Image = await convertImageUrlToBase64(imageUrl);
                mimeType = imageUrl.endsWith(".png") ? "image/png" : "image/jpeg";
            } else {
                // ❌ لو مفيش أي صورة
                Swal.fire({
                    title: "اختر صورة جواز السفر اولا",
                    icon: "error",
                    draggable: true
                });
                document.getElementById("passportInput_loader").style.display = "none";
                document.getElementById("passportInput_loader_text").style.display = "none";
                return;
            }

            try {
                // const base64Image = await fileToBase64(file);
                const model = genAI.getGenerativeModel({
                    model: "gemini-2.0-flash"
                });
                const prompt = `"Extract all information from the passport image with high accuracy, ensuring no errors, and present the output as a JSON object. The JSON should include the following keys:

                    passport_no

                    type

                    country_code

                    full_name_english

                    full_name_arabic (ensure 'ماهر' is one word, e.g., 'ماهر محمد عبدالعزيز مرسي')

                    date_of_birth

                    place_of_birth (must be one of: 'القاهرة', 'الجيزة', 'الأسكندرية', 'الدقهلية', 'البحر الأحمر', 'البحيرة', 'الفيوم', 'الغربية', 'الإسماعيلية', 'المنوفية', 'المنيا', 'القليوبية', 'الوادي الجديد', 'السويس', 'أسوان', 'أسيوط', 'بني سويف', 'بورسعيد', 'دمياط', 'الشرقية', 'جنوب سيناء', 'كفر الشيخ', 'مطروح', 'الأقصر', 'قنا', 'شمال سيناء', 'سوهاج','السعودية', 'القدس', 'الأردن', 'العراق', 'لبنان', 'فلسطين', 'اليمن', 'عمان', 'الإمارات العربية المتحدة', 'الكويت', 'قطر', 'البحرين')

                    nationality

                    sex

                    date_of_issue

                    date_of_expiry

                    issuing_office

                    national_id (should be in Western/English numerals, e.g., '28101191800397')

                    profession

                    mrz_lines (an array containing each line of the Machine Readable Zone)

                    Example of desired JSON structure:

                    JSON

                    {
                    "passport_no": "VALUE",
                    "type": "VALUE",
                    "country_code": "VALUE",
                    "full_name_english": "VALUE",
                    "full_name_arabic": "VALUE",
                    "date_of_birth": "VALUE",
                    "place_of_birth": "VALUE_FROM_LIST",
                    "nationality": "VALUE",
                    "sex": "VALUE",
                    "date_of_issue": "VALUE",
                    "date_of_expiry": "VALUE",
                    "issuing_office": "VALUE",
                    "national_id": "VALUE_IN_ENGLISH_NUMERALS",
                    "profession": "VALUE",
                    "mrz_lines": [
                        "VALUE_LINE_1",
                        "VALUE_LINE_2"
                    ]
                    }
                    "`;

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
                                text: prompt
                            },
                        ],
                    }, ],
                });
                let text = await result.response.text();

                // تنظيف النص من Markdown إن وجد
                text = text.trim();
                if (text.startsWith("```json")) {
                text = text.replace(/^```json/, '').replace(/```$/, '').trim();

                try {
                    // تحويل النص إلى كائن JSON
                    const data = JSON.parse(text);

                    // التحقق من وجود full_mrz في الكائن
                    if (data.passport_type !== 'null') {
                        document.getElementById("name").value = data.full_name_arabic;
                        document.getElementById("card_id").value = data.national_id;
                        document.getElementById("age").value = calculateAge(data.date_of_birth);
                        document.getElementById("passport_numder").value = data.passport_no;
                        if (data.date_of_birth) {
                            let parts = data.date_of_birth.split('/');
                            if (parts.length === 3) {
                                let formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                                    document.getElementById("date_of_birth").value = formattedDate;
                                }
                            }
                            const govSelect = document.getElementById('governorate');
                            if (data.place_of_birth) {
                                const valueToSelect = data.place_of_birth.trim();
                                for (let option of govSelect.options) {
                                    if (option.value.trim() === valueToSelect) {
                                        option.selected = true;
                                        break;
                                    }
                                }
                            }
                            document.getElementById("passportInput_loader").style.display = "none";
                            document.getElementById("passportInput_loader_text").style.display = "none";

                        } else {
                            Swal.fire({
                                title: "الصورة غير واضحة!",
                                icon: "error",
                                draggable: true
                            });
                            document.getElementById("passportInput_loader").style.display = "none";
                            document.getElementById("passportInput_loader_text").style.display = "none";
                        }

                        console.log(data);
                    } catch (error) {
                        Swal.fire({
                            title: "الصورة غير واضحة!",
                            icon: "error",
                            draggable: true
                        });
                        document.getElementById("passportInput_loader").style.display = "none";
                        document.getElementById("passportInput_loader_text").style.display = "none";
                        console.error("Error parsing JSON:", error);
                    }
                }
                console.log(text)
            } catch (error) {
                document.getElementById("passportInput_loader").style.display = "none";
                document.getElementById("passportInput_loader_text").style.display = "none";
                console.error("❌ Error:", error);
                alert("حدث خطأ أثناء تحليل الصورة");
            }
        });
    </script>
@stop
