@extends('layouts.app')

@section('title', 'جواز السفر - الميثاق')

@section('content')
    <!-- Passport Hero Section -->
    <section class="hero-section" style="padding: 80px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-4 text-white">خدمات جواز السفر</h1>
                    <p class="lead text-white">إصدار وتجديد جوازات السفر بجميع أنواعها بأسعار منافسة</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Passport Services Section -->
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
                            <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>تنويه مهم:</h5>
                            <p class="mb-0">
                                يتم استلام جواز السفر من خلال مالكه فقط، للتأكد من شخصية مالك الجواز طبقًا لتعليمات الدولة
                                المصرية.
                                <br>
                                <strong>في حالة اختيار جواز سفر VIP يتم استلام جواز السفر من خلالنا عن طريق عمل توكيل
                                    خاص.</strong>
                            </p>
                        </div>

                        <!-- نموذج جوازات السفر -->
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

                            .passport-type-card {
                                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                                border-radius: 15px;
                                padding: 20px;
                                margin-bottom: 15px;
                                border: 2px solid transparent;
                                transition: all 0.3s ease;
                            }

                            .passport-type-card:hover {
                                border-color: #667eea;
                                transform: translateY(-2px);
                            }

                            .passport-type-card h6 {
                                color: #1f2937;
                                margin-bottom: 8px;
                            }

                            .passport-type-card p {
                                color: #6b7280;
                                margin-bottom: 0;
                            }
                        </style>

                        <form id="passportForm1" method="POST" action="{{ route('passport.store') }}" novalidate="">
                            @csrf
                            <input type="hidden" name="Source" id="Source" value="Website">
                            <input type="hidden" name="التصنيف" id="categ" required="" value="خدمات حكومية">
                            <input type="hidden" name="الخدمة" id="service" required="" value="جوازات">

                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div>
                                    <label for="type" class="form-label">نوع الجواز</label>
                                    <select id="type" class="form-select" name="type" required="">
                                        <option value="" disabled="" selected="">اختر نوع الجواز</option>
                                        <option value="توكيل VIP">توكيل VIP</option>
                                        <option value="فوري VIP">فوري VIP</option>
                                        <option value="عاجل">عاجل</option>
                                        <option value="عادي">عادي</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="fullname" class="form-label">الاسم بالكامل</label>
                                    <input type="text" id="fullname" name="name" class="form-control"
                                        placeholder="أدخل الاسم بالكامل" required="">
                                </div>

                                <div>
                                    <label for="country_code1" class="form-label">دولة الإقامة</label>
                                    <select name="country_code1" id="country_code1" class="form-select" required="">
                                        <option value="" selected="">اختر دولة الإقامة</option>
                                        <option value="مصر">مصر</option>
                                        <option value="السعودية">السعودية</option>
                                        <option value="الامارات">الإمارات</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="mobile" class="form-label">رقم الهاتف</label>
                                    <input type="tel" id="mobile" name="phone" class="form-control" minlength="11"
                                        placeholder="أدخل رقم الهاتف" required="">
                                </div>

                                <div>
                                    <label for="email" class="form-label">البريد الإلكتروني (اختياري)</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="أدخل البريد الإلكتروني">
                                </div>

                                <div>
                                    <label for="city" class="form-label">المحافظة</label>
                                    <select id="city" name="city" class="form-select" required="">
                                        <option value="" disabled selected>اختر المحافظة</option>
                                        <option value="القاهرة">القاهرة</option>
                                        <option value="الجيزة">الجيزة</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="call_time" class="form-label">وقت التواصل المفضل</label>
                                    <input type="time" id="call_time" name="call_time" class="form-control">
                                </div>

                                <button type="submit" id="submitBtnP1" class="btn btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>إرسال الطلب
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="service-card shadow-lg mb-4" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">أنواع الجوازات</h4>

                        <div class="passport-type-card">
                            <h6><i class="fas fa-crown text-warning me-2"></i>توكيل VIP</h6>
                            <p>خدمة VIP مع توكيل خاص لاستلام الجواز</p>
                        </div>

                        <div class="passport-type-card">
                            <h6><i class="fas fa-star text-warning me-2"></i>فوري VIP</h6>
                            <p>إصدار فوري مع خدمة VIP</p>
                        </div>

                        <div class="passport-type-card">
                            <h6><i class="fas fa-clock text-primary me-2"></i>عاجل</h6>
                            <p>إصدار عاجل خلال فترة قصيرة</p>
                        </div>

                        <div class="passport-type-card">
                            <h6><i class="fas fa-file-alt text-success me-2"></i>عادي</h6>
                            <p>إصدار عادي بالوقت المحدد</p>
                        </div>
                    </div>

                    <div class="service-card shadow-lg" style="height: auto;">
                        <h4 class="mb-4 text-center text-primary">المستندات المطلوبة</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>بطاقة الرقم القومي سارية</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>صور شخصية حديثة (4×6)</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>جواز السفر القديم (إن وجد)
                            </li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>إيصال دفع الرسوم</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>شهادة الميلاد (للمرة الأولى)
                            </li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>شهادة التجنيد (للذكور)</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>موافقة الأب (للأقل من 21 سنة)
                            </li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>إقرار بالمسؤولية الجنائية
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script>
        // معالجة إرسال النموذج
        document.getElementById('passportForm1').onsubmit = function(event) {
            const submitBtnP1 = document.getElementById('submitBtnP1');
            const city = document.getElementById('city').value;

            // التحقق من المحافظة
            if (city !== "القاهرة" && city !== "الجيزة") {
                event.preventDefault();
                alert("نعتذر، لا نقدم خدمات جوازات السفر إلا في محافظات القاهرة والجيزة.");
                return false;
            }

            // التحقق من البريد الإلكتروني إذا تم إدخاله
            const emailInput = document.getElementById('email');
            if (emailInput.value !== "" && !emailInput.checkValidity()) {
                event.preventDefault();
                alert("يرجى إدخال بريد إلكتروني صحيح إذا كنت تريد إدخاله.");
                return false;
            }

            // إذا كانت جميع البيانات صحيحة، اسمح بالإرسال
            submitBtnP1.disabled = true;
            submitBtnP1.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإرسال...';
        };
    </script>
@endsection
