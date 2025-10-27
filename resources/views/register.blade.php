@extends('layouts.app')
@section('title', 'تسجيل العمالة')
@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e8f0f7 100%);
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(135deg, #174A7C 0%, #1a5a94 50%, #B89C5A 100%);
            color: white;
            padding: 3rem 1rem;
            margin-bottom: 2rem;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 4px 20px rgba(23, 74, 124, 0.3);
        }

        .hero-section h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        .registration-card {
            border-radius: 24px;
            border: none;
            box-shadow: 0 10px 40px rgba(23, 74, 124, 0.15);
            overflow: hidden;
            background: white;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #174A7C 0%, #1a5a94 60%, #B89C5A 100%);
            color: #fff;
            padding: 1.5rem;
            border: none;
        }

        .card-header-custom h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .card-body-custom {
            padding: 2rem;
            background: white;
        }

        .form-label {
            color: #174A7C;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #174A7C;
            box-shadow: 0 0 0 0.2rem rgba(23, 74, 124, 0.15);
            outline: none;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23174A7C' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        }

        .required-field {
            color: #dc3545;
            font-weight: 700;
            margin-right: 2px;
        }

        .optional-badge {
            color: #6b7280;
            font-weight: 400;
            font-size: 0.85rem;
        }

        .submit-btn {
            background: linear-gradient(135deg, #174A7C 0%, #1a5a94 50%, #B89C5A 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.9rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(23, 74, 124, 0.3);
            letter-spacing: 0.5px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(23, 74, 124, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper input[type="file"] {
            cursor: pointer;
        }

        .file-input-wrapper input[type="file"]::file-selector-button {
            background: linear-gradient(135deg, #174A7C 0%, #B89C5A 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-left: 0.5rem;
            transition: all 0.3s ease;
        }

        .file-input-wrapper input[type="file"]::file-selector-button:hover {
            opacity: 0.9;
        }

        .form-text {
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .input-icon {
            color: #B89C5A;
            margin-left: 5px;
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f4f6;
            border-top-color: #174A7C;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1rem;
                border-radius: 0 0 20px 20px;
            }

            .hero-section h1 {
                font-size: 1.5rem;
            }

            .hero-section p {
                font-size: 0.95rem;
            }

            .card-body-custom {
                padding: 1.5rem;
            }

            .card-header-custom h4 {
                font-size: 1.25rem;
            }

            .submit-btn {
                font-size: 1rem;
                padding: 0.8rem 1.5rem;
            }

            .form-control,
            .form-select {
                font-size: 0.9rem;
                padding: 0.65rem 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-right: 15px;
                padding-left: 15px;
            }

            .registration-card {
                border-radius: 20px;
            }

            .form-label {
                font-size: 0.9rem;
            }
        }

        /* Animation for form validation */
        .is-invalid {
            animation: shake 0.4s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.25rem;
            color: #dc3545;
        }
    </style>

    <div class="hero-section text-center">
        <div class="container">
            <h1 style="color: white !important;">تسجيل العمالة المصرية</h1>
            <p>سجل بياناتك الآن للحصول على فرص عمل متميزة في الخارج</p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card registration-card">
                    <div class="card-header-custom text-center">
                        <h4 style="color: white !important;">📝 نموذج التسجيل</h4>
                    </div>
                    <div class="card-body-custom">
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                ✅ {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>⚠️ يرجى تصحيح الأخطاء التالية:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.apply') }}" enctype="multipart/form-data"
                            id="registrationForm">
                            @csrf

                            <!-- الاسم الكامل -->
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <span class="input-icon">👤</span>
                                    الاسم الكامل
                                    <span class="optional-badge">(اختياري)</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" pattern="[\u0600-\u06FF\s]+"
                                    title="الرجاء إدخال الاسم بالعربية فقط" placeholder="أدخل اسمك الكامل بالعربية">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الرقم القومي -->
                            <div class="mb-4">
                                <label for="national_id" class="form-label">
                                    <span class="input-icon">🆔</span>
                                    الرقم القومي
                                    <span class="optional-badge">(اختياري)</span>
                                </label>
                                <input type="text" class="form-control @error('national_id') is-invalid @enderror"
                                    id="national_id" name="national_id" value="{{ old('national_id') }}" pattern="[0-9]{14}"
                                    maxlength="14" title="الرقم القومي يجب أن يكون 14 رقماً"
                                    placeholder="مثال: 29501011234567">
                                @error('national_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">يجب أن يتكون من 14 رقماً</small>
                            </div>

                            <!-- الوظيفة -->
                            <div class="mb-4">
                                <label for="job_title" class="form-label">
                                    <span class="input-icon">💼</span>
                                    الوظيفة المطلوبة
                                    <span class="optional-badge">(اختياري)</span>
                                </label>
                                <select class="form-select @error('job_title') is-invalid @enderror" id="job_title"
                                    name="job_title">
                                    <option value="">جاري تحميل الوظائف...</option>
                                </select>
                                @error('job_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text" id="jobsLoadingText">
                                    <span class="loading-spinner"></span> جاري تحميل الوظائف المتاحة...
                                </small>
                            </div>

                            <!-- رقم الهاتف -->
                            <div class="mb-4">
                                <label for="phone" class="form-label">
                                    <span class="input-icon">📱</span>
                                    رقم الهاتف
                                    <span class="required-field">*</span>
                                </label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}" required
                                    pattern="^(010|011|012|015)[0-9]{8}$" maxlength="11"
                                    title="رقم الهاتف يجب أن يبدأ بـ 010 أو 011 أو 012 أو 015 ويتكون من 11 رقماً"
                                    placeholder="مثال: 01012345678">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">يجب أن يبدأ بـ 010، 011، 012، أو 015 (11 رقماً)</small>
                            </div>

                            <!-- الصورة الشخصية -->
                            <div class="mb-4">
                                <label for="personal_photo" class="form-label">
                                    <span class="input-icon">📸</span>
                                    الصورة الشخصية
                                    <span class="optional-badge">(اختياري)</span>
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file" class="form-control @error('personal_photo') is-invalid @enderror"
                                        id="personal_photo" name="personal_photo" accept="image/jpeg,image/jpg,image/png">
                                </div>
                                @error('personal_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">الصيغ المسموحة: JPG, PNG (حجم أقصى: 2MB)</small>
                            </div>

                            <!-- صورة البطاقة -->
                            <div class="mb-4">
                                <label for="id_card_photo" class="form-label">
                                    <span class="input-icon">🪪</span>
                                    صورة البطاقة
                                    <span class="optional-badge">(اختياري)</span>
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file"
                                        class="form-control @error('id_card_photo') is-invalid @enderror"
                                        id="id_card_photo" name="id_card_photo" accept="image/jpeg,image/jpg,image/png">
                                </div>
                                @error('id_card_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">الصيغ المسموحة: JPG, PNG (حجم أقصى: 2MB)</small>
                            </div>

                            <!-- ملاحظات -->
                            <div class="mb-4">
                                <label for="message" class="form-label">
                                    <span class="input-icon">💬</span>
                                    ملاحظات أو رسالة إضافية
                                    <span class="optional-badge">(اختياري)</span>
                                </label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4"
                                    placeholder="اكتب أي ملاحظات أو معلومات إضافية تريد إضافتها...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="submit-btn">
                                ✨ تسجيل البيانات
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // جلب الوظائف من API
        async function loadJobs() {
            const jobSelect = document.getElementById('job_title');
            const loadingText = document.getElementById('jobsLoadingText');
            const oldValue = "{{ old('job_title') }}";

            try {
                const response = await fetch('https://mishcrm.com/api/jobs');
                const jobs = await response.json();

                // مسح الخيارات القديمة
                jobSelect.innerHTML = '<option value="">اختر الوظيفة المطلوبة</option>';

                // إضافة الوظائف المتاحة فقط (show_in_app = yes)
                jobs.forEach(job => {
                    if (job.show_in_app === 'yes') {
                        const option = document.createElement('option');
                        option.value = job.title;
                        option.textContent = job.title;

                        // استرجاع القيمة القديمة في حالة validation error
                        if (oldValue && oldValue === job.title) {
                            option.selected = true;
                        }

                        jobSelect.appendChild(option);
                    }
                });

                // إخفاء نص التحميل
                loadingText.style.display = 'none';

                // إذا لم يكن هناك وظائف متاحة
                if (jobSelect.options.length === 1) {
                    jobSelect.innerHTML = '<option value="">لا توجد وظائف متاحة حالياً</option>';
                    loadingText.innerHTML = '⚠️ لا توجد وظائف متاحة في الوقت الحالي';
                    loadingText.style.display = 'block';
                    loadingText.style.color = '#dc3545';
                }

            } catch (error) {
                console.error('Error loading jobs:', error);
                jobSelect.innerHTML = '<option value="">خطأ في تحميل الوظائف</option>';
                loadingText.innerHTML = '⚠️ حدث خطأ أثناء تحميل الوظائف، يرجى المحاولة لاحقاً';
                loadingText.style.display = 'block';
                loadingText.style.color = '#dc3545';
            }
        }

        // تحميل الوظائف عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', loadJobs);

        // Validation للرقم القومي
        document.getElementById('national_id').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 14) {
                this.value = this.value.slice(0, 14);
            }
        });

        // Validation لرقم الهاتف
        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });

        // Validation للاسم العربي
        document.getElementById('name').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '');
        });

        // Custom validation عند الإرسال
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            const nationalId = document.getElementById('national_id').value;

            // التحقق من رقم الهاتف
            if (!/^(010|011|012|015)[0-9]{8}$/.test(phone)) {
                e.preventDefault();
                alert('⚠️ رقم الهاتف غير صحيح.\nيجب أن يبدأ بـ 010 أو 011 أو 012 أو 015 ويتكون من 11 رقماً');
                document.getElementById('phone').focus();
                return false;
            }

            // التحقق من الرقم القومي إذا تم إدخاله
            if (nationalId && nationalId.length !== 14) {
                e.preventDefault();
                alert('⚠️ الرقم القومي يجب أن يتكون من 14 رقماً');
                document.getElementById('national_id').focus();
                return false;
            }
        });

        // Preview للصور المرفوعة
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // يمكن إضافة معاينة للصورة هنا إذا أردت
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('personal_photo')?.addEventListener('change', function() {
            previewImage(this, 'personalPhotoPreview');
        });

        document.getElementById('id_card_photo')?.addEventListener('change', function() {
            previewImage(this, 'idCardPhotoPreview');
        });
    </script>
@endsection
