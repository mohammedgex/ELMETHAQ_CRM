@extends('layouts.app')

@section('title', 'السفارات والقنصليات - ميثاق')

@section('content')
    <!-- Embassy Hero Section -->
    <section class="hero-section" style="padding: 80px 0; background: linear-gradient(135deg, #174A7C 0%, #B89C5A 100%);">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4 text-white">خدمات السفارات والقنصليات</h1>
                    <p class="lead text-white">توثيق وتصديق المستندات والوثائق الرسمية من جميع السفارات والقنصليات</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Embassy Services Section -->
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
                                توفر ميثاق خدمة توثيق السفارات والقنصليات لتصديق المستندات والوثائق الرسمية والشخصية للأفراد
                                الذين يرغبون في السفر أو العمل أو الدراسة في الخارج. تتميز الخدمة بالسرعة والفعالية
                                والمصداقية.
                            </p>
                        </div>

                        <!-- نموذج السفارات -->
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

                            .embassy-card {
                                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 15px;
                                border: 2px solid transparent;
                                transition: all 0.3s ease;
                            }

                            .embassy-card:hover {
                                border-color: #174A7C;
                                transform: translateY(-2px);
                            }

                            .embassy-card h6 {
                                color: #1f2937;
                                margin-bottom: 8px;
                            }

                            .embassy-card p {
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
                        </style>

                        <form method="POST" action="{{ route('embassy.store') }}" id="embassyForm" novalidate>
                            @csrf

                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div>
                                    <label for="service_type" class="form-label">اختر السفارة</label>
                                    <select id="service_type" name="service_type" class="form-select" required>
                                        <option value="" disabled selected>اختر السفارة</option>
                                        <option value="سفارة الامارات">سفارة الامارات</option>
                                        <option value="سفارة البحرين">سفارة البحرين</option>
                                        <option value="سفارة السعودية">سفارة السعودية</option>
                                        <option value="سفارة الكويت">سفارة الكويت</option>
                                        <option value="سفارة عمان">سفارة عمان</option>
                                        <option value="سفارة قطر">سفارة قطر</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="country" class="form-label">الدولة المطلوبة للتوثيق</label>
                                    <input type="text" id="country" name="country" class="form-control" required
                                        placeholder="مثال: السعودية، الإمارات">
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
                        <h4 class="mb-4 text-center text-primary">أسعار التوثيق</h4>

                        <div class="embassy-card">
                            <h6><i class="fas fa-flag text-primary me-2"></i>سفارة السعودية</h6>
                            <p>توثيق شهادات سفارة سعودية</p>
                            <div class="price-tag">1400 جنيه</div>
                        </div>

                        <div class="embassy-card">
                            <h6><i class="fas fa-flag text-primary me-2"></i>سفارة الإمارات</h6>
                            <p>توثيق سفارة الإمارات</p>
                            <div class="price-tag">7500 جنيه</div>
                        </div>

                        <div class="embassy-card">
                            <h6><i class="fas fa-flag text-primary me-2"></i>سفارة قطر</h6>
                            <p>توثيق سفارة قطر</p>
                            <div class="price-tag">2500 جنيه</div>
                        </div>

                        <div class="embassy-card">
                            <h6><i class="fas fa-flag text-primary me-2"></i>سفارة عمان</h6>
                            <p>توثيق سفارة عمان عادي</p>
                            <div class="price-tag">5700 جنيه</div>
                        </div>

                        <div class="embassy-card">
                            <h6><i class="fas fa-flag text-primary me-2"></i>سفارة البحرين</h6>
                            <p>توثيق سفارة البحرين مؤهلات</p>
                            <div class="price-tag">3000 جنيه</div>
                        </div>

                        <div class="embassy-card">
                            <h6><i class="fas fa-flag text-primary me-2"></i>ملحق ثقافي سعودية</h6>
                            <p>توثيق ملحق ثقافي سعودية</p>
                            <div class="price-tag">2500 جنيه</div>
                        </div>
                    </div>

                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">السفارات المتاحة</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سفارة الإمارات</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سفارة السعودية</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سفارة الأردن</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سفارة قطر</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سفارة عمان</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سفارة البحرين</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>سفارة الكويت</li>
                        </ul>
                        <p class="text-muted mt-3"><strong>مدة الاستخراج:</strong> حسب نوع الخدمة</p>
                    </div>

                    <div class="service-card shadow-lg" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">المستندات المطلوبة</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>أصل الورقة أو الشهادة المراد
                                توثيقها</li>
                        </ul>

                        <div class="alert alert-warning mt-3">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>مميزات الخدمة:</h6>
                            <p class="mb-0">تتميز خدمة توثيق السفارات والقنصليات بالسرعة والفعالية والمصداقية، حيث يتم
                                توفير هذه الخدمة من قبل موظفين مدربين وذوي خبرة في التعامل مع المستندات الرسمية والشخصية.
                            </p>
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
        const form = document.getElementById('embassyForm');
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
