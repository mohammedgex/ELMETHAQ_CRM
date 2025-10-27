@extends('layouts.app')

@section('title', 'خدمات التأشيرات - الميثاق')

@section('content')
    <!-- Visa Hero Section -->
    <section class="hero-section" style="padding: 80px 0; background: linear-gradient(135deg, #174A7C 0%, #B89C5A 100%);">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4 text-white">
                        <i class="fas fa-plane-departure me-3"></i>
                        خدمات التأشيرات
                    </h1>
                    <p class="lead text-white">نقدم خدمات التأشيرات لجميع دول العالم بأفضل الأسعار وأسرع الخدمات</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visa Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5">
                    <div class="service-card shadow-lg">
                        <h3 class="mb-4 text-center text-primary">سجل طلبك الآن</h3>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>معلومات مهمة:</h5>
                            <p class="mb-0">
                                نقدم خدمات شاملة للحصول على التأشيرات لجميع دول العالم، مع ضمان الحصول على
                                التأشيرة في أسرع وقت ممكن وبأفضل الأسعار.
                            </p>
                        </div>

                        <!-- نموذج التأشيرات -->
                        <style>
                            .form-control,
                            .form-select {
                                border-radius: 12px;
                                border: 2px solid #e5e7eb;
                                padding: 15px 20px;
                                font-size: 16px;
                                transition: all 0.3s ease;
                                background-color: #f9fafb;
                            }

                            .form-control:focus,
                            .form-select:focus {
                                border-color: #174A7C;
                                box-shadow: 0 0 0 0.2rem rgba(23, 74, 124, 0.25);
                                background-color: #fff;
                            }

                            .btn-submit {
                                background: linear-gradient(135deg, #174A7C 0%, #B89C5A 100%);
                                border: none;
                                padding: 18px 40px;
                                border-radius: 12px;
                                font-size: 18px;
                                font-weight: 600;
                                color: white;
                                transition: all 0.3s ease;
                                width: 100%;
                            }

                            .btn-submit:hover {
                                transform: translateY(-3px);
                                box-shadow: 0 10px 25px rgba(23, 74, 124, 0.3);
                                color: white;
                            }

                            .btn-submit:disabled {
                                background: #6b7280;
                                cursor: not-allowed;
                                transform: none;
                                box-shadow: none;
                            }

                            .form-label {
                                font-weight: 600;
                                color: #374151;
                                margin-bottom: 8px;
                            }

                            .service-card {
                                background: white;
                                border-radius: 20px;
                                padding: 30px;
                                border: 1px solid #e5e7eb;
                            }

                            .visa-card {
                                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 15px;
                                border: 2px solid transparent;
                                transition: all 0.3s ease;
                            }

                            .visa-card:hover {
                                border-color: #174A7C;
                                transform: translateY(-2px);
                            }

                            .visa-card h6 {
                                color: #1f2937;
                                margin-bottom: 8px;
                            }

                            .visa-card p {
                                color: #6b7280;
                                margin-bottom: 0;
                            }

                            .price-badge {
                                background: linear-gradient(135deg, #B89C5A 0%, #174A7C 100%);
                                color: white;
                                padding: 8px 16px;
                                border-radius: 20px;
                                font-weight: 600;
                                font-size: 14px;
                                display: inline-block;
                                margin-top: 8px;
                            }

                            .country-grid {
                                display: grid;
                                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                                gap: 10px;
                                margin-top: 15px;
                            }

                            .country-item {
                                background: white;
                                padding: 10px;
                                border-radius: 10px;
                                text-align: center;
                                border: 2px solid #e5e7eb;
                                transition: all 0.3s ease;
                                font-size: 14px;
                            }

                            .country-item:hover {
                                border-color: #174A7C;
                                transform: translateY(-2px);
                            }

                            .region-section {
                                background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 20px;
                                border-left: 4px solid #f59e0b;
                            }

                            .region-section h5 {
                                color: #92400e;
                                margin-bottom: 15px;
                            }
                        </style>

                        <form action="{{ route('visa.store') }}" method="POST" id="visaForm">
                            @csrf
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">الاسم الكامل <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" required
                                            placeholder="أدخل الاسم الكامل">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">رقم الهاتف <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}" required
                                            placeholder="رقم الهاتف مثال: 01288000245">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">البريد الإلكتروني <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" required
                                            placeholder="البريد الإلكتروني">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nationality" class="form-label">الجنسية <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('nationality') is-invalid @enderror" id="nationality"
                                            name="nationality" value="{{ old('nationality') }}" required
                                            placeholder="الجنسية">
                                        @error('nationality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">الدولة المطلوبة <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('country') is-invalid @enderror" id="country"
                                            name="country" required>
                                            <option value="">اختر الدولة</option>
                                            <optgroup label="الدول العربية">
                                                <option value="السعودية"
                                                    {{ old('country') == 'السعودية' ? 'selected' : '' }}>السعودية</option>
                                                <option value="الإمارات"
                                                    {{ old('country') == 'الإمارات' ? 'selected' : '' }}>الإمارات</option>
                                                <option value="قطر" {{ old('country') == 'قطر' ? 'selected' : '' }}>قطر
                                                </option>
                                                <option value="البحرين"
                                                    {{ old('country') == 'البحرين' ? 'selected' : '' }}>البحرين</option>
                                                <option value="عُمان" {{ old('country') == 'عُمان' ? 'selected' : '' }}>
                                                    عُمان</option>
                                                <option value="المغرب" {{ old('country') == 'المغرب' ? 'selected' : '' }}>
                                                    المغرب</option>
                                                <option value="تونس" {{ old('country') == 'تونس' ? 'selected' : '' }}>
                                                    تونس</option>
                                                <option value="الجزائر"
                                                    {{ old('country') == 'الجزائر' ? 'selected' : '' }}>الجزائر</option>
                                            </optgroup>
                                            <optgroup label="دول أوروبا">
                                                <option value="إنجلترا"
                                                    {{ old('country') == 'إنجلترا' ? 'selected' : '' }}>إنجلترا</option>
                                                <option value="بلغاريا"
                                                    {{ old('country') == 'بلغاريا' ? 'selected' : '' }}>بلغاريا</option>
                                                <option value="أيرلندا"
                                                    {{ old('country') == 'أيرلندا' ? 'selected' : '' }}>أيرلندا</option>
                                                <option value="روسيا" {{ old('country') == 'روسيا' ? 'selected' : '' }}>
                                                    روسيا</option>
                                                <option value="دول شنغن"
                                                    {{ old('country') == 'دول شنغن' ? 'selected' : '' }}>دول شنغن</option>
                                            </optgroup>
                                            <optgroup label="دول آسيا">
                                                <option value="الصين" {{ old('country') == 'الصين' ? 'selected' : '' }}>
                                                    الصين</option>
                                                <option value="اليابان"
                                                    {{ old('country') == 'اليابان' ? 'selected' : '' }}>اليابان</option>
                                                <option value="تركيا" {{ old('country') == 'تركيا' ? 'selected' : '' }}>
                                                    تركيا</option>
                                                <option value="سنغافورة"
                                                    {{ old('country') == 'سنغافورة' ? 'selected' : '' }}>سنغافورة</option>
                                                <option value="تايلاند"
                                                    {{ old('country') == 'تايلاند' ? 'selected' : '' }}>تايلاند</option>
                                                <option value="أرمينيا"
                                                    {{ old('country') == 'أرمينيا' ? 'selected' : '' }}>أرمينيا</option>
                                            </optgroup>
                                            <optgroup label="دول أمريكا">
                                                <option value="الولايات المتحدة"
                                                    {{ old('country') == 'الولايات المتحدة' ? 'selected' : '' }}>الولايات
                                                    المتحدة</option>
                                                <option value="كندا" {{ old('country') == 'كندا' ? 'selected' : '' }}>
                                                    كندا</option>
                                                <option value="البرازيل"
                                                    {{ old('country') == 'البرازيل' ? 'selected' : '' }}>البرازيل</option>
                                                <option value="كولومبيا"
                                                    {{ old('country') == 'كولومبيا' ? 'selected' : '' }}>كولومبيا</option>
                                            </optgroup>
                                            <optgroup label="دول أفريقيا">
                                                <option value="جنوب أفريقيا"
                                                    {{ old('country') == 'جنوب أفريقيا' ? 'selected' : '' }}>جنوب أفريقيا
                                                </option>
                                                <option value="كينيا" {{ old('country') == 'كينيا' ? 'selected' : '' }}>
                                                    كينيا</option>
                                                <option value="تنزانيا"
                                                    {{ old('country') == 'تنزانيا' ? 'selected' : '' }}>تنزانيا</option>
                                                <option value="أوغندا" {{ old('country') == 'أوغندا' ? 'selected' : '' }}>
                                                    أوغندا</option>
                                                <option value="غانا" {{ old('country') == 'غانا' ? 'selected' : '' }}>
                                                    غانا</option>
                                            </optgroup>
                                            <optgroup label="دول أخرى">
                                                <option value="أستراليا"
                                                    {{ old('country') == 'أستراليا' ? 'selected' : '' }}>أستراليا</option>
                                            </optgroup>
                                        </select>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="visa_type" class="form-label">نوع التأشيرة <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('visa_type') is-invalid @enderror"
                                            id="visa_type" name="visa_type" required>
                                            <option value="">اختر نوع التأشيرة</option>
                                            <option value="سياحية" {{ old('visa_type') == 'سياحية' ? 'selected' : '' }}>
                                                سياحية</option>
                                            <option value="عمل" {{ old('visa_type') == 'عمل' ? 'selected' : '' }}>عمل
                                            </option>
                                            <option value="دراسة" {{ old('visa_type') == 'دراسة' ? 'selected' : '' }}>
                                                دراسة</option>
                                            <option value="زيارة عائلية"
                                                {{ old('visa_type') == 'زيارة عائلية' ? 'selected' : '' }}>زيارة عائلية
                                            </option>
                                            <option value="علاج" {{ old('visa_type') == 'علاج' ? 'selected' : '' }}>علاج
                                            </option>
                                            <option value="ترانزيت" {{ old('visa_type') == 'ترانزيت' ? 'selected' : '' }}>
                                                ترانزيت</option>
                                        </select>
                                        @error('visa_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="travel_date" class="form-label">تاريخ السفر المطلوب <span
                                                class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('travel_date') is-invalid @enderror"
                                            id="travel_date" name="travel_date" value="{{ old('travel_date') }}"
                                            required>
                                        @error('travel_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="passport_number" class="form-label">رقم جواز السفر <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('passport_number') is-invalid @enderror"
                                            id="passport_number" name="passport_number"
                                            value="{{ old('passport_number') }}" required placeholder="رقم جواز السفر">
                                        @error('passport_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="passport_expiry" class="form-label">تاريخ انتهاء جواز السفر <span
                                            class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control @error('passport_expiry') is-invalid @enderror"
                                        id="passport_expiry" name="passport_expiry" value="{{ old('passport_expiry') }}"
                                        required>
                                    @error('passport_expiry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="message" class="form-label">ملاحظات إضافية</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4"
                                        placeholder="أي معلومات إضافية تريد إضافتها...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>إرسال طلب التأشيرة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">أنواع التأشيرات</h4>

                        <div class="visa-card">
                            <h6><i class="fas fa-plane text-primary me-2"></i>تأشيرات سياحية</h6>
                            <p>معالجة سريعة وضمان الحصول</p>
                            <div class="price-badge">يبدأ من 500 جنيه</div>
                        </div>

                        <div class="visa-card">
                            <h6><i class="fas fa-briefcase text-primary me-2"></i>تأشيرات عمل</h6>
                            <p>معالجة احترافية وضمان النجاح</p>
                            <div class="price-badge">يبدأ من 1000 جنيه</div>
                        </div>

                        <div class="visa-card">
                            <h6><i class="fas fa-graduation-cap text-primary me-2"></i>تأشيرات دراسة</h6>
                            <p>استشارة مجانية ومساعدة في القبول</p>
                            <div class="price-badge">يبدأ من 800 جنيه</div>
                        </div>

                        <div class="visa-card">
                            <h6><i class="fas fa-heart text-primary me-2"></i>زيارة عائلية</h6>
                            <p>معالجة سريعة ودعم عائلي</p>
                            <div class="price-badge">يبدأ من 600 جنيه</div>
                        </div>
                    </div>

                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">الدول المتاحة</h4>

                        <div class="region-section">
                            <h5><i class="fas fa-flag text-warning me-2"></i>الدول العربية</h5>
                            <div class="country-grid">
                                <div class="country-item">السعودية</div>
                                <div class="country-item">الإمارات</div>
                                <div class="country-item">قطر</div>
                                <div class="country-item">البحرين</div>
                                <div class="country-item">عُمان</div>
                                <div class="country-item">المغرب</div>
                            </div>
                        </div>

                        <div class="region-section">
                            <h5><i class="fas fa-euro-sign text-warning me-2"></i>دول أوروبا</h5>
                            <div class="country-grid">
                                <div class="country-item">إنجلترا</div>
                                <div class="country-item">بلغاريا</div>
                                <div class="country-item">أيرلندا</div>
                                <div class="country-item">روسيا</div>
                                <div class="country-item">شنغن</div>
                            </div>
                        </div>

                        <div class="region-section">
                            <h5><i class="fas fa-dragon text-warning me-2"></i>دول آسيا</h5>
                            <div class="country-grid">
                                <div class="country-item">الصين</div>
                                <div class="country-item">اليابان</div>
                                <div class="country-item">تركيا</div>
                                <div class="country-item">سنغافورة</div>
                                <div class="country-item">تايلاند</div>
                            </div>
                        </div>
                    </div>

                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">مميزات الخدمة</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سرعة في الإنجاز</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ضمان الحصول</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>أسعار منافسة</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>دعم 24/7</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>متابعة مستمرة</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>استشارة مجانية</li>
                        </ul>
                    </div>

                    <div class="service-card shadow-lg" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">المستندات المطلوبة</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>جواز سفر ساري المفعول</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>صور شخصية حديثة</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>استمارة طلب التأشيرة</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>إثبات الحجز الفندقي</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>حجز تذكرة الطيران</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>كشف حساب بنكي</li>
                        </ul>

                        <div class="alert alert-warning mt-3">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>ملاحظة مهمة:</h6>
                            <p class="mb-0">يجب أن يكون جواز السفر صالح لمدة 6 أشهر على الأقل من تاريخ السفر المطلوب.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // تحقق من رقم الهاتف
        const phone = document.getElementById("phone");
        let phoneValid = false;

        function validatePhone(phoneRegex) {
            phoneValid = phoneRegex.test(phone.value);
            if (phoneValid) {
                phone.style.borderColor = "#10b981";
            } else {
                phone.style.borderColor = "#ef4444";
            }
        }

        phone.addEventListener('input', function() {
            const phoneRegex = /^0(1[0-2,5])\d{8}$/;
            validatePhone(phoneRegex);
        });

        // تحقق من البريد الإلكتروني
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('input', function() {
            if (emailInput.value.trim() !== "") {
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (emailRegex.test(emailInput.value)) {
                    emailInput.style.borderColor = "#10b981";
                } else {
                    emailInput.style.borderColor = "#ef4444";
                }
            } else {
                emailInput.style.borderColor = "#e5e7eb";
            }
        });

        // تحقق من صحة النموذج قبل الإرسال
        const form = document.getElementById('visaForm');
        form.onsubmit = function(e) {
            const phoneRegex = /^0(1[0-2,5])\d{8}$/;
            if (!phoneRegex.test(phone.value)) {
                e.preventDefault();
                alert("من فضلك ادخل رقم الهاتف بشكل صحيح");
                return false;
            }

            if (emailInput.value.trim() !== "") {
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailRegex.test(emailInput.value)) {
                    e.preventDefault();
                    alert("من فضلك أدخل البريد الإلكتروني بشكل صحيح.");
                    return false;
                }
            }

            // إذا كانت جميع البيانات صحيحة، اسمح بالإرسال
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإرسال...';
        };
    </script>
@endsection
