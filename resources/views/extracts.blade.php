@extends('layouts.app')

@section('title', 'المستخرجات الرسمية - ميثاق')

@section('content')
    <!-- Extracts Hero Section -->
    <section class="hero-section" style="padding: 80px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4 text-white">المستخرجات الرسمية</h1>
                    <p class="lead text-white">خدمة استخراج المستخرجات الرسمية من الخدمات الحكومية بكفاءة ودقة وسهولة</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Extracts Services Section -->
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
                                توفر ميثاق خدمة استخراج المستخرجات الرسمية من الخدمات الحكومية بكفاءة ودقة وسهولة، وتتضمن
                                هذه المستندات شهادات الميلاد والوفاة والجوازات والشهادات الدراسية والقيود العائلية والفردية
                                والشهادات والقيوم المترجمة وغيرها من المستندات الرسمية الأخرى.
                            </p>
                        </div>

                        <!-- نموذج المستخرجات -->
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
                                border-color: #667eea;
                                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
                                background-color: #fff;
                            }

                            .btn-submit {
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                                box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
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

                            .extract-card {
                                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 15px;
                                border: 2px solid transparent;
                                transition: all 0.3s ease;
                            }

                            .extract-card:hover {
                                border-color: #667eea;
                                transform: translateY(-2px);
                            }

                            .extract-card h6 {
                                color: #1f2937;
                                margin-bottom: 8px;
                            }

                            .extract-card p {
                                color: #6b7280;
                                margin-bottom: 0;
                            }

                            .price-tag {
                                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                color: white;
                                padding: 8px 16px;
                                border-radius: 20px;
                                font-weight: 600;
                                font-size: 14px;
                                display: inline-block;
                                margin-top: 8px;
                            }

                            .category-section {
                                background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 20px;
                                border-left: 4px solid #f59e0b;
                            }

                            .category-section h5 {
                                color: #92400e;
                                margin-bottom: 15px;
                            }
                        </style>

                        <form method="POST" action="{{ route('extracts.store') }}" id="extractsForm" novalidate>
                            @csrf

                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div>
                                    <label for="extract_type" class="form-label">اختر نوع المستخرج</label>
                                    <select id="extract_type" name="extract_type" class="form-select" required>
                                        <option value="" disabled selected>اختر نوع المستخرج</option>
                                        <option value="سجل تجاري">سجل تجاري</option>
                                        <option value="شهادة زواج">شهادة زواج</option>
                                        <option value="شهادة زواج مترجمة">شهادة زواج مترجمة</option>
                                        <option value="شهادة طلاق">شهادة طلاق</option>
                                        <option value="شهادة طلاق مترجمة">شهادة طلاق مترجمة</option>
                                        <option value="شهادة ميلاد">شهادة ميلاد</option>
                                        <option value="شهادة ميلاد مترجمة">شهادة ميلاد مترجمة</option>
                                        <option value="شهادة وفاة">شهادة وفاة</option>
                                        <option value="شهادة وفاة مترجمة">شهادة وفاة مترجمة</option>
                                        <option value="قيد عائلي">قيد عائلي</option>
                                        <option value="قيد عائلي مترجم">قيد عائلي مترجم</option>
                                        <option value="قيد فردي">قيد فردي</option>
                                        <option value="قيد فردي مترجم">قيد فردي مترجم</option>
                                        <option value="شهادة تحركات">شهادة تحركات</option>
                                        <option value="شهادة تحركات مترجمة">شهادة تحركات مترجمة</option>
                                        <option value="بيان نجاح">بيان نجاح لشهادة الثانوية</option>
                                        <option value="بيان نجاح مترجم">بيان نجاح مترجم لشهادة الثانوية</option>
                                        <option value="بيان نجاح ازهري">بيان نجاح ازهري لشهادة الثانوية</option>
                                        <option value="بيان نجاح ازهري مترجم">بيان نجاح ازهري مترجم لشهادة الثانوية</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="country" class="form-label">الدولة المطلوبة للاستخراج</label>
                                    <input type="text" id="country" name="country" class="form-control" required
                                        placeholder="مثال: مصر، السعودية">
                                </div>

                                <div>
                                    <label for="name" class="form-label">الاسم بالكامل</label>
                                    <input type="text" id="name" name="name" class="form-control" required
                                        placeholder="أدخل الاسم بالكامل">
                                </div>

                                <div>
                                    <label for="phone" class="form-label">رقم الموبايل</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" minlength="11"
                                        maxlength="14" placeholder="رقم الموبايل مثال: 01234567890" required>
                                </div>

                                <div>
                                    <label for="whatsapp" class="form-label">رقم الواتساب (اختياري)</label>
                                    <input type="tel" id="whatsapp" name="whatsapp" class="form-control" minlength="11"
                                        maxlength="14" placeholder="رقم الواتساب">
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
                        <h4 class="mb-4 text-center text-primary">أسعار المستخرجات</h4>

                        <div class="category-section">
                            <h5><i class="fas fa-file-alt text-warning me-2"></i>القيود والشهادات الأساسية</h5>

                            <div class="extract-card">
                                <h6><i class="fas fa-users text-primary me-2"></i>القيد الفردي</h6>
                                <p>قيد فردي عادي</p>
                                <div class="price-tag">700 جنيه</div>
                            </div>

                            <div class="extract-card">
                                <h6><i class="fas fa-users text-primary me-2"></i>القيد العائلي</h6>
                                <p>قيد عائلي شامل</p>
                                <div class="price-tag">700 جنيه</div>
                            </div>

                            <div class="extract-card">
                                <h6><i class="fas fa-file-alt text-primary me-2"></i>شهادات الحالة المدنية</h6>
                                <p>ميلاد/زواج/طلاق/وفاة</p>
                                <div class="price-tag">200 جنيه</div>
                            </div>
                        </div>

                        <div class="category-section">
                            <h5><i class="fas fa-language text-warning me-2"></i>المستخرجات المترجمة</h5>

                            <div class="extract-card">
                                <h6><i class="fas fa-users text-primary me-2"></i>القيد الفردي المترجم</h6>
                                <p>قيد فردي مع ترجمة</p>
                                <div class="price-tag">900 جنيه</div>
                            </div>

                            <div class="extract-card">
                                <h6><i class="fas fa-users text-primary me-2"></i>القيد العائلي المترجم</h6>
                                <p>قيد عائلي مع ترجمة</p>
                                <div class="price-tag">900 جنيه</div>
                            </div>

                            <div class="extract-card">
                                <h6><i class="fas fa-file-alt text-primary me-2"></i>شهادات مترجمة</h6>
                                <p>ميلاد/زواج/طلاق/وفاة مترجمة</p>
                                <div class="price-tag">750 جنيه</div>
                            </div>
                        </div>

                        <div class="category-section">
                            <h5><i class="fas fa-graduation-cap text-warning me-2"></i>الشهادات الدراسية</h5>

                            <div class="extract-card">
                                <h6><i class="fas fa-certificate text-primary me-2"></i>بيان نجاح الثانوية</h6>
                                <p>بيان نجاح لشهادة الثانوية</p>
                                <div class="price-tag">400 جنيه</div>
                            </div>

                            <div class="extract-card">
                                <h6><i class="fas fa-certificate text-primary me-2"></i>بيان نجاح أزهري</h6>
                                <p>بيان نجاح أزهري لشهادة الثانوية</p>
                                <div class="price-tag">500 جنيه</div>
                            </div>
                        </div>
                    </div>

                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">مدة الاستخراج</h4>
                        <div class="text-center">
                            <div class="alert alert-success">
                                <i class="fas fa-clock me-2"></i>
                                <strong>2 – 5 أيام عمل</strong>
                                <br>
                                <small class="text-muted">حسب نوع الخدمة المطلوبة</small>
                            </div>
                        </div>

                        <h5 class="text-primary mb-3">أنواع المستخرجات الرسمية</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>شهادة (ميلاد - وفاة - طلاق -
                                زواج)</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>قيد عائلي</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>قيد فردي</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>شهادة تحركات</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>بيانات النجاح</li>
                        </ul>
                    </div>

                    <div class="service-card shadow-lg" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">المستندات المطلوبة</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>صورة من شهادة الميلاد أو
                                الوفاة أو الطلاق أو الزواج</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>صورة من شهادات الميلاد في
                                حالة القيد</li>
                        </ul>

                        <div class="alert alert-warning mt-3">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>مميزات الخدمة:</h6>
                            <p class="mb-0">نتميز في خدمة استخراج المستخرجات الرسمية بالسرعة والفعالية والمصداقية، حيث
                                يتم توفير هذه الخدمة من قبل موظفين مدربين وذوي خبرة في التعامل مع المستندات الرسمية
                                والشخصية.</p>
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
        const form = document.getElementById('extractsForm');
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
        };
    </script>
@endsection
