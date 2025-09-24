<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل عميل داخل اختبار</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #667eea;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-color: #4facfe;
            --secondary-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-color: #48bb78;
            --success-gradient: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 20px 0;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            background: white;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--primary-gradient) !important;
            color: white;
            border-bottom: none;
            padding: 20px 25px;
            position: relative;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h3::before {
            content: '👤';
            font-size: 1.2em;
        }

        .card-body {
            padding: 30px;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control,
        .custom-file-input+.custom-file-label {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 14px;
            transition: var(--transition);
            background: white;
        }

        .form-control:focus,
        .custom-file-input:focus+.custom-file-label {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control:hover,
        .custom-file-input+.custom-file-label:hover {
            border-color: #cbd5e0;
        }

        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: left 12px center;
            background-repeat: no-repeat;
            background-size: 16px 12px;
        }

        /* صناديق الصور المحسنة */
        .form-group.p-3 {
            background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%) !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: var(--border-radius) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .form-group.p-3::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--secondary-gradient);
        }

        .form-group.p-3:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12) !important;
            border-color: var(--secondary-color) !important;
        }

        .custom-file {
            margin-bottom: 15px;
        }

        .custom-file-label {
            border: 2px dashed #cbd5e0;
            background: #f7fafc;
            color: #718096;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .custom-file-label:hover {
            border-color: var(--secondary-color);
            background: #edf2f7;
            color: var(--secondary-color);
        }

        .custom-file-input:focus+.custom-file-label {
            border-color: var(--primary-color);
            background: #ebf4ff;
        }

        /* معاينة الصور */
        [id^="preview_"] {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important;
            border: 2px dashed #cbd5e0 !important;
            border-radius: 10px !important;
            transition: var(--transition);
            position: relative;
        }

        [id^="preview_"]:hover {
            border-color: var(--secondary-color) !important;
            background: linear-gradient(135deg, #ebf4ff 0%, #e6fffa 100%) !important;
        }

        /* أزرار محسنة */
        .btn {
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            text-transform: none;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--secondary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        }

        .btn-success {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
            font-size: 16px;
            padding: 15px 30px;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
        }

        .card-footer {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-top: none;
            padding: 25px;
        }

        /* تحسينات إضافية */
        .crop-image-btn {
            background: var(--primary-gradient) !important;
            border: none;
            color: white;
            font-size: 12px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .crop-image-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* زر تحليل الجواز */
        #analyzeBtn {
            background: var(--success-gradient) !important;
            border: none;
            border-radius: 8px;
            padding: 10px 20px !important;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        #analyzeBtn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(72, 187, 120, 0.4);
        }

        /* اللودر */
        .loader {
            border: 4px solid #e2e8f0 !important;
            border-top: 4px solid var(--primary-color) !important;
            animation: spin 1s linear infinite;
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
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        /* تحسين الصفوف المرنة للصور */
        .d-flex.flex-wrap.gap-3 {
            gap: 20px !important;
        }

        .d-flex.flex-wrap.gap-3>div {
            min-width: 280px;
        }

        /* رسائل الخطأ */
        .text-danger {
            color: #e53e3e !important;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 500;
        }

        /* تحسين الحاوي الرئيسي */
        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* تأثيرات إضافية للتركيز */
        input:focus,
        select:focus,
        textarea:focus {
            transform: translateY(-1px);
        }

        /* تحسين الخلفية للأقسام */
        .col-md-8,
        .col-md-4 {
            padding: 10px;
        }

        /* تحسين أيقونات التسميات */
        label[for="name"]::before {
            content: "👤 ";
        }

        label[for="job_title_id"]::before {
            content: "💼 ";
        }

        label[for="delegate_id"]::before {
            content: "👨‍💼 ";
        }

        label[for="age"]::before {
            content: "📅 ";
        }

        label[for="phone"]::before {
            content: "📱 ";
        }

        label[for="phone_two"]::before {
            content: "📞 ";
        }

        label[for="card_id"]::before {
            content: "🆔 ";
        }

        label[for="passport_numder"]::before {
            content: "📘 ";
        }

        label[for="test_type"]::before {
            content: "📝 ";
        }

        label[for="governorate"]::before {
            content: "📍 ";
        }

        label[for="registration_date"]::before {
            content: "📆 ";
        }

        label[for="date_of_birth"]::before {
            content: "🎂 ";
        }

        /* أيقونات الصور */
        label[for="image"]::before {
            content: "📷 ";
        }

        label[for="passport_photo"]::before {
            content: "📘 ";
        }

        label[for="img_national_id_card"]::before {
            content: "🆔 ";
        }

        label[for="img_national_id_card_back"]::before {
            content: "🔄 ";
        }

        label[for="license_photo"]::before {
            content: "📜 ";
        }

        /* تحسين الاستجابة */
        @media (max-width: 768px) {
            .card-body {
                padding: 20px;
            }

            .d-flex.flex-wrap.gap-3 {
                flex-direction: column;
            }

            .d-flex.flex-wrap.gap-3>div {
                min-width: 100%;
                flex: none !important;
            }

            .btn-success {
                width: 100% !important;
                padding: 12px 20px;
                font-size: 14px;
            }
        }

        .custom-file-input~.custom-file-label::after {
            content: "اضغط";
            /* color: #28a745; */
            background-color: var(--primary-color);
            color: white;
            /* أخضر Bootstrap */
            font-weight: bold;
            /* اختياري: عشان تبان أوضح */
        }

        .custom-file-label {
            display: flex;
            justify-content: center;
            /* يوسّط أفقياً */
            align-items: center;
            /* يوسّط عمودياً */
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header bg-secondary d-flex justify-content-between align-items-center ">
                <h3 class="card-title">تسجيل عميل داخل اختبار</h3>
                <h3>
                    <a href="{{ route('test.leads', $test_id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </h3>
            </div>

            @if ($errors->any())
                <script>
                    let errorMessages = `<ul style="text-align:right;direction:rtl;"> 
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>`;
                    Swal.fire({
                        icon: 'error',
                        title: 'حدثت أخطاء في الإدخال:',
                        html: errorMessages,
                        confirmButtonText: 'حسناً'
                    });
                </script>
            @endif

            </script>
            <form action="{{ route('create.lead.in.test', $test_id) }}" id="myForm" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="test_id" value="{{ $test_id }}">

                <div class="card-body">
                    <div class="row">
                        <!-- الحقول الرئيسية -->
                        <div class="col-md-8">
                            <!-- الصورة الشخصية -->
                            <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm">
                                <label for="image">الصورة الشخصية</label>

                                <div class="custom-file mb-2">
                                    <input type="file" name="image" class="custom-file-input preview-image-input"
                                        data-preview="#preview_image" id="dd" required>
                                    <label class="custom-file-label">اختر صورة</label>
                                </div>

                                <div id="preview_image" class="border rounded p-2 text-center bg-light"
                                    style="min-height: 130px;">
                                    <img src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail"
                                        style="max-width: 100px; display: none;" alt="Preview">
                                </div>
                                <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                    data-input="#dd" data-preview="#preview_image">
                                    اقتصاص
                                </button>
                            </div>

                            <!-- باقي الحقول -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">اسم العميل (باللغة العربية)</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="أدخل اسم العميل" required pattern="^[\u0600-\u06FF\s]+$"
                                        title="الرجاء إدخال أحرف عربية فقط"
                                        oninput="this.value = this.value.replace(/[^ء-ي\s]/g,'')">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="card_id">الرقم القومي</label>
                                    <input type="text" name="card_id" id="card_id" class="form-control" required
                                        placeholder="أدخل الرقم القومي" value="{{ old('card_id') }}"
                                        pattern="^[0-9]{14}$" maxlength="14"
                                        title="يجب أن يكون الرقم القومي مكونًا من 14 رقمًا"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                    <div id="card-error" class="text-danger"></div>
                                    @if ($errors->has('card_id'))
                                        <div class="text-danger">
                                            {{ $errors->first('card_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>المندوب</label>
                                    <select name="delegate_id" class="form-control" required>
                                        <option value="">اختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{ $delegate->id }}"
                                                {{ old('delegate_id') == $delegate->id ? 'selected' : '' }}>
                                                {{ $delegate->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="job_title_id">الوظيفة المقدم عليها</label>
                                    <select name="job_title_id" id="job_title_id" class="form-control" required>
                                        <option value="">اختر الوظيفة</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ old('job_title_id') == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="age">السن</label>
                                    <input type="text" name="age" id="age" class="form-control"
                                        required placeholder="أدخل السن" value=""
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        pattern="^[0-9]{1,3}$" title="الرجاء إدخال أرقام إنجليزية فقط">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="phone">رقم الهاتف</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        required placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}"
                                        maxlength="11" pattern="^[0-9]{11}$"
                                        title="يجب أن يكون رقم الهاتف مكونًا من 11 رقمًا"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <div id="phone-error" class="text-danger"></div>
                                    @if ($errors->has('phone'))
                                        <div class="text-danger">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="governorate">المحافظة</label>
                                    <select name="governorate" id="governorate" class="form-control" required>
                                        <option value="">اختر المحافظة</option>
                                        @foreach ($governorates as $gov)
                                            <option value="{{ $gov }}"
                                                {{ old('governorate') == $gov ? 'selected' : '' }}>
                                                {{ $gov }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date_of_birth">تاريخ الميلاد</label>
                                    <input id="date_of_birth" type="date" name="date_of_birth"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="licence_date_end">تاريخ انتهاء الرخصة</label>
                                    <input id="licence_date_end" type="date" name="licence_date_end"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="notes">ملاحظات</label>

                                    <textarea name="notes" id="notes" class="form-control p-2" cols="30" rows="10">{{ old('notes', $lead->notes ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group col-md-12 mt-3" id="job-questions-container">
                                <!-- هنا هتظهر الأسئلة -->
                            </div>
                        </div>

                        <!-- صور -->
                        <div class="col-md-4">

                            <!-- صور البطاقة الشخصية (جنباً إلى جنب) -->
                            <div class="d-flex flex-wrap gap-3">
                                <!-- بطاقة الرقم القومي من الأمام -->
                                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm"
                                    style="flex: 1 1 48%;">
                                    <label for="img_national_id_card">بطاقة الرقم القومي من الامام</label>

                                    <div class="custom-file mb-2">
                                        <input type="file" name="img_national_id_card"
                                            class="custom-file-input preview-image-input"
                                            data-preview="#preview_img_national_id_card" id="ss" required>
                                        <label class="custom-file-label">اختر صورة</label>
                                    </div>

                                    <div id="preview_img_national_id_card"
                                        class="border rounded p-2 text-center bg-light" style="min-height: 130px;">
                                        <img src="https://via.placeholder.com/100x100?text=No+Image"
                                            class="img-thumbnail" style="max-width: 100px; display: none;"
                                            alt="Preview">
                                    </div>
                                    <div class="mt-3 d-flex align-items-center gap-3  justify-content-between">

                                        <div>
                                            <button type="button" id="analyzeBtn" class="btn btn-primary">
                                                استخراج البيانات
                                            </button>
                                        </div>

                                        <!-- Loader -->
                                        <div id="loader_container" class="d-flex align-items-center gap-2"
                                            style="display: none;">
                                            <div id="passportInput_loader" class="spinner-border text-primary"
                                                role="status"
                                                style="width: 24px; height: 24px;margin-left: 14px; display: none;">
                                            </div>
                                            <div id="passportInput_loader_text" class="loading-text text-primary"
                                                style="font-size: 14px; display: none;">
                                                الرجاء الانتظار...
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                                data-input="#ss" data-preview="#preview_img_national_id_card">
                                                اقتصاص
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- بطاقة الرقم القومي من الخلف -->
                                <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm"
                                    style="flex: 1 1 48%;">
                                    <label for="img_national_id_card_back">بطاقة الرقم القومي من الخلف</label>

                                    <div class="custom-file mb-2">
                                        <input type="file" name="img_national_id_card_back"
                                            class="custom-file-input preview-image-input"
                                            data-preview="#preview_img_national_id_card_back" id="aa" required>
                                        <label class="custom-file-label">اختر صورة</label>
                                    </div>

                                    <div id="preview_img_national_id_card_back"
                                        class="border rounded p-2 text-center bg-light" style="min-height: 130px;">
                                        <img src="https://via.placeholder.com/100x100?text=No+Image"
                                            class="img-thumbnail" style="max-width: 100px; display: none;"
                                            alt="Preview">
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                        data-input="#aa" data-preview="#preview_img_national_id_card_back">
                                        اقتصاص
                                    </button>
                                </div>
                            </div>

                            <!-- إثبات مهنة -->
                            <div class="form-group p-3 mb-4 bg-white rounded border shadow-sm">
                                <label for="license_photo">اثبات مهنة ( رخصة او شهادة او CV) اختياري</label>

                                <div class="custom-file mb-2">
                                    <input type="file" name="license_photo"
                                        class="custom-file-input preview-image-input"
                                        data-preview="#preview_license_photo" id="ff" required>
                                    <label class="custom-file-label">اختر صورة</label>
                                </div>

                                <div id="preview_license_photo" class="border rounded p-2 text-center bg-light"
                                    style="min-height: 130px;">
                                    <img src="https://via.placeholder.com/100x100?text=No+Image" class="img-thumbnail"
                                        style="max-width: 100px; display: none;" alt="Preview">
                                </div>
                                <button type="button" class="btn btn-primary btn-sm mt-2 crop-image-btn"
                                    data-input="#ff" data-preview="#preview_license_photo">
                                    اقتصاص
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" id="submitBtn" class="btn btn-success" style="width: 250px">
                        <i class="fas fa-plus-circle"></i> حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>
    @if (session('already_exists'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه',
                text: '{{ session('already_exists') }}',
                confirmButtonText: 'حسناً',
                allowOutsideClick: false, // منع إغلاق النوافذ بالنقر خارجها
                allowEscapeKey: false, // منع إغلاق بالنقر على زر Esc
                allowEnterKey: false // منع إغلاق بالضغط على Enter
            });
        </script>
    @endif
    {{-- تعديل الصور --}}
    <!-- نافذة الاقتصاص -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 70vw; height: 70vh;">
            <div class="modal-content" style="height: 100%;">

                <div class="modal-header">
                    <h5 class="modal-title">اقتصاص الصورة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>

                <!-- جسم المودال (الصورة تاخد كل المساحة المتاحة) -->
                <div class="modal-body bg-dark p-0" style="height: calc(100% - 120px);">
                    <div class="w-100 h-100">
                        <img id="cropperImage" style="width:100%; height:100%; object-fit:contain; display:block;">
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" id="zoomIn">تكبير +</button>
                        <button type="button" class="btn btn-secondary" id="zoomOut">تصغير -</button>
                        <button type="button" class="btn btn-secondary" id="rotateLeft">↺ تدوير</button>
                        <button type="button" class="btn btn-secondary" id="reset">إعادة ضبط</button>
                    </div>
                    <button type="button" id="cropConfirm" class="btn btn-success">تأكيد الاقتصاص</button>
                </div>

            </div>
        </div>
    </div>
    {{-- swal اتمام الحفظ --}}
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'نجاح!',
                text: '{{ session('success') }}',
                confirmButtonText: 'حسناً'
            });
        </script>
    @endif

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // مثال لمعاينة الصور
        // $(document).on('change', '.preview-image-input', function() {
        //     var input = this;
        //     var previewId = $(this).data('preview');

        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader
        //         reader.onload = function(e) {
        //             var img = $(previewId).find('img');
        //             img.attr('src', e.target.result);
        //             img.show();
        //         }
        //         reader.readAsDataURL(input.files[0]);
        //     }
        // });
    </script>
    {{-- قص الصورة --}}
    <script>
        let cropper;
        let currentInputFile = null;
        let currentPreviewId = null;
        const cropperModal = document.getElementById("cropperModal");
        const cropperImage = document.getElementById("cropperImage");

        // اختيار صورة
        document.querySelectorAll(".crop-image-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const inputSelector = this.getAttribute("data-input");
                const previewSelector = this.getAttribute("data-preview");

                currentInputFile = document.querySelector(inputSelector);
                currentPreviewId = previewSelector;

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

                    // فتح المودال
                    const modal = new bootstrap.Modal(cropperModal);
                    modal.show();
                };
                reader.readAsDataURL(currentInputFile.files[0]);
            });
        });


        // بعد ما المودال يظهر فعليًا
        cropperModal.addEventListener("shown.bs.modal", function() {
            if (cropper) cropper.destroy();

            cropper = new Cropper(cropperImage, {
                aspectRatio: NaN,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
                ready() {
                    // نخلي الصورة تملأ المساحة من أول مرة
                    const containerData = cropper.getContainerData();
                    const imageData = cropper.getImageData();

                    let scaleX = containerData.width / imageData.width;
                    let scaleY = containerData.height / imageData.height;
                    let scale = Math.min(scaleX, scaleY);

                    cropper.zoomTo(scale);
                }
            });
        });

        // زر تأكيد الاقتصاص
        document.getElementById("cropConfirm").addEventListener("click", function() {
            if (cropper && currentPreviewId && currentInputFile) {
                cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                }).toBlob(function(blob) {
                    const file = new File([blob], "cropped.jpg", {
                        type: "image/jpeg"
                    });

                    // نغير ملف input نفسه
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentInputFile.files = dataTransfer.files;

                    // نعرض الصورة في preview
                    const previewDiv = document.querySelector(currentPreviewId + " img");
                    previewDiv.src = URL.createObjectURL(file);
                    previewDiv.style.display = "block";

                    // إغلاق المودال
                    const modal = bootstrap.Modal.getInstance(cropperModal);
                    modal.hide();
                }, "image/jpeg");
            }
        });

        // أدوات التحكم
        document.getElementById("zoomIn").addEventListener("click", function() {
            if (cropper) cropper.zoom(0.1);
        });

        document.getElementById("zoomOut").addEventListener("click", function() {
            if (cropper) cropper.zoom(-0.1);
        });

        document.getElementById("rotateLeft").addEventListener("click", function() {
            if (cropper) cropper.rotate(-90);
        });

        document.getElementById("reset").addEventListener("click", function() {
            if (cropper) {
                cropper.reset();

                // نخلي الصورة تملأ تاني
                const containerData = cropper.getContainerData();
                const imageData = cropper.getImageData();

                let scaleX = containerData.width / imageData.width;
                let scaleY = containerData.height / imageData.height;
                let scale = Math.min(scaleX, scaleY);

                cropper.zoomTo(scale);
            }
        });
    </script>
    <script type="module">
        function calculateAge(dateOfBirth) {
            const today = new Date();
            const birthDate = new Date(dateOfBirth);

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            const dayDiff = today.getDate() - birthDate.getDate();

            // لو لسه ماعداش عيد ميلاده في السنة الحالية ننقص سنة
            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
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

        document.getElementById("analyzeBtn").addEventListener("click", async () => {
            document.getElementById("passportInput_loader").style.display = "block";
            document.getElementById("passportInput_loader_text").style.display = "block";
            const fileInput = document.getElementById("ss");
            const file = fileInput.files[0];
            const resultBox = document.getElementById("resultBox");

            if (!file) {
                Swal.fire({
                    title: "اختر صورة البطاقة اولا",
                    icon: "error",
                    draggable: true
                });
                document.getElementById("passportInput_loader").style.display = "none";
                document.getElementById("passportInput_loader_text").style.display = "none";
                return;
            }

            try {
                const base64Image = await fileToBase64(file);
                const model = genAI.getGenerativeModel({
                    model: "gemini-2.0-flash"
                });
                const prompt = `Please analyze the attached national ID card image and extract the following data, then return the result strictly in JSON format.

                        Step 1 (must): Extract the national_id first and ensure it is exactly 14 digits using English digits 0-9 only.
                        Step 2 (must): Derive the date_of_birth **exclusively from the national_id** (do NOT rely on the visual printed date on the card). Use the following decoding rule:
                        - The national_id is 14 digits. Let firstDigit = the 1st digit (index 0).
                        - The encoded birth date is taken from digits 2-7 (indexes 1..6) as YYMMDD.
                        - Compose date_of_birth as YYYY-MM-DD using English digits only. Validate the date (month 01-12, day valid for that month); if invalid, set date_of_birth to an empty string and still return national_id.
                        - Calculate "age" (in years, integer) strictly from the derived date_of_birth using the current date.

                        Required fields:
                        - name: Full name (Combine all lines even if written on multiple lines, return full name in Arabic in a single field)
                        - national_id: (14 digits, English digits 0-9 only)
                        - date_of_birth: (Format YYYY-MM-DD, strictly derived from national_id as specified above)
                        - age: (integer, derived from date_of_birth)
                        - governorate: (Extracted from national_id and returned strictly in Arabic, chosen only from the allowed list below)

                        Important note: The value of the "governorate" key must be exactly one of the following Arabic values only:
                        "القاهرة", "الجيزة", "الإسكندرية", "الدقهلية", "البحر الأحمر", "البحيرة", "الفيوم", "الغربية", "الإسماعيلية", "المنوفية", "المنيا", "القليوبية", "الوادي الجديد", "السويس", "أسوان", "أسيوط", "بني سويف", "بورسعيد", "دمياط", "الشرقية", "جنوب سيناء", "كفر الشيخ", "مطروح", "الأقصر", "قنا", "شمال سيناء", "سوهاج", "السعودية", "القدس", "الأردن", "العراق", "لبنان", "فلسطين", "اليمن", "عمان", "الإمارات العربية المتحدة", "الكويت", "قطر", "البحرين"

                        Return the output strictly as JSON only (without any explanation or additional text) in the following structure:
                        {
                        "name": "",
                        "national_id": "",
                        "date_of_birth": "",
                        "governorate": ""
                        }`;

                const result = await model.generateContent({
                    contents: [{
                        role: "user",
                        parts: [{
                                inlineData: {
                                    mimeType: file.type,
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
                        if (data.national_id !== 'null') {
                            document.getElementById("name").value = data.name;
                            document.getElementById("card_id").value = data.national_id;
                            document.getElementById("age").value = calculateAge(data.date_of_birth);
                            document.getElementById("date_of_birth").value = data.date_of_birth

                            const govSelect = document.getElementById('governorate');
                            if (data.governorate) {
                                const valueToSelect = data.governorate.trim();
                                for (let option of govSelect.options) {
                                    if (option.value.trim() === valueToSelect) {
                                        option.selected = true;
                                        break;
                                    }
                                }
                            }
                            document.getElementById("passportInput_loader").style.display = "none";
                            document.getElementById("passportInput_loader_text").style.display = "none";
                            $.post("{{ route('check.card') }}", {
                                _token: "{{ csrf_token() }}",
                                card_id: data.national_id
                            }, function(data) {
                                if (data.exists) {
                                    $("#card-error").text("⚠️ الرقم القومي مسجل من قبل!");
                                    Swal.fire({
                                        title: "العميل مسجل من قبل<br> باسم: " + data.name,
                                        icon: "error",
                                        showCancelButton: true,
                                        confirmButtonText: "📂 استدعاء العميل",
                                        cancelButtonText: "❌ إلغاء",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // هنا تحط اللينك اللي يوديه للعميل الآخر
                                            let url =
                                                "{{ route('calling.client', ['test_id' => ':test_id', 'lead_id' => ':lead_id']) }}";

                                            // نستبدل placeholders بالقيم الفعلية
                                            url = url.replace(':test_id', {{ $test_id }})
                                                .replace(
                                                    ':lead_id', data.id);

                                            // إعادة التوجيه
                                            window.location.href = url;
                                        }
                                        // لو ضغط إلغاء مش هيحصل حاجة
                                    });
                                } else {
                                    $("#card-error").text("");
                                }
                            });

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
    <script>
        // التحقق من رقم الهاتف
        $(document).on("input", "#phone", function() {
            let phone = $(this).val();
            if (phone.length === 11) {
                $.post("{{ route('check.phone') }}", {
                    _token: "{{ csrf_token() }}",
                    phone: phone
                }, function(data) {
                    if (data.exists) {
                        $("#phone-error").text("⚠️ رقم الهاتف مسجل من قبل!");
                        Swal.fire({
                            title: "العميل مسجل من قبل<br> باسم: " + data.name,
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "📂 استدعاء العميل",
                            cancelButtonText: "❌ إلغاء",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Laravel يولّد الرابط مع قيم افتراضية (:test_id و :lead_id)
                                let url =
                                    "{{ route('calling.client', ['test_id' => ':test_id', 'lead_id' => ':lead_id']) }}";

                                // نستبدل placeholders بالقيم الفعلية
                                url = url.replace(':test_id', {{ $test_id }}).replace(
                                    ':lead_id', data.id);

                                // إعادة التوجيه
                                window.location.href = url;
                            }
                        });

                    } else {
                        $("#phone-error").text("");
                    }
                });
            }
        });

        // التحقق من الرقم القومي أثناء الكتابة
        $(document).on("input", "#card_id", function() {
            let card_id = $(this).val();
            if (card_id.length === 14) {
                $.post("{{ route('check.card') }}", {
                    _token: "{{ csrf_token() }}",
                    card_id: card_id
                }, function(data) {
                    if (data.exists) {
                        $("#card-error").text("⚠️ الرقم القومي مسجل من قبل!");
                        Swal.fire({
                            title: "العميل مسجل من قبل<br> باسم: " + data.name,
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "📂 استدعاء العميل",
                            cancelButtonText: "❌ إلغاء",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // هنا تحط اللينك اللي يوديه للعميل الآخر
                                let url =
                                    "{{ route('calling.client', ['test_id' => ':test_id', 'lead_id' => ':lead_id']) }}";

                                // نستبدل placeholders بالقيم الفعلية
                                url = url.replace(':test_id', {{ $test_id }}).replace(
                                    ':lead_id', data.id);

                                // إعادة التوجيه
                                window.location.href = url;
                            }
                            // لو ضغط إلغاء مش هيحصل حاجة
                        });
                    } else {
                        $("#card-error").text("");
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jobSelect = document.querySelector('select[name="job_title_id"]');
            const questionsContainer = document.getElementById('job-questions-container');

            jobSelect.addEventListener('change', function() {
                const jobId = this.value;
                questionsContainer.innerHTML = ''; // تنظيف الحقول

                if (jobId) {
                    let url = "{{ route('job.questions', ':id') }}";
                    url = url.replace(':id', jobId);
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status && data.questions.length > 0) {
                                data.questions.forEach(q => {
                                    let field = '';

                                    switch (q.type) {
                                        case 'text':
                                            field = `
            <input type="text" required
                   name="questions[${q.id}]" 
                   class="form-control" 
                   placeholder="أدخل الإجابة"  />`;
                                            break;

                                        case 'textarea':
                                            field = `
            <textarea required name="questions[${q.id}]" 
                      class="form-control" 
                      rows="3" 
                      placeholder="أدخل الإجابة" ></textarea>`;
                                            break;

                                        case 'number':
                                            field = `
            <input  type="number" required
                   name="questions[${q.id}]" 
                   class="form-control" 
                   placeholder="أدخل رقم" />`;
                                            break;

                                        case 'date':
                                            field = `
            <input type="date" required
                   name="questions[${q.id}]" 
                   class="form-control" />`;
                                            break;

                                        case 'select':
                                            if (q.options) {
                                                let opts = JSON.parse(q.options)
                                                    .map(opt =>
                                                        `<option value="${opt}">${opt}</option>`
                                                    )
                                                    .join('');
                                                field = `
                <select name="questions[${q.id}]" class="form-control" required>
                    <option value="">-- اختر --</option>
                    ${opts}
                </select>`;
                                            }
                                            break;

                                        case 'radio':
                                            if (q.options) {
                                                let radios = JSON.parse(q.options)
                                                    .map(opt => `
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" required
                           name="questions[${q.id}]" 
                           value="${opt}">
                    <label class="form-check-label">${opt}</label>
                </div>
            `).join('');
                                                field =
                                                    `<div class="d-flex flex-wrap gap-3">${radios}</div>`;
                                            }
                                            break;

                                        case 'checkbox':
                                            if (q.options) {
                                                let checks = JSON.parse(q.options)
                                                    .map(opt => `
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" required
                           name="questions[${q.id}][]" 
                           value="${opt}">
                    <label class="form-check-label">${opt}</label>
                </div>
            `).join('');
                                                field =
                                                    `<div class="d-flex flex-wrap gap-3">${checks}</div>`;
                                            }
                                            break;

                                    }


                                    questionsContainer.innerHTML += `
                                <div class="form-group mt-2">
                                    <label>${q.question}</label>
                                    ${field}
                                </div>
                            `;
                                });
                            }
                        })
                        .catch(err => console.error(err));
                }
            });
        });

        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phone-error');

        phoneInput.addEventListener('input', function() {
            const phone = phoneInput.value.trim();

            if (phone.length === 0) {
                phoneError.textContent = ''; // مفيش رسالة لو الحقل فاضي
            } else if (phone.length < 11) {
                phoneError.textContent = '⚠️ الرقم أقل من 11 رقم';
            } else if (phone.length > 11) {
                phoneError.textContent = '⚠️ الرقم أكثر من 11 رقم';
            } else {
                phoneError.textContent = ''; // تمام ✅
            }
        });

        const cardInput = document.getElementById('card_id');
        const cardError = document.getElementById('card-error');

        cardInput.addEventListener('input', function() {
            const card = cardInput.value.trim();

            if (card.length === 0) {
                cardError.textContent = ''; // مفيش رسالة لو الحقل فاضي
            } else if (card.length < 14) {
                cardError.textContent = '⚠️ الرقم القومي أقل من 14 رقم';
            } else if (card.length > 14) {
                cardError.textContent = '⚠️ الرقم القومي أكثر من 14 رقم';
            } else {
                cardError.textContent = ''; // تمام ✅
            }
        });
    </script>

    <script>
        document.querySelectorAll('input[type="file"].preview-image-input').forEach(input => {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;

                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        // 👇 حجم الصورة الأقصى بعد الضغط
                        const MAX_WIDTH = 800;
                        const MAX_HEIGHT = 800;

                        let width = img.width;
                        let height = img.height;

                        if (width > height) {
                            if (width > MAX_WIDTH) {
                                height *= MAX_WIDTH / width;
                                width = MAX_WIDTH;
                            }
                        } else {
                            if (height > MAX_HEIGHT) {
                                width *= MAX_HEIGHT / height;
                                height = MAX_HEIGHT;
                            }
                        }

                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(img, 0, 0, width, height);

                        // 👇 نسبة الجودة (0.7 = 70%)
                        canvas.toBlob(function(blob) {
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg'
                            });

                            // استبدل الملف الأصلي بالملف المضغوط
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(compressedFile);
                            event.target.files = dataTransfer.files;

                            // تحديث المعاينة لو فيه data-preview
                            const previewId = event.target.getAttribute('data-preview');
                            if (previewId) {
                                const previewImg = document.querySelector(previewId +
                                    ' img');
                                if (previewImg) {
                                    previewImg.src = URL.createObjectURL(compressedFile);
                                    previewImg.style.display = 'block';
                                }
                            }
                        }, 'image/jpeg', 0.7);
                    }
                }
            });
        });
    </script>

</body>

</html>
