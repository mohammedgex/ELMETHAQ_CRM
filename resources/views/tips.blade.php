@extends('layouts.app')
@section('title', 'نصائح وإرشادات للعمالة بالخارج')
@section('content')
    <style>
        .tip-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(23, 74, 124, 0.07);
            border: 1px solid #e5e7eb;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.2rem;
            transition: box-shadow 0.2s, background 0.2s;
            position: relative;
            overflow: hidden;
        }

        .tip-card:hover {
            background: #f3f6fa;
            box-shadow: 0 4px 24px rgba(23, 74, 124, 0.13);
        }

        .tip-icon {
            font-size: 1.7rem;
            margin-left: 0.7rem;
            vertical-align: middle;
        }

        .tip-num {
            background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
            color: #fff;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            margin-left: 0.7rem;
            box-shadow: 0 2px 8px rgba(23, 74, 124, 0.10);
        }

        .tips-section-title {
            color: #174A7C;
            font-weight: bold;
            font-size: 1.3rem;
            margin: 2.2rem 0 1.2rem 0;
            letter-spacing: 1px;
            border-right: 5px solid #B89C5A;
            padding-right: 12px;
            background: #f8fafc;
            border-radius: 8px;
            display: inline-block;
        }

        .tips-hero {
            background: linear-gradient(135deg, #174A7C 60%, #B89C5A 100%);
            color: #fff;
            border-radius: 18px 18px 0 0;
            padding: 2.2rem 1rem 1.2rem 1rem;
            text-align: center;
            margin-bottom: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .tips-hero:after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 8px;
            background: linear-gradient(90deg, #B89C5A 0%, #174A7C 100%);
            opacity: 0.18;
        }

        .tips-hero i {
            font-size: 2.2rem;
            margin-bottom: 0.7rem;
            color: #fffbe6;
            display: block;
        }
    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-sm" style="border-radius:18px; border:1px solid #e5e7eb;">
                    <div class="tips-hero">
                        <i class="fas fa-lightbulb"></i>
                        <h2 class="mb-2 fw-bold"
                            style="letter-spacing:1px; color:#fff !important; text-shadow:0 2px 8px #fffbe6;">
                            نصائح وإرشادات هامة للعمالة بالخارج</h2>
                        <div style="font-size:1.1rem;opacity:0.93;">دليلك القانوني والعملي قبل وأثناء السفر للعمل بالخارج
                        </div>
                    </div>
                    <div class="card-body"
                        style="background: linear-gradient(135deg, #fff 85%, #f8fafc 100%); border-radius:0 0 18px 18px;">
                        <div class="tips-section-title"><i class="fas fa-balance-scale tip-icon"></i> نصائح قانونية</div>
                        <div class="tip-card"><span class="tip-num">1</span> <b>راجع عقد العمل جيداً</b> قبل التوقيع، وتأكد
                            من وضوح جميع البنود (الراتب، ساعات العمل، الإجازات، التأمينات، مدة العقد).</div>
                        <div class="tip-card"><span class="tip-num">2</span> <b>تأكد من حصولك على تصريح العمل والتأشيرة
                                القانونية</b> قبل السفر، ولا تعمل بأي دولة بدون أوراق رسمية.</div>
                        <div class="tip-card"><span class="tip-num">3</span> <b>تعرف على حقوقك وواجباتك</b> حسب قانون العمل
                            في الدولة المضيفة، خاصة فيما يخص الأجور، الإجازات، ساعات العمل، والتأمين الصحي.</div>
                        <div class="tip-card"><span class="tip-num">4</span> <b>لا توقع على أي مستند غير مفهوم</b> أو فارغ،
                            واستشر السفارة أو القنصلية المصرية عند الشك.</div>
                        <div class="tip-card"><span class="tip-num">5</span> <b>سجل بياناتك لدى السفارة المصرية</b> فور
                            وصولك، واحتفظ بأرقام الطوارئ والقنصلية.</div>
                        <div class="tips-section-title"><i class="fas fa-user-shield tip-icon"></i> نصائح حياتية ووقائية
                        </div>
                        <div class="tip-card"><span class="tip-num">6</span> <b>احتفظ بنسخة من جواز السفر والتأشيرة
                                والعقد</b> في مكان آمن، ويفضل نسخة إلكترونية على بريدك.</div>
                        <div class="tip-card"><span class="tip-num">7</span> <b>احرص على التواصل مع أسرتك بانتظام</b>
                            وأبلغهم بعنوان إقامتك وأرقام التواصل.</div>
                        <div class="tip-card"><span class="tip-num">8</span> <b>تجنب التعامل مع وسطاء أو شركات غير
                                مرخصة</b>، وتعامل فقط مع جهات رسمية معتمدة من وزارة القوى العاملة.</div>
                        <div class="tip-card"><span class="tip-num">9</span> <b>تعلم أساسيات اللغة المحلية</b> لتسهيل
                            التواصل اليومي والعمل.</div>
                        <div class="tip-card"><span class="tip-num">10</span> <b>احترم قوانين وعادات البلد المضيف</b>، وكن
                            سفيراً مشرفاً لبلدك في الخارج.</div>
                        <div class="alert alert-warning mt-4 text-center" style="font-size:1.1rem;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            لمزيد من المعلومات أو في حالة الطوارئ، تواصل مع السفارة أو القنصلية المصرية في الدولة التي تعمل
                            بها.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
