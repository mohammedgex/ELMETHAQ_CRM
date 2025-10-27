@extends('layouts.app')

@section('title', 'توثيقات الخارجية المصرية - الميثاق')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" style="padding: 60px 0; background: linear-gradient(135deg, #f8fafc 60%, #2563eb 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <img src="{{ asset('images/logo-methaq.png') }}" alt="الميثاق Logo"
                        style="height: 80px; width: auto; background: #fff; border-radius: 18px; padding: 8px; border: 2px solid #2563eb; box-shadow: 0 4px 16px rgba(37,99,235,0.10); margin-bottom: 18px;">
                    <h2 class="display-5 fw-bold mb-3" style="color:#2563eb;">توثيقات الخارجية المصرية</h2>
                    <p class="lead" style="color:#1e293b;">في الميثاق نساعدك في توثيقات الخارجية التي تقدمها وزارة
                        الخارجية
                        المصرية وتشمل توثيقات المستندات الرسمية مثل شهادات الميلاد والوفاة والشهادات الدراسية وشهادات الزواج
                        والطلاق والجوازات والوثائق الأخرى التي تحتاج إلى توثيق رسمي.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-lg-5">
                    <div class="service-card shadow-sm mb-4" style="height: auto; border-right: 4px solid #2563eb;">
                        <h4 class="mb-3 text-primary"><i class="fas fa-stamp me-2"></i>قيمة التوثيق</h4>
                        <ul class="list-unstyled mb-3">
                            <li>الخارجية: 400 جنيه</li>
                            <li>الخارجية توكيلات: 620 جنيه</li>
                            <li>مستخرج سجل تجاري: 650 جنيه</li>
                            <li>توثيق سجل تجاري (خارجية تجارية): 950 جنيه</li>
                            <li>توثيق سجل تجاري من الغرفة التجارية: 800 جنيه</li>
                            <li>توثيق وختم امديست: 7000 جنيه</li>
                            <li>توثيق الأمين العام لجامعة القاهرة: 400 جنيه</li>
                            <li>توثيق الأمين العام لجامعة عين شمس: 700 جنيه</li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><strong>مدة الاستخراج:</strong> 48 ساعة عمل</li>
                            <li><strong>فترة الصلاحية:</strong> سنة للختم</li>
                        </ul>
                    </div>
                    <div class="service-card shadow-sm" style="height: auto; border-right: 4px solid #f59e0b;">
                        <h5 class="mb-3 text-primary"><i class="fas fa-file-alt me-2"></i>المستندات المطلوبة</h5>
                        <ol class="mb-0">
                            <li>أصل المستند المراد توثيقه في التوثيقات الخارجية</li>
                        </ol>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="service-card h-100 shadow-sm" style="border-left: 4px solid #2563eb;">
                        <h3 class="mb-4 text-primary"><i class="fas fa-edit me-2"></i>سجل طلبك الآن</h3>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('foreign.store') }}" novalidate>
                            @csrf
                            <div style="display: flex; flex-direction: column; gap: 15px;">
                                <select id="type" class="form-select type" name="document_type" required>
                                    <option value="" disabled selected>أختر نوع التوثيق</option>
                                    <option value="امين عام ج.القاهرة">امين عام ج.القاهرة</option>
                                    <option value="امين عام ج.عين شمس">امين عام ج.عين شمس</option>
                                    <option value="خارجيه تجاري">خارجيه تجاري</option>
                                    <option value="خارجيه توكيلات">خارجيه توكيلات</option>
                                    <option value="خارجيه عادي">خارجيه عادي</option>
                                    <option value="غرفة تجارية">غرفة تجارية</option>
                                </select>
                                <input type="text" id="country" name="country" class="form-control" required
                                    placeholder="الدولة المطلوبة للتوثيق (مثال: السعودية، الإمارات)">
                                <input type="text" id="fullname" name="name" class="form-control"
                                    placeholder="الاسم بالكامل" required>
                                <select name="country_code1" id="country_code1" class="form-select" required>
                                    <option value="" selected>أختر دولة الاقامة</option>
                                    <option value="مصر">مصر</option>
                                    <option value="السعودية">السعودية</option>
                                    <option value="الامارات">الامارات</option>
                                </select>
                                <div class="input-container position-relative">
                                    <span class="check-mark position-absolute"
                                        style="left:10px;top:50%;transform:translateY(-50%);display:none;">✅</span>
                                    <input type="tel" id="mobile" name="phone" minlength="11" maxlength="14"
                                        class="form-control" placeholder="رقم الموبايل مثال: 01288000245"
                                        style="direction: rtl; padding-left: 32px;" required>
                                </div>
                                <input type="tel" id="whatsapp" name="whatsapp" class="form-control"
                                    placeholder="رقم الواتساب" minlength="11" style="direction: rtl;">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="البريد الالكتروني">
                                <input type="text" id="address" name="address" class="form-control" required
                                    placeholder="عنوان الشارع/الحي">
                                <select id="city" name="city" class="form-select" required>
                                    <option value="" disabled selected>أختر المحافظة</option>
                                    <option value="القاهرة">القاهرة</option>
                                    <option value="الجيزة">الجيزة</option>
                                    <option value="الإسكندرية">الإسكندرية</option>
                                    <option value="الدقهلية">الدقهلية</option>
                                    <option value="البحر الأحمر">البحر الأحمر</option>
                                    <option value="البحيرة">البحيرة</option>
                                    <option value="الفيوم">الفيوم</option>
                                    <option value="الغربية">الغربية</option>
                                    <option value="الإسماعيلية">الإسماعيلية</option>
                                    <option value="المنوفية">المنوفية</option>
                                    <option value="المنيا">المنيا</option>
                                    <option value="القليوبية">القليوبية</option>
                                    <option value="الوادي الجديد">الوادي الجديد</option>
                                    <option value="السويس">السويس</option>
                                    <option value="أسوان">أسوان</option>
                                    <option value="أسيوط">أسيوط</option>
                                    <option value="بني سويف">بني سويف</option>
                                    <option value="بورسعيد">بورسعيد</option>
                                    <option value="دمياط">دمياط</option>
                                    <option value="الشرقية">الشرقية</option>
                                    <option value="جنوب سيناء">جنوب سيناء</option>
                                    <option value="كفر الشيخ">كفر الشيخ</option>
                                    <option value="مطروح">مطروح</option>
                                    <option value="الأقصر">الأقصر</option>
                                    <option value="قنا">قنا</option>
                                    <option value="شمال سيناء">شمال سيناء</option>
                                    <option value="سوهاج">سوهاج</option>
                                    <option value="مقيم خارج مصر">مقيم خارج مصر</option>
                                </select>
                                <label for="call_time" class="form-label">أختر التوقيت المناسب للتواصل معك</label>
                                <input type="time" id="call_time" name="call_time" class="form-control">
                                <button type="submit" id="submitBtnP1" class="btn btn-primary btn-lg w-100 mt-2"
                                    style="background: linear-gradient(90deg, #2563eb 60%, #f59e0b 100%); border: none; font-weight:700; letter-spacing:1px;">تأكيد
                                    الطلب</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const countryCode = document.getElementById('country_code1');
        const mobile = document.getElementById("mobile");
        const checkMark = document.querySelector(".check-mark");
        let testRes = false;

        countryCode.onchange = function() {
            let phoneRegex;
            if (countryCode.value === "مصر") {
                mobile.placeholder = "رقم الموبايل مثال: 01288000245";
                phoneRegex = /^0(1[0-2,5])\d{8}$/;
            } else if (countryCode.value === "السعودية") {
                mobile.placeholder = "رقم الموبايل مثال: 00966512345678";
                phoneRegex = /^(00966)(5\d{8})$/;
            } else if (countryCode.value === "الامارات") {
                mobile.placeholder = "رقم الموبايل مثال: 00971512345678";
                phoneRegex = /^(00971)?(5[0-9])\d{7}$/;
            }
            mobile.addEventListener('input', function() {
                testRes = phoneRegex.test(mobile.value);
                mobile.style.borderColor = testRes ? "green" : "red";
                checkMark.style.display = testRes ? "flex" : "none";
            });
        };

        const emailInput = document.getElementById('email');
        emailInput.addEventListener('input', function() {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            emailInput.style.borderColor = (emailInput.value.trim() === "" || emailRegex.test(emailInput.value)) ?
                "green" : "red";
        });

        // معالجة إرسال النموذج
        document.querySelector('form').onsubmit = function(event) {
            const submitBtnP1 = document.getElementById('submitBtnP1');

            // التحقق من البريد الإلكتروني إذا تم إدخاله
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (emailInput.value.trim() !== "" && !emailRegex.test(emailInput.value)) {
                event.preventDefault();
                alert("من فضلك أدخل البريد الإلكتروني بشكل صحيح.");
                return false;
            }

            // إذا كانت جميع البيانات صحيحة، اسمح بالإرسال
            submitBtnP1.disabled = true;
            submitBtnP1.innerText = "جاري الإرسال...";
        };
    </script>
@endsection
