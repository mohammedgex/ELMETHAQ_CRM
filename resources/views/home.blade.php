@extends('layouts.app')

@section('title', 'الميثاق - إلحاق العمالة المصرية بالخارج')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-modern">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 order-2 order-lg-1 hero-content-modern">
                    <h1 class="hero-title-modern creative-hero-title">
                        <span class="typewriter-wrap"><span id="typewriter"></span><span id="typewriter-cursor"></span></span>
                    </h1>
                    <div class="gold-underline"></div>
                    <p class="hero-subtitle-modern">
                        نقدم حلولاً متكاملة لربط الكفاءات المصرية بفرص العمل في الخارج مع ضمان أعلى معايير الجودة والموثوقية
                    </p>
                    <div class="hero-buttons-modern">
                        <a href="#services" class="hero-btn-primary">
                            <i class="fas fa-rocket me-2"></i>
                            ابدأ الآن
                        </a>
                        <a href="#about" class="hero-btn-secondary">
                            <i class="fas fa-play me-2"></i>
                            تعرف علينا
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-6 order-1 order-lg-2">
                    <div class="hero-image-container d-flex flex-column align-items-center justify-content-center">
                        <div class="hero-logo-wrapper text-center">
                            <img src="{{ asset('images/logo-methaq.png') }}" alt="الميثاق Logo" class="hero-logo img-fluid">
                            <div class="hero-logo-glow"></div>
                            <div class="hero-icons-row d-flex justify-content-center mt-3 gap-3">
                                <div class="hero-icon-item text-center">
                                    <i class="fas fa-briefcase fa-2x"></i>
                                    <div class="icon-label">وظائف</div>
                                </div>
                                <div class="hero-icon-item text-center">
                                    <i class="fas fa-passport fa-2x"></i>
                                    <div class="icon-label">جوازات</div>
                                </div>
                                <div class="hero-icon-item text-center">
                                    <i class="fas fa-globe fa-2x"></i>
                                    <div class="icon-label">دول</div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-floating-elements ">
                            <div class="floating-element element-1 position-absolute">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="floating-element element-2 position-absolute">
                                <i class="fas fa-passport"></i>
                            </div>
                            <div class="floating-element element-3 position-absolute">
                                <i class="fas fa-globe"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <style>
        .creative-services-section {
            background: #fff;
            position: relative;
            overflow: hidden;
            padding-bottom: 60px;
        }

        .creative-services-section::before,
        .creative-services-section::after {
            display: none !important;
        }

        .creative-service-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 4px 24px #174A7C11;
            padding: 38px 28px 32px 28px;
            text-align: center;
            position: relative;
            transition: all 0.3s cubic-bezier(.4, 2, .6, 1);
            z-index: 1;
            min-height: 340px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            border: 1.5px solid #f2f2f2;
        }

        .creative-service-card:hover {
            box-shadow: 0 8px 32px #B89C5A44, 0 2px 8px #174A7C22;
            border-color: #B89C5A;
            transform: translateY(-6px) scale(1.025);
        }

        .creative-service-icon {
            width: 80px;
            height: 80px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px auto;
            box-shadow: 0 4px 18px #174A7C11;
            font-size: 2.3rem;
            color: #174A7C;
            border: 2px solid #174A7C33;
            transition: box-shadow 0.3s, color 0.3s, border-color 0.3s;
        }

        .creative-service-card:hover .creative-service-icon {
            color: #B89C5A;
            border-color: #B89C5A;
            box-shadow: 0 8px 24px #B89C5A33;
        }

        .creative-service-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #174A7C;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .creative-service-description {
            color: #174A7C;
            font-size: 1rem;
            margin-bottom: 22px;
            min-height: 48px;
        }

        .creative-service-btn {
            background: #174A7C;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 28px;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 10px #174A7C11;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: auto;
        }

        .creative-service-btn:hover {
            background: #B89C5A;
            color: #fff;
            transform: scale(1.06) translateY(-2px);
            box-shadow: 0 6px 24px #B89C5A33;
        }

        .creative-service-card .golden-line {
            height: 2px;
            width: 40px;
            background: #174A7C;
            margin: 12px auto 18px auto;
            border-radius: 2px;
            transition: background 0.3s;
        }

        .creative-service-card:hover .golden-line {
            background: #B89C5A;
        }

        .services-title-modern,
        .features-title-modern {
            color: #174A7C !important;
            font-size: 2.2rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 1rem;
            background: none !important;
            -webkit-background-clip: unset !important;
            -webkit-text-fill-color: unset !important;
            background-clip: unset !important;
        }

        /* ميديا كويري للشاشات الكبيرة */
        @media (min-width: 1200px) {

            .services-title-modern,
            .features-title-modern {
                font-size: 2.5rem !important;
            }

            .services-subtitle-modern,
            .features-subtitle-modern {
                font-size: 1.3rem !important;
            }

            .creative-service-title,
            .feature-title {
                font-size: 1.4rem !important;
            }

            .creative-service-description,
            .feature-description {
                font-size: 1.1rem !important;
            }
        }

        /* ميديا كويري للشاشات المتوسطة */
        @media (min-width: 768px) and (max-width: 1199px) {

            .services-title-modern,
            .features-title-modern {
                font-size: 2rem !important;
            }

            .services-subtitle-modern,
            .features-subtitle-modern {
                font-size: 1.2rem !important;
            }

            .creative-service-title,
            .feature-title {
                font-size: 1.3rem !important;
            }

            .creative-service-description,
            .feature-description {
                font-size: 1rem !important;
            }
        }

        /* ميديا كويري للتابلت */
        @media (min-width: 576px) and (max-width: 767px) {

            .services-title-modern,
            .features-title-modern {
                font-size: 1.8rem !important;
            }

            .services-subtitle-modern,
            .features-subtitle-modern {
                font-size: 1.1rem !important;
            }

            .creative-service-title,
            .feature-title {
                font-size: 1.2rem !important;
            }

            .creative-service-description,
            .feature-description {
                font-size: 0.95rem !important;
            }
        }

        /* ميديا كويري للهاتف */
        @media (max-width: 575px) {

            .services-title-modern,
            .features-title-modern {
                font-size: 1.5rem !important;
                padding: 0 15px !important;
                line-height: 1.3 !important;
            }

            .services-subtitle-modern,
            .features-subtitle-modern {
                font-size: 1rem !important;
                padding: 0 20px !important;
                line-height: 1.4 !important;
            }

            .creative-service-title,
            .feature-title {
                font-size: 1.1rem !important;
            }

            .creative-service-description,
            .feature-description {
                font-size: 0.9rem !important;
                line-height: 1.5 !important;
            }
        }
    </style>
    <section id="services" class="creative-services-section py-5">
        <div class="container">
            <div class="services-header">
                <h2 class="services-title-modern">خدماتنا لإلحاق العمالة بالخارج</h2>
                <p class="services-subtitle-modern" style="color:#B89C5A;">نقدم مجموعة متكاملة من الخدمات لتسهيل إلحاق
                    العمالة المصرية بالوظائف الخارجية المناسبة</p>
            </div>
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="creative-service-card h-100">
                        <div class="creative-service-icon"><i class="fas fa-briefcase"></i></div>
                        <div class="creative-service-title">فرص عمل بالخارج</div>
                        <div class="creative-service-description">انطلق نحو مستقبلك. وظائف حقيقية في شركات موثوقة حول
                            العالم.</div>
                        <div class="golden-line"></div>
                        <a href="#jobs" class="creative-service-btn"><i class="fas fa-rocket me-2"></i>ابدأ رحلتك
                            المهنية</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="creative-service-card h-100">
                        <div class="creative-service-icon"><i class="fas fa-user-plus"></i></div>
                        <div class="creative-service-title">تسجيل العمالة المصرية</div>
                        <div class="creative-service-description">سجّل اسمك وكن أول من يحصل على أفضل الفرص بالخارج.</div>
                        <div class="golden-line"></div>
                        <a href="#register" class="creative-service-btn"><i class="fas fa-user-edit me-2"></i>سجّل بياناتك
                            الآن</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="creative-service-card h-100">
                        <div class="creative-service-icon"><i class="fas fa-building"></i></div>
                        <div class="creative-service-title">طلبات التوظيف من الشركات</div>
                        <div class="creative-service-description">ابحث عن أفضل الكفاءات المصرية. سرعة، احترافية، نتائج
                            مضمونة.</div>
                        <div class="golden-line"></div>
                        <a href="#companies" class="creative-service-btn"><i class="fas fa-briefcase me-2"></i>أضف طلب
                            شركتك</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="creative-service-card h-100">
                        <div class="creative-service-icon"><i class="fas fa-globe"></i></div>
                        <div class="creative-service-title">الدول المتاحة</div>
                        <div class="creative-service-description">اختر وجهتك بثقة. فرص عمل في أبرز الدول حول العالم.</div>
                        <div class="golden-line"></div>
                        <a href="#countries" class="creative-service-btn"><i class="fas fa-globe me-2"></i>استكشف
                            الوجهات</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="creative-service-card h-100">
                        <div class="creative-service-icon"><i class="fas fa-info-circle"></i></div>
                        <div class="creative-service-title">إرشادات ونصائح</div>
                        <div class="creative-service-description">نصائح ذهبية للنجاح في الخارج. خبرة، قانون، وأمان.</div>
                        <div class="golden-line"></div>
                        <a href="#tips" class="creative-service-btn"><i class="fas fa-lightbulb me-2"></i>اقرأ النصائح
                            الذهبية</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="creative-service-card h-100">
                        <div class="creative-service-icon"><i class="fas fa-headset"></i></div>
                        <div class="creative-service-title">دعم واستشارات</div>
                        <div class="creative-service-description">دعم فوري واستشارات مجانية. معك في كل خطوة نحو النجاح.
                        </div>
                        <div class="golden-line"></div>
                        <a href="#contact" class="creative-service-btn"><i class="fas fa-headset me-2"></i>تواصل مع
                            خبرائنا</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <style>
        .features-section {
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .feature-card-modern {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 4px 24px #174A7C11;
            padding: 38px 28px 32px 28px;
            text-align: center;
            position: relative;
            transition: all 0.3s cubic-bezier(.4, 2, .6, 1);
            z-index: 1;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            border: 1.5px solid #f2f2f2;
        }

        .feature-card-modern:hover {
            box-shadow: 0 8px 32px #B89C5A44, 0 2px 8px #174A7C22;
            border-color: #B89C5A;
            transform: translateY(-6px) scale(1.025);
        }

        .feature-icon-modern {
            width: 80px;
            height: 80px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px auto;
            box-shadow: 0 4px 18px #174A7C11;
            font-size: 2.3rem;
            color: #174A7C;
            border: 2px solid #174A7C33;
            transition: box-shadow 0.3s, color 0.3s, border-color 0.3s;
        }

        .feature-card-modern:hover .feature-icon-modern {
            color: #B89C5A;
            border-color: #B89C5A;
            box-shadow: 0 8px 24px #B89C5A33;
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #174A7C;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .feature-description {
            color: #174A7C;
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* تحسينات إضافية للـ feature cards */
        .feature-card-modern {
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-start !important;
            align-items: center !important;
            text-align: center !important;
        }

        .feature-icon-modern {
            margin-bottom: 1rem !important;
        }

        .feature-title {
            color: #174A7C !important;
            margin-bottom: 0.75rem !important;
        }

        .feature-description {
            color: #174A7C !important;
            flex-grow: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
    </style>
    <section class="features-section py-5">
        <div class="container">
            <div class="features-header text-center">
                <h2 class="features-title-modern">
                    <i class="fas fa-star me-2 me-md-3"></i>
                    لماذا تختار الميثاق لإلحاق العمالة بالخارج؟
                </h2>
                <p class="features-subtitle-modern">
                    نتميز بالجودة والسرعة والأمان لضمان تجربة موثوقة للعمالة المصرية والشركات الخارجية
                </p>
            </div>

            <div class="row g-3 g-md-4">
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="feature-card-modern h-100 d-flex flex-column">
                        <div class="feature-icon-modern mx-auto"
                            style="background: linear-gradient(135deg, #174A7C, #B89C5A); color: #fff;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="feature-title text-center">أمان تام للبيانات</h4>
                        <p class="feature-description text-center flex-grow-1">نحافظ على سرية بياناتك ونستخدم أحدث تقنيات
                            الحماية والتشفير</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="feature-card-modern h-100 d-flex flex-column">
                        <div class="feature-icon-modern mx-auto"
                            style="background: linear-gradient(135deg, #B89C5A, #174A7C); color: #fff;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4 class="feature-title text-center">سرعة في الإجراءات</h4>
                        <p class="feature-description text-center flex-grow-1">ننجز معاملاتك بسرعة وكفاءة عالية لتسهيل
                            سفرك للعمل بالخارج</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="feature-card-modern h-100 d-flex flex-column">
                        <div class="feature-icon-modern mx-auto"
                            style="background: linear-gradient(135deg, #174A7C, #B89C5A); color: #fff;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 class="feature-title text-center">دعم فني واستشارات</h4>
                        <p class="feature-description text-center flex-grow-1">فريق دعم متواجد دائماً لمساعدتك في كل خطوة
                        </p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="feature-card-modern h-100 d-flex flex-column">
                        <div class="feature-icon-modern mx-auto"
                            style="background: linear-gradient(135deg, #B89C5A, #174A7C); color: #fff;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h4 class="feature-title text-center">بدون عمولات زائدة</h4>
                        <p class="feature-description text-center flex-grow-1">نقدم خدماتنا بأفضل الأسعار وبدون أي رسوم
                            خفية</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="feature-card-modern h-100 d-flex flex-column">
                        <div class="feature-icon-modern mx-auto"
                            style="background: linear-gradient(135deg, #174A7C, #B89C5A); color: #fff;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="feature-title text-center">فريق متخصص</h4>
                        <p class="feature-description text-center flex-grow-1">خبراء في مجال التوظيف الدولي وإلحاق العمالة
                            بالخارج</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="feature-card-modern h-100 d-flex flex-column">
                        <div class="feature-icon-modern mx-auto"
                            style="background: linear-gradient(135deg, #B89C5A, #174A7C); color: #fff;">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h4 class="feature-title text-center">خدمات شاملة</h4>
                        <p class="feature-description text-center flex-grow-1">كل ما تحتاجه لإلحاق العمالة المصرية بالخارج
                            في مكان واحد</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <style>
        .cta-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            margin: 2rem 0;
            box-shadow: 0 10px 40px rgba(23, 74, 124, 0.1);
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(184, 156, 90, 0.05) 50%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(100%);
            }
        }

        .cta-content {
            color: #174A7C;
            position: relative;
            z-index: 2;
        }

        /* أيقونة متحركة */
        .cta-icon-wrapper {
            position: relative;
            display: inline-block;
        }

        .cta-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 3rem;
            color: #fff;
            box-shadow: 0 8px 32px rgba(23, 74, 124, 0.3);
            transition: all 0.3s ease;
            animation: float 3s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        .cta-icon:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 40px rgba(184, 156, 90, 0.4);
        }

        .cta-icon-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(184, 156, 90, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.5;
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                opacity: 0.8;
                transform: translate(-50%, -50%) scale(1.1);
            }
        }

        .cta-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #174A7C;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(23, 74, 124, 0.1);
        }

        .cta-subtitle {
            font-size: 1.1rem;
            color: #174A7C;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        /* أزرار محسنة */
        .cta-btn-primary {
            background: linear-gradient(135deg, #174A7C, #1a5a8a);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(23, 74, 124, 0.3);
            position: relative;
            overflow: hidden;
        }

        .cta-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .cta-btn-primary:hover::before {
            left: 100%;
        }

        .cta-btn-primary:hover {
            background: linear-gradient(135deg, #B89C5A, #c4a86a);
            color: #fff;
            box-shadow: 0 12px 35px rgba(184, 156, 90, 0.4);
            transform: translateY(-2px);
        }

        .cta-btn-secondary {
            background: #fff;
            color: #174A7C;
            border: 2px solid #174A7C;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(23, 74, 124, 0.1);
            position: relative;
            overflow: hidden;
        }

        .cta-btn-secondary:hover {
            background: linear-gradient(135deg, #B89C5A, #c4a86a);
            color: #174A7C !important;
            border-color: #B89C5A;
            box-shadow: 0 12px 35px rgba(184, 156, 90, 0.3);
            transform: translateY(-2px);
        }

        /* كروت المميزات الجديدة */
        .cta-feature-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(23, 74, 124, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(23, 74, 124, 0.1);
        }

        .cta-feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(184, 156, 90, 0.2);
            border-color: #B89C5A;
        }

        .cta-feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: #fff;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .cta-feature-card:hover .cta-feature-icon {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(184, 156, 90, 0.4);
        }

        .cta-feature-text {
            color: #174A7C;
            font-weight: 600;
            font-size: 1rem;
            display: block;
            margin-top: 8px;
        }
    </style>
    <section class="cta-section py-5">
        <div class="container">
            <div class="cta-content text-center">
                <!-- أيقونة متحركة -->
                <div class="cta-icon-wrapper mb-4">
                    <div class="cta-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="cta-icon-glow"></div>
                </div>

                <!-- العنوان الرئيسي -->
                <h2 class="cta-title mb-3">هل تبحث عن فرصة عمل بالخارج؟</h2>

                <!-- النص الفرعي -->
                <p class="cta-subtitle mb-4">سجل بياناتك أو تواصل معنا الآن لتحصل على أفضل الفرص مع ضمان المصداقية والسرعة
                </p>

                <!-- الأزرار -->
                <div class="cta-buttons d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5">
                    <a href="#contact" class="cta-btn-primary">
                        <i class="fas fa-phone me-2"></i>
                        تواصل معنا الآن
                    </a>
                    <a href="https://wa.me/201288000245" class="cta-btn-secondary" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>
                        واتساب
                    </a>
                </div>

                <!-- المميزات -->
                <div class="cta-features">
                    <div class="row g-3 g-md-4">
                        <div class="col-12 col-sm-4">
                            <div class="cta-feature-card">
                                <div class="cta-feature-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span class="cta-feature-text">ضمان المصداقية</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="cta-feature-card">
                                <div class="cta-feature-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <span class="cta-feature-text">رد سريع</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="cta-feature-card">
                                <div class="cta-feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <span class="cta-feature-text">حماية بياناتك</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .hero-section-modern {
        background: #fff !important;
        height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 80px;
    }

    .hero-title-modern {
        color: #174A7C !important;
        font-weight: 900 !important;
        font-size: 2.7rem !important;
        line-height: 1.2 !important;
        display: block !important;
        position: relative !important;
        z-index: 2 !important;
        opacity: 1 !important;
        text-shadow: 0 2px 8px #fff8;
        margin-bottom: 18px !important;
        animation: heroFadeIn 1.2s cubic-bezier(.4, 2, .6, 1);
    }

    @keyframes heroFadeIn {
        0% {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .gold-keyword {
        color: #B89C5A !important;
        font-weight: 900;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 8px #fff6;
        padding: 0 2px;
        display: inline-block;
        transition: color 0.3s;
    }

    .gold-keyword:hover {
        color: #174A7C !important;
        background: #B89C5A22;
        border-radius: 6px;
    }

    .gold-underline {
        width: 80px;
        height: 5px;
        background: #B89C5A;
        border-radius: 3px;
        margin: 12px 0 0 0;
        box-shadow: 0 2px 12px #B89C5A44;
        animation: goldLineIn 1.2s 0.5s cubic-bezier(.4, 2, .6, 1) backwards;
    }

    @keyframes goldLineIn {
        0% {
            width: 0;
            opacity: 0;
        }

        100% {
            width: 80px;
            opacity: 1;
        }
    }

    .hero-subtitle-modern {
        color: #174A7C !important;
        font-size: 1.2rem;
        margin-bottom: 28px;
    }

    .hero-btn-primary,
    .hero-btn-secondary {
        background: #174A7C !important;
        color: #fff !important;
        border: none;
        border-radius: 30px;
        padding: 12px 32px;
        font-weight: 700;
        font-size: 1.1rem;
        margin-left: 8px;
        margin-bottom: 8px;
        transition: background 0.3s, color 0.3s;
        box-shadow: 0 2px 10px #174A7C11;
        text-decoration: none;
        display: inline-block;
    }

    .hero-buttons-modern {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .hero-btn-secondary {
        background: #fff !important;
        color: #174A7C !important;
        border: 2px solid #174A7C;
    }

    .hero-btn-primary:hover,
    .hero-btn-secondary:hover {
        background: #B89C5A !important;
        color: #fff !important;
        border-color: #B89C5A !important;
    }

    .hero-logo-wrapper {
        background: #fff !important;
        border-radius: 30px;
        box-shadow: 0 8px 32px #174A7C11;
        padding: 20px;
        border: 3px solid #174A7C22;
        animation: floatYLogo 3.5s ease-in-out infinite;
    }

    @keyframes floatYLogo {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-22px);
        }
    }

    .hero-floating-elements .floating-element {
        background: #fff !important;
        color: #174A7C !important;
        border: 2px solid #174A7C33 !important;
        box-shadow: 0 2px 8px #174A7C11;
        transition: color 0.3s, border-color 0.3s;
    }

    .hero-floating-elements .floating-element:hover {
        background: #B89C5A !important;
        color: #fff !important;
        border-color: #B89C5A !important;
        transition: background 0.3s, color 0.3s, border-color 0.3s;
    }

    .hero-title-modern.creative-hero-title {
        font-size: 2.5rem;
        text-align: center;
        color: #174A7C !important;
        font-weight: bold;
        margin-bottom: 1rem;
        background: none !important;
        -webkit-background-clip: unset !important;
        -webkit-text-fill-color: unset !important;
        background-clip: unset !important;
        word-break: break-word;
        animation: floatY 3.2s ease-in-out infinite;
    }

    .hero-logo-wrapper:hover {
        background: #B89C5A !important;
        transition: background 0.3s;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    #typewriter-cursor {
        display: inline-block;
        width: 2px;
        height: 1em;
        /* width: 0.08em; */
        min-width: 2px;
        height: 1.1em;
        margin-right: 2px;
        margin-left: 2px;
        /* background: white !important; */
        color: transparent;
        border-radius: 2px;
        vertical-align: -0.1em;
        animation: blink 0.9s steps(1) infinite;
        /* box-shadow: 0 0 4px #B89C5A66; */
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    @media (max-width: 768px) {
        .hero-title-modern.creative-hero-title {
            font-size: 1.5rem;
            padding: 0 10px;
        }

        .hero-section-modern {
            height: auto !important;
            padding: 40px 0 20px 0 !important;
        }

        .hero-content-modern {
            text-align: center;
            align-items: center !important;
            justify-content: center !important;
        }

        #typewriter-cursor {
            height: 1em;
            margin: 0 1px;
        }
    }

    @media (max-width: 480px) {
        .hero-title-modern.creative-hero-title {
            font-size: 1.1rem;
            padding: 0 4px;
        }

        #typewriter-cursor {
            height: 0.9em;
        }
    }

    @keyframes floatY {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-18px);
        }
    }

    #typewriter {
        display: inline-block;
        animation: floatY 3.2s ease-in-out infinite;
    }

    @keyframes floatY {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-18px);
        }
    }

    .typewriter-wrap {
        display: inline-block;
        white-space: nowrap;
        direction: rtl;
    }

    /* ميديا كويري للشاشات المتوسطة - حجم خط 30px */
    @media (min-width: 768px) and (max-width: 1199px) {
        .hero-title-modern.creative-hero-title {
            font-size: 30px !important;
        }
    }

    /* ميديا كويري للهاتف - حجم خط 23px */
    @media (max-width: 767px) {
        .hero-title-modern.creative-hero-title {
            font-size: 23px !important;
        }

        .hero-subtitle-modern {
            margin-top: 15px !important;
        }

        .hero-buttons-modern {
            display: none !important;
        }

        .hero-logo-wrapper {
            max-width: 120px !important;
            margin: 0 auto 15px auto !important;
        }

        .hero-floating-elements .floating-element {
            width: 28px !important;
            height: 28px !important;
            font-size: 0.8rem !important;
        }

        /* تحسينات للهاتف - الخدمات والمميزات */
        .creative-service-card,
        .feature-card-modern {
            min-height: auto !important;
            padding: 25px 20px !important;
        }

        .creative-service-icon,
        .feature-icon-modern {
            width: 60px !important;
            height: 60px !important;
            font-size: 1.8rem !important;
            margin-bottom: 15px !important;
        }

        .creative-service-title,
        .feature-title {
            font-size: 1.1rem !important;
            margin-bottom: 10px !important;
        }

        .creative-service-description,
        .feature-description {
            font-size: 0.9rem !important;
            margin-bottom: 15px !important;
        }

        .creative-service-btn {
            padding: 8px 20px !important;
            font-size: 0.9rem !important;
        }

        /* تحسينات CTA للهاتف */
        .cta-title {
            font-size: 1.8rem !important;
        }

        .cta-subtitle {
            font-size: 1rem !important;
            margin-bottom: 30px !important;
        }

        .cta-btn-primary,
        .cta-btn-secondary {
            padding: 12px 25px !important;
            font-size: 1rem !important;
        }

        .cta-icon {
            width: 80px !important;
            height: 80px !important;
            font-size: 2rem !important;
            margin-bottom: 20px !important;
        }
    }

    /* ميديا كويري للتابلت */
    @media (min-width: 768px) and (max-width: 991px) {

        .creative-service-card,
        .feature-card-modern {
            min-height: 300px !important;
        }

        .cta-title {
            font-size: 2rem !important;
        }
    }

    /* إخفاء زر الواتساب في الشاشات تحت 992 بكسل */
    @media (max-width: 991px) {
        .whatsapp-btn {
            display: none !important;
        }
    }

    /* تحسينات الصورة للشاشات تحت 770 بكسل */
    @media (max-width: 769px) {
        .hero-image-container {
            min-height: auto !important;
            height: auto !important;
            padding: 20px 0 !important;
        }

        .hero-logo-wrapper {
            max-width: 150px !important;
            margin: 0 auto 20px auto !important;
            padding: 15px !important;
        }

        .hero-logo {
            max-width: 100% !important;
            height: auto !important;
            display: block !important;
        }

        .hero-floating-elements {
            position: relative !important;
            width: 100% !important;
            height: 60px !important;
            margin-top: 15px !important;
        }

        .hero-floating-elements .floating-element {
            width: 35px !important;
            height: 35px !important;
            font-size: 1rem !important;
            position: absolute !important;
        }

        .hero-floating-elements .element-1 {
            top: 0 !important;
            left: 20% !important;
        }

        .hero-floating-elements .element-2 {
            top: 0 !important;
            right: 20% !important;
        }

        .hero-floating-elements .element-3 {
            bottom: 0 !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }
    }

    /* تحسينات إضافية للهاتف الصغير */
    @media (max-width: 576px) {
        .hero-logo-wrapper {
            max-width: 120px !important;
            padding: 10px !important;
        }

        .hero-floating-elements {
            height: 50px !important;
        }

        .hero-floating-elements .floating-element {
            width: 30px !important;
            height: 30px !important;
            font-size: 0.9rem !important;
        }

        /* تحسينات CTA للهاتف الصغير */
        .cta-title {
            font-size: 1.6rem !important;
            padding: 0 15px !important;
        }

        .cta-subtitle {
            font-size: 0.95rem !important;
            padding: 0 25px !important;
        }

        .cta-btn-primary,
        .cta-btn-secondary {
            padding: 10px 20px !important;
            font-size: 0.95rem !important;
        }

        /* تحسينات Feature Cards للهاتف الصغير */
        .feature-card-modern {
            padding: 20px 15px !important;
            min-height: auto !important;
        }

        .feature-icon-modern {
            width: 60px !important;
            height: 60px !important;
            font-size: 1.5rem !important;
            margin-bottom: 0.75rem !important;
        }

        .feature-title {
            font-size: 1rem !important;
            margin-bottom: 0.5rem !important;
        }

        .feature-description {
            font-size: 0.85rem !important;
            line-height: 1.4 !important;
        }
    }

    /* تحسينات Feature Cards للتابلت */
    @media (min-width: 577px) and (max-width: 767px) {
        .feature-card-modern {
            padding: 25px 20px !important;
        }

        .feature-icon-modern {
            width: 70px !important;
            height: 70px !important;
            font-size: 1.8rem !important;
        }

        .feature-title {
            font-size: 1.1rem !important;
        }

        .feature-description {
            font-size: 0.9rem !important;
        }
    }

    /* تحسينات CTA للشاشات المختلفة */
    @media (max-width: 767px) {
        .cta-section {
            margin: 1rem 0 !important;
            border-radius: 15px !important;
        }

        .cta-icon {
            width: 80px !important;
            height: 80px !important;
            font-size: 2rem !important;
        }

        .cta-icon-glow {
            width: 100px !important;
            height: 100px !important;
        }

        .cta-title {
            font-size: 1.8rem !important;
            padding: 0 15px !important;
        }

        .cta-subtitle {
            font-size: 1rem !important;
            padding: 0 20px !important;
        }

        .cta-btn-primary,
        .cta-btn-secondary {
            padding: 12px 25px !important;
            font-size: 1rem !important;
        }

        .cta-feature-card {
            padding: 15px 10px !important;
        }

        .cta-feature-icon {
            width: 40px !important;
            height: 40px !important;
            font-size: 1rem !important;
        }

        .cta-feature-text {
            font-size: 0.9rem !important;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .cta-icon {
            width: 100px !important;
            height: 100px !important;
            font-size: 2.5rem !important;
        }

        .cta-icon-glow {
            width: 120px !important;
            height: 120px !important;
        }

        .cta-title {
            font-size: 2rem !important;
        }

        .cta-subtitle {
            font-size: 1.05rem !important;
        }
    }

    @media (min-width: 1200px) {
        .cta-icon {
            width: 140px !important;
            height: 140px !important;
            font-size: 3.5rem !important;
        }

        .cta-icon-glow {
            width: 160px !important;
            height: 160px !important;
        }

        .cta-title {
            font-size: 2.5rem !important;
        }

        .cta-subtitle {
            font-size: 1.2rem !important;
        }

        .cta-feature-card {
            padding: 25px 20px !important;
        }

        .cta-feature-icon {
            width: 60px !important;
            height: 60px !important;
            font-size: 1.4rem !important;
        }

        .cta-feature-text {
            font-size: 1.1rem !important;
        }
    }

    @keyframes float-hero-1 {
        0% {
            transform: translateY(0) rotate(0deg);
        }

        25% {
            transform: translateY(-18px) rotate(-8deg);
        }

        50% {
            transform: translateY(0) rotate(0deg);
        }

        75% {
            transform: translateY(12px) rotate(8deg);
        }

        100% {
            transform: translateY(0) rotate(0deg);
        }
    }

    @keyframes float-hero-2 {
        0% {
            transform: translateY(0) rotate(0deg);
        }

        20% {
            transform: translateY(10px) rotate(6deg);
        }

        50% {
            transform: translateY(-16px) rotate(-6deg);
        }

        80% {
            transform: translateY(8px) rotate(6deg);
        }

        100% {
            transform: translateY(0) rotate(0deg);
        }
    }

    @keyframes float-hero-3 {
        0% {
            transform: translateY(0) rotate(0deg);
        }

        30% {
            transform: translateY(-12px) rotate(10deg);
        }

        60% {
            transform: translateY(10px) rotate(-10deg);
        }

        100% {
            transform: translateY(0) rotate(0deg);
        }
    }

    .hero-floating-elements .element-1 {
        animation: float-hero-1 4.5s ease-in-out infinite;
    }

    .hero-floating-elements .element-2 {
        animation: float-hero-2 5.2s ease-in-out infinite;
    }

    .hero-floating-elements .element-3 {
        animation: float-hero-3 6s ease-in-out infinite;
    }

    .hero-icons-row .hero-icon-item {
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 8px #174A7C11;
        padding: 12px 18px;
        transition: transform 0.2s, background 0.2s, color 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .hero-icons-row .hero-icon-item:hover {
        background: #B89C5A;
        color: #fff;
        transform: translateY(-5px) scale(1.08);
    }

    .hero-icons-row .hero-icon-item i {
        color: #174A7C;
        transition: color 0.2s;
    }

    .hero-icons-row .hero-icon-item:hover i {
        color: #fff;
    }

    .hero-icons-row .hero-icon-item:hover .icon-label {
        color: #fff;
    }
</style>

<!-- سكريبت الكتابة الآلية للجملة الرئيسية -->
<script>
    const typewriterTexts = [
        'أحلامك العالمية تبدأ من هنا',
        'فرصتك للعمل بالخارج في انتظارك',
        'الميثاق... بوابتك للنجاح العالمي'
    ];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typingSpeed = 70;
    let pauseAfterTyping = 1200;
    let pauseAfterDeleting = 400;

    function typeWriterEffect() {
        const typewriterElement = document.getElementById('typewriter');
        const cursor = document.getElementById('typewriter-cursor');
        if (!typewriterElement || !cursor) return;
        const currentText = typewriterTexts[textIndex];
        cursor.style.visibility = 'visible';
        if (!isDeleting) {
            typewriterElement.textContent = currentText.slice(0, charIndex + 1);
            charIndex++;
            if (charIndex === currentText.length) {
                isDeleting = true;
                setTimeout(() => {
                    cursor.style.visibility = 'hidden';
                    setTimeout(typeWriterEffect, pauseAfterTyping);
                }, 350);
            } else {
                setTimeout(typeWriterEffect, typingSpeed);
            }
        } else {
            typewriterElement.textContent = currentText.slice(0, charIndex - 1);
            charIndex--;
            if (charIndex === 0) {
                isDeleting = false;
                textIndex = (textIndex + 1) % typewriterTexts.length;
                setTimeout(typeWriterEffect, pauseAfterDeleting);
            } else {
                setTimeout(typeWriterEffect, typingSpeed / 1.5);
            }
        }
    }
    window.onload = typeWriterEffect;
</script>
