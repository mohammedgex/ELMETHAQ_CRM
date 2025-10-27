@extends('layouts.app')

@section('title', 'الترجمة المعتمدة - الميثاق')

@section('content')
    <!-- Translation Hero Section -->
    <section class="hero-section" style="padding: 80px 0; background: linear-gradient(135deg, #174A7C 0%, #B89C5A 100%);">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4 text-white">الترجمة المعتمدة</h1>
                    <p class="lead text-white">خدمة الترجمة المعتمدة بالمصداقية والدقة والموثوقية</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Translation Services Section -->
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
                                تتميز الميثاق في خدمة الترجمة المعتمدة بالمصداقية والدقة والموثوقية، حيث يتم تحويل المستندات
                                بشكل
                                دقيق ومهني وتصديقها بالشكل الرسمي والمناسب من أي لغة إلى أي لغة أخرى وتصديقها بشكل رسمي
                                ومعتمد.
                            </p>
                        </div>

                        <!-- نموذج الترجمة -->
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

                            .translation-card {
                                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 15px;
                                border: 2px solid transparent;
                                transition: all 0.3s ease;
                            }

                            .translation-card:hover {
                                border-color: #174A7C;
                                transform: translateY(-2px);
                            }

                            .translation-card h6 {
                                color: #1f2937;
                                margin-bottom: 8px;
                            }

                            .translation-card p {
                                color: #6b7280;
                                margin-bottom: 0;
                            }

                            .info-badge {
                                background: linear-gradient(135deg, #B89C5A 0%, #174A7C 100%);
                                color: white;
                                padding: 8px 16px;
                                border-radius: 20px;
                                font-weight: 600;
                                font-size: 14px;
                                display: inline-block;
                                margin-top: 8px;
                            }

                            .category-section {
                                background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 20px;
                                border-left: 4px solid #10b981;
                            }

                            .category-section h5 {
                                color: #065f46;
                                margin-bottom: 15px;
                            }

                            .language-grid {
                                display: grid;
                                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                                gap: 10px;
                                margin-top: 15px;
                            }

                            .language-item {
                                background: white;
                                padding: 10px;
                                border-radius: 10px;
                                text-align: center;
                                border: 2px solid #e5e7eb;
                                transition: all 0.3s ease;
                            }

                            .language-item:hover {
                                border-color: #174A7C;
                                transform: translateY(-2px);
                            }
                        </style>

                        <form method="POST" action="{{ route('translation.store') }}" id="translationForm" novalidate>
                            @csrf

                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div>
                                    <label for="translation_type" class="form-label">نوع الترجمة</label>
                                    <select id="translation_type" name="translation_type" class="form-select" required>
                                        <option value="" disabled selected>اختر نوع الترجمة</option>
                                        <option value="ترجمة شهادة ميلاد">ترجمة شهادة ميلاد</option>
                                        <option value="ترجمة شهادة زواج">ترجمة شهادة زواج</option>
                                        <option value="ترجمة شهادة طلاق">ترجمة شهادة طلاق</option>
                                        <option value="ترجمة شهادة وفاة">ترجمة شهادة وفاة</option>
                                        <option value="ترجمة شهادة جامعية">ترجمة شهادة جامعية</option>
                                        <option value="ترجمة شهادة ثانوية">ترجمة شهادة ثانوية</option>
                                        <option value="ترجمة سجل تجاري">ترجمة سجل تجاري</option>
                                        <option value="ترجمة قيد عائلي">ترجمة قيد عائلي</option>
                                        <option value="ترجمة قيد فردي">ترجمة قيد فردي</option>
                                        <option value="ترجمة أخرى">ترجمة أخرى</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="from_language" class="form-label">اللغة الأصلية</label>
                                        <select id="from_language" name="from_language" class="form-select" required>
                                            <option value="" disabled selected>اختر اللغة الأصلية</option>
                                            <option value="العربية">العربية</option>
                                            <option value="الإنجليزية">الإنجليزية</option>
                                            <option value="الفرنسية">الفرنسية</option>
                                            <option value="الألمانية">الألمانية</option>
                                            <option value="الإيطالية">الإيطالية</option>
                                            <option value="الإسبانية">الإسبانية</option>
                                            <option value="الروسية">الروسية</option>
                                            <option value="الصينية">الصينية</option>
                                            <option value="اليابانية">اليابانية</option>
                                            <option value="الكورية">الكورية</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="to_language" class="form-label">اللغة المطلوبة</label>
                                        <select id="to_language" name="to_language" class="form-select" required>
                                            <option value="" disabled selected>اختر اللغة المطلوبة</option>
                                            <option value="العربية">العربية</option>
                                            <option value="الإنجليزية">الإنجليزية</option>
                                            <option value="الفرنسية">الفرنسية</option>
                                            <option value="الألمانية">الألمانية</option>
                                            <option value="الإيطالية">الإيطالية</option>
                                            <option value="الإسبانية">الإسبانية</option>
                                            <option value="الروسية">الروسية</option>
                                            <option value="الصينية">الصينية</option>
                                            <option value="اليابانية">اليابانية</option>
                                            <option value="الكورية">الكورية</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="name" class="form-label">الاسم بالكامل</label>
                                    <input type="text" id="name" name="name" class="form-control" required
                                        placeholder="أدخل الاسم بالكامل">
                                </div>

                                <div>
                                    <label for="phone" class="form-label">رقم الموبايل</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" minlength="11"
                                        maxlength="14" placeholder="رقم الموبايل مثال: 01288000245" required>
                                </div>

                                <div>
                                    <label for="whatsapp" class="form-label">رقم الواتساب (اختياري)</label>
                                    <input type="tel" id="whatsapp" name="whatsapp" class="form-control"
                                        minlength="11" maxlength="14" placeholder="رقم الواتساب">
                                </div>

                                <div>
                                    <label for="email" class="form-label">البريد الإلكتروني (اختياري)</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="البريد الإلكتروني">
                                </div>

                                <div>
                                    <label for="address" class="form-label">عنوان الشارع/الحي</label>
                                    <input type="text" id="address" name="address" class="form-control" required
                                        placeholder="أدخل العنوان">
                                </div>

                                <div>
                                    <label for="city" class="form-label">المحافظة</label>
                                    <select id="city" name="city" class="form-select" required>
                                        <option value="" disabled selected>اختر المحافظة</option>
                                        <option value="القاهرة">القاهرة</option>
                                        <option value="الجيزة">الجيزة</option>
                                        <option value="الإسكندرية">الإسكندرية</option>
                                        <option value="مطروح">مطروح</option>
                                        <option value="شرم الشيخ">شرم الشيخ</option>
                                        <option value="بورسعيد">بورسعيد</option>
                                        <option value="الإسماعيلية">الإسماعيلية</option>
                                        <option value="البحر الأحمر">البحر الأحمر</option>
                                        <option value="السويس">السويس</option>
                                        <option value="شمال سيناء">شمال سيناء</option>
                                        <option value="جنوب سيناء">جنوب سيناء</option>
                                        <option value="القليوبية">القليوبية</option>
                                        <option value="كفر الشيخ">كفر الشيخ</option>
                                        <option value="الشرقية">الشرقية</option>
                                        <option value="الغربية">الغربية</option>
                                        <option value="البحيرة">البحيرة</option>
                                        <option value="أسوان">أسوان</option>
                                        <option value="أسيوط">أسيوط</option>
                                        <option value="بني سويف">بني سويف</option>
                                        <option value="الدقهلية">الدقهلية</option>
                                        <option value="دمياط">دمياط</option>
                                        <option value="الفيوم">الفيوم</option>
                                        <option value="الأقصر">الأقصر</option>
                                        <option value="المنيا">المنيا</option>
                                        <option value="المنوفية">المنوفية</option>
                                        <option value="الوادي الجديد">الوادي الجديد</option>
                                        <option value="قنا">قنا</option>
                                        <option value="سوهاج">سوهاج</option>
                                        <option value="مقيم خارج مصر">مقيم خارج مصر</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="call_time" class="form-label">التوقيت المناسب للتواصل</label>
                                    <input type="time" id="call_time" name="call_time" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>إرسال الطلب
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">معلومات الخدمة</h4>

                        <div class="translation-card">
                            <h6><i class="fas fa-money-bill text-success me-2"></i>قيمة الترجمة</h6>
                            <p>تختلف على حسب لغة الترجمة ونوع المستند المراد ترجمته</p>
                            <div class="info-badge">أسعار تنافسية</div>
                        </div>

                        <div class="translation-card">
                            <h6><i class="fas fa-clock text-primary me-2"></i>مدة الترجمة</h6>
                            <p>2 – 5 أيام عمل</p>
                            <div class="info-badge">سرعة في الإنجاز</div>
                        </div>

                        <div class="translation-card">
                            <h6><i class="fas fa-calendar-check text-info me-2"></i>فترة الصلاحية</h6>
                            <p>5 سنوات من تاريخ الإصدار</p>
                            <div class="info-badge">صلاحية طويلة</div>
                        </div>
                    </div>

                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">اللغات المتاحة</h4>

                        <div class="language-grid">
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>العربية</div>
                            </div>
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>الإنجليزية</div>
                            </div>
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>الفرنسية</div>
                            </div>
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>الألمانية</div>
                            </div>
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>الإيطالية</div>
                            </div>
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>الإسبانية</div>
                            </div>
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>الروسية</div>
                            </div>
                            <div class="language-item">
                                <i class="fas fa-language text-primary mb-2"></i>
                                <div>الصينية</div>
                            </div>
                        </div>
                    </div>

                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">أنواع الترجمات</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة شهادة ميلاد</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة شهادة زواج</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة شهادة طلاق</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة شهادة وفاة</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة شهادة جامعية</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة شهادة ثانوية</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة سجل تجاري</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة قيد عائلي</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ترجمة قيد فردي</li>
                        </ul>
                    </div>

                    <div class="service-card shadow-lg" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">المستندات المطلوبة</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>صورة من الشهادة أو المستند
                                المراد ترجمته</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>الأصول مطلوبة للتصديق</li>
                        </ul>

                        <div class="alert alert-warning mt-3">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>مميزات الخدمة:</h6>
                            <p class="mb-0">نتميز بالدقة والمصداقية في الترجمة، مع ضمان الجودة العالية والتصديق الرسمي من
                                الجهات المعتمدة. جميع الترجمات تتم على يد مترجمين معتمدين وذوي خبرة.</p>
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
        const form = document.getElementById('translationForm');
        form.onsubmit = function(e) {
            const phoneRegex = /^0(1[0-2,5])\d{8}$/;
            if (!phoneRegex.test(phone.value)) {
                e.preventDefault();
                alert("من فضلك ادخل رقم الموبايل بشكل صحيح");
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
