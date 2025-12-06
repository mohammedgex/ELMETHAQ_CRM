<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>استمارة اختبار ({{ $lead->name }})</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .a4 {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 12mm;
            border: 2px solid #04134e;
            box-sizing: border-box;
        }

        /* الهيدر */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 15px;
        }

        .company {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .company h1 {
            margin: 0;
            font-size: 25px;
            color: #04134e;
        }

        .company p {
            margin: 3px 0;
            color: #997a43;
            font-weight: bold;
            font-size: 14px;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        /* الباركود */
        .barcode {
            flex-basis: 25%;
            max-width: 25%;
            text-align: center;
        }

        .barcode-box {
            border: 1px solid #04134e;
            padding: 10px;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fafafa;
        }

        .barcode-img {
            width: 100px;
            height: 100px;
        }

        .form-title {
            text-align: center;
            /* margin: 15px 0; */
            font-size: 18px;
            font-weight: bold;
            color: #04134e;
        }

        .content {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 15px;
            margin-top: 10px;
        }

        /* الكارد الخاص بالصورة والتاريخ */
        .photo-card {
            background: #f9fbff;
            border: 1px solid #c9d6e6;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 12px;
            text-align: center;
            max-width: 200px;
        }

        .photo {
            border: 1px solid #04134e;
            border-radius: 6px;
            height: 180px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            overflow: hidden;
        }

        .photo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .date-time {
            font-size: 13px;
            color: #04134e;
            background: #eaf0f8;
            border: 1px solid #cdd8eb;
            border-radius: 6px;
            padding: 8px;
            line-height: 1.6;
        }

        .info,
        .extra-questions {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 5px;
            align-items: center;
            font-size: 14px;
            margin-top: 15px;
        }

        .extra-questions {
            grid-template-columns: 1fr 1fr;
        }

        .info div,
        .extra-questions div {
            border: 1px solid #ccc;
            padding: 5px;
            background: #fafafa;
            border-radius: 6px;
            text-align: center;
        }

        .info div {
            border: 1px solid #ccc;
            padding: 5px;
            background: #fafafa;
            border-radius: 6px;
            text-align: center;
            min-height: 38px;
            /* أو أي رقم يناسبك */
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .extra-title {
            /* margin-top: 25px; */
            margin-bottom: 10px;
            font-weight: bold;
            color: #04134e;
            text-align: center;
            font-size: 15px;
        }

        .committee {
            /* margin-top: 25px; */
            text-align: center;
        }

        .committee h3 {
            margin: 5px 0 0;
            color: #04134e;
        }

        .committee-boxes {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 15px;
            width: 25%;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
            background: #fafafa;
        }

        .accepted {
            border-color: green;
            color: green;
        }

        .optional {
            border-color: #2196f3;
            color: #2196f3;
        }

        .rejected {
            border-color: #ff5722;
            color: #ff5722;
        }

        .decision-note {
            border: 1px solid #ccc;
            height: 40px;
            margin-top: 8px;
            background: #fff;
            border-radius: 4px;
        }

        .evaluation-box {
            text-align: right;
            margin: 20px auto;
            width: 90%;
        }

        .evaluation-box strong {
            display: block;
            margin-bottom: 8px;
            color: #04134e;
        }

        .evaluation-area {
            border: 1px solid #ccc;
            height: 80px;
            border-radius: 5px;
            background: #fafafa;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-size: 14px;
        }

        .number-box {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 90px;
            border: 3px solid #997a43;
            border-radius: 10px;
            font-size: 40px;
            font-weight: bold;
            padding: 10px;
            color: #04134e;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
            /* التحكم في حجم النص */
            font-size: clamp(20px, 6vw, 36px);
            /* ديناميكي */
            text-align: center;
            padding: 5px;
            overflow: hidden;
            word-wrap: break-word;
        }

        @media print {
            body {
                background: none;
            }

            .a4 {
                margin: 0;
                border: none;
                width: auto;
                height: auto;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin: 10px 0; display: flex; justify-content: space-around; gap: 15px;">
        <div>
            <a class="btn btn-print no-print" href="{{ route('leads-customers.update', $lead->id) }}">
                <i class="fas fa-print me-1"></i>تعديل
            </a>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-print no-print">
                <i class="fas fa-print me-1"></i> طباعة
            </button>
        </div>
        <div>
            <a class="btn btn-print no-print" href="{{ route('sign.lead.in.test', $test->id) }}">
                <i class="fas fa-print me-1"></i>رجوع
            </a>
        </div>
    </div>

    <style>
        /* شكل الزر */
        .btn-print {
            background: linear-gradient(135deg, #6c757d, #495057);
            width: 100px;
            height: 60px;
            font-size: 20px !important;
            font-weight: bold !important;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .btn-print i {
            font-size: 15px;
        }

        .btn-print:hover {
            background: linear-gradient(135deg, #495057, #343a40);
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* الوضع الليلي */
        body.dark-mode .btn-print {
            background: linear-gradient(135deg, #adb5bd, #6c757d);
            color: #212529;
        }

        body.dark-mode .btn-print:hover {
            background: linear-gradient(135deg, #dee2e6, #adb5bd);
        }

        /* إخفاء زر الطباعة عند الطباعة */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="a4">
        <!-- الهيدر -->
        <div class="header">
            <!-- بيانات الشركة -->
            <div class="company">
                <div class="logo">
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="شعار الشركة">
                </div>
                <div class="company-info">
                    <h1>{{ $company->name }}</h1>
                    <p>لالحاق العمالة المصرية بالخارج</p>
                    <p>ترخيص رقم (768) قوى عاملة ذ.م.م</p>
                </div>
            </div>
            <div class="number-box">
                <h1>{{ $lead->evaluations->where('test_id', $test->id)->last()->code ?? '' }}</h1>
            </div>

            <!-- الباركود -->
            <div class="barcode">
                <div class="barcode-box">
                    <div class="barcode-img" id="qrcode" data-link="<?php echo 'https://eliraqitravel.com/admin/tests/' . $test->id . '/show-evaluations/' . $lead->id; ?>"></div>
                </div>
            </div>
        </div>

        <div class="form-title d-flex align-items-center" style="position: relative;">
            @php
                $lastEvaluation = $lead->evaluations->where('test_id', $test->id)->last();
            @endphp

            @if ($lastEvaluation && $lastEvaluation->evaluation === 'غير مقبول')
                <span
                    style="position: absolute; left: 0; background: green; color: #fff; border-radius: 4px; padding: 4px 6px;">
                    اعادة اختبار
                </span>
            @endif

            <span class="mx-auto">استمارة اختبار ({{ $lead->jobTitle->title ?? '' }})</span>
        </div>

        <div class="content">
            <!-- الكارد -->
            <div class="photo-card">
                <div class="photo">
                    <img src="{{ asset('storage/' . $lead->image) }}" alt="صورة المتقدم">
                </div>
                <div class="date-time">
                    @php
                        date_default_timezone_set('Africa/Cairo');
                        $time = new DateTime();
                    @endphp

                    <div>📅 التاريخ: {{ $time->format('d/m/Y') }}</div>
                    <div>⏰ الوقت: {{ $time->format('h:i A') }}</div>
                </div>

                <form class="no-print" id="imageUploadForm"
                    action="{{ route('leads-customers.changeImage', [$lead->id, $test->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <style>
                        .custom-file-upload {
                            display: block;
                            padding: 15px;
                            cursor: pointer;
                            background: #fafafa;
                            border: 2px dashed #bfc4c9;
                            border-radius: 12px;
                            text-align: center;
                            transition: 0.25s ease-in-out;
                            margin-top: 5px;
                        }

                        .custom-file-upload:hover {
                            background: #f0f0f0;
                            border-color: #6c757d;
                        }

                        .custom-file-upload:active {
                            background: #e9ecef;
                        }

                        .custom-file-upload i {
                            font-size: 32px;
                            margin-bottom: 8px;
                            display: block;
                            color: #6c757d;
                        }

                        #fileName {
                            font-size: 14px;
                            margin-top: 8px;
                            color: #444;
                            font-weight: 500;
                        }

                        /* إخفاء ال input */
                        input[type="file"] {
                            display: none;
                        }
                    </style>

                    <label for="imageInput" class="custom-file-upload">
                        <i class="fas fa-cloud-upload-alt"></i>
                        اضغط لتغيير صورة
                        <div id="fileName">لم يتم اختيار ملف بعد</div>
                    </label>

                    <input id="imageInput" type="file" name="image" accept="image/*"
                        onchange="submitImageForm(event)">
                </form>
                <script>
                    function submitImageForm(event) {
                        // إرسال النموذج تلقائياً
                        document.getElementById('imageUploadForm').submit();
                    }
                </script>
            </div>

            <!-- بيانات -->
            <div class="info">
                <div>الاسم:</div>
                <div>{{ $lead->name }}</div>
                <div>السن:</div>
                <div>{{ $lead->age }} سنة</div>
                <div>المحافظة:</div>
                <div>{{ $lead->governorate }}</div>
                <div>المندوب:</div>
                <div>{{ $lead->delegate->name ?? '' }}</div>
                <div class="no-print">الهاتف:</div>
                <div class="no-print">{{ $lead->phone }}</div>
            </div>
        </div>

        <div class="extra-title">البيانات الإضافية</div>
        <div class="extra-questions">
            @foreach ($lead->jobTitle->questions()->where('show_in_report', 'yes')->get() as $question)
                @php
                    $answer = $lead->answers->firstWhere('job_question_id', $question->id);
                @endphp

                <div>{{ $question->question }}:</div>
                <div>
                    @if ($answer)
                        @if (is_array($answer->answer))
                            <ul style="margin: 0; padding-left: 18px; text-align: right;">
                                @foreach ($answer->answer as $ans)
                                    <li>{{ $ans }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ $answer->answer }}
                        @endif
                    @else
                        {{-- لو مفيش إجابة نخليها فاضية --}}
                        &nbsp;
                    @endif
                </div>
            @endforeach
        </div>



        <!-- قرار اللجنة -->
        <div class="committee">
            <h3>قرار اللجنة</h3>
            <div class="committee-boxes">
                <div class="box accepted">
                    مقبول
                    <div class="decision-note"></div>
                </div>
                <div class="box optional">
                    احتياطي
                    <div class="decision-note"></div>
                </div>
                <div class="box rejected">
                    مرفوض
                    <div class="decision-note"></div>
                </div>
            </div>

            <div class="evaluation-box">
                <strong>ملاحظات اللجنة:</strong>
                <div class="evaluation-area"></div>
            </div>
        </div>

        <div class="signatures">
            <div>ختم رئيس اللجنة</div>
            <div>اعتماد رئيس اللجنة</div>
        </div>
    </div>

    <!-- مكتبة QRCode -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        const qrDiv = document.getElementById("qrcode");
        const link = qrDiv.dataset.link;

        new QRCode(qrDiv, {
            text: link,
            width: 100,
            height: 100,
            colorDark: "#000",
            colorLight: "#fff",
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>
</body>

</html>
