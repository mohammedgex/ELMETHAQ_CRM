<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>استمارة ترشيح عمل</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            direction: rtl;
            position: relative;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 100%;
        }

        .container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* تنسيقات النصوص فوق الصورة */
        .field {
            position: absolute;
            font-size: 18px;
            font-weight: bold;
            color: black;
        }

        .field.name {
            top: 250px;
            right: 190px;
        }

        .field.job {
            top: 285px;
            right: 190px;
        }

        .field.national-id {
            top: 315px;
            right: 190px;
        }

        .field.request-no {
            top: 340px;
            right: 190px;
        }

        .field.visa-no {
            top: 315px;
            left: 150px;
        }

        .field.e-number {
            top: 370px;
            right: 270px;
        }

        .field.box1,
        .field.box2 {
            border: 1px solid black;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
        }

        .field.box1 {
            top: 185px;
            right: 270px;
        }

        .field.box2 {
            top: 185px;
            right: 400px;
        }

        .box {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 2px solid black;
            background-color: transparent;
            vertical-align: middle;
            margin-right: 10px;
        }

        /* ==============================
       نص الاستمارة + صورة + المربعات
       ============================== */
        .form-header {
            position: absolute;
            left: 50%;
            top: 150px;
            transform: translateX(-50%);
            font-size: 22px;
        }

        .top-section {
            position: absolute;
            left: 50%;
            top: 190px;
            transform: translateX(-50%);
            display: flex;
            direction: ltr;
            justify-content: space-between;
            width: 90%;
            align-items: center;
        }

        .img img {
            width: 150px;
            height: 170px;
        }

        .info-group {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .pair-group {
            display: flex;
            gap: 30px;
            align-items: center;
            flex-direction: row-reverse;
        }

        .info-group {
            flex-direction: column;
            width: 68%;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 0;
        }

        h3 {
            margin-top: 0;
            margin-bottom: 0;
        }


        .p {
            font-size: 13px;
            text-align: end;
            align-self: end;
        }

        .section-center {
            position: absolute;
            left: 50%;
            top: 360px;
            transform: translateX(-50%);
            width: 90%;
            text-align: center;
        }

        .flex {
            display: flex;
            gap: 20px;
        }

        svg {
            margin-right: 20px;
            width: 150px;
            height: 50px;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body,
            html {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .container {
                width: 100%;
                height: 100%;
                position: relative;
                page-break-inside: avoid;
            }

            .container img {
                width: 100%;
                height: auto;
            }

            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            /* الحفاظ على تموضع النصوص */
            .field {
                font-size: 14px;
                font-weight: bold;
            }

            .img img {
                width: 150px;
                height: 170px;
            }

            /* تأكد من أن كل العناصر ثابتة أثناء الطباعة */
            .form-header,
            .top-section,
            .section-center {
                position: absolute !important;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

</head>

<body>

    <div class="container">
        {{-- <img src="./Screenshot_1.png" alt="استمارة ترشيح"> --}}
        <img src="{{ asset('./Screenshot_1.png') }}" alt="صورة شخصية">

        <div class="overlay">
            <!-- عنوان الاستمارة -->
            <h2 class="form-header">(استمارة ترشيح عمل)</h2>

            <!-- قسم الصورة والمرفقات -->
            <div class="top-section">
                <!-- الصورة -->
                <div class="img">
                    <img src="{{ asset('storage/' . $customer->image) }}" alt="صورة شخصية">
                </div>

                <!-- النصوص والمربعات -->
                <div class="info-group">
                    <h2
                        style="position: absolute;
            top: 0;
            left: 50%;
            transform: translateY(-50%);">
                        مجانا</h2>
                    <div class="pair-group">
                        <h2><span class="box"></span> عدد المرفقات</h2>
                        <h2><span class="box"></span> أصول المرفقات</h2>
                    </div>
                    <div class="p">
                        <h3>سعادة رئيس القسم القنصلي في
                            <span>{{ $customer->customerGroup->visaType->embassy->title ?? '-' }}</span>
                        </h3>
                        <h3>...السلام عليكم ورحمة الله وبركاته</h3>
                    </div>
                </div>
            </div>
            <!-- قسم المعلومات الشخصية -->
            <div class="section-center">
                <h3 style="text-align:right;">نرفق لكم بطيه الجواز الخاصة بالسيد/ <span
                        style="margin-right: 50px;">{{ $customer->name_ar }}</span>
                </h3>
                <div class="flex" style="justify-content: space-around;">
                    <div class="">
                        <h4>نأمل التكرم منكم بالتأشير له علي مهنة <span
                                style="margin-right: 50px;">{{ $customer->customerGroup->visaProfession->job ?? '-' }}</span>
                        </h4>
                        <h4>بموجب التأشيرة رقم <Span
                                style="margin-right: 50px;">{{ $customer->visa_number ?? '-' }}</Span></h4>
                    </div>
                    <div>
                        <!-- رقم التأشيرة -->
                        <h4
                            style="display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 0;
                margin-bottom: 0;">
                            رقم التأشيرة
                            <svg id="barcode_visa"></svg>
                        </h4>

                        <!-- رقم الطلب -->
                        <h4
                            style="display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 0;
                margin-bottom: 0;">
                            رقم الطلب
                            <svg id="barcode_enumber"></svg>
                        </h4>
                    </div>
                </div>
                <div style="text-align: right; font-weight: bold; padding: 10px 0;">

                    <!-- التاريخ والصادر في نفس السطر ولكن بمحاذاة عكسية -->
                    <div style="display: flex; justify-content: space-between; width: 100%;">

                        <!-- التاريخ في أقصى اليمين -->
                        <div>
                            وتاريخ
                            <span style="display: inline-block; width: 150px; text-align: center;">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $customer->customerGroup?->visaType?->issuing_visa)->format('d/m/Y') }}

                            </span>
                        </div>

                        <!-- الصادر في أقصى اليسار -->
                        <div style="width: 59%;">
                            هـ والصادر
                            <span
                                style="display: inline-block; width: 200px; text-align: center;">{{ $customer->customerGroup->visaType->sponser->name }}</span>
                        </div>

                    </div>

                    <!-- رقم الطلب في سطر منفصل -->
                    <p style="margin-top: 5px; text-align: center;">
                        رقم انجاز
                        <span style="display: inline-block;  margin-right: 60px;">{{ $customer->e_visa_number }}</span>
                    </p>
                    <p style="margin-bottom: 0;">ويتعهد المكتب بأن المرشح يجيد القراءة والكتابة، وأن كافة البيانات
                        المدونة
                        والمرفقة
                        صحيحة، وأن الباركود مطابق لرقم E Number</p>
                    <p style="text-align: center;margin: 0;">ومطابق لرقم التأشيرة وهذا تحت مسؤوليتنا.</p>
                    <div class="flex" style="justify-content: space-around;">
                        <p>ختم المكتب</p>
                        <p>توقيع المدير</p>
                    </div>
                    <p style="font-weight: bold; margin: 0;"><span style="font-size: 18px; margin-left: 7px;">راى
                            القنصلية</span>
                        بعد مراجعة جواز المرسل من قبلكم للقسم القنصلي، اتضح لنا أنه غير مستوفٍ للشروط، ومن أجل كل ذلك تم
                        رفضه لذا
                    </p>
                    <p style="margin: 0;font-weight: bold;text-align: center;">نأمل إحضار المطلوب وتصحيح الملاحظة،
                        واعادته مع هذه
                        الاستمارة وشكرا.</p>
                    <div class="flex" style="justify-content: space-around;">
                        <h3>توقيع المراجع</h3>
                        <h3>القنصل</h3>
                    </div>
                    <div style="padding: 15px 30px;">
                        <table
                            style="width: 100%; border-collapse: collapse; direction: rtl; font-family: Arial; text-align: right; font-size: 14px;">
                            <colgroup>
                                <col style="width: 40px;">
                                <col>
                                <col style="width: 40px;">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td style="border: 2px solid black;">1</td>
                                    <td style="border: 2px solid black;">الصورة غير واضحة أو خاطئة</td>
                                    <td style="border: 2px solid black;">14</td>
                                    <td style="border: 2px solid black;">استمارة الترشيح غير موقعة أو مختومة</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">2</td>
                                    <td style="border: 2px solid black;">المهنة مختلفة في الجواز عن التأشيرة</td>
                                    <td style="border: 2px solid black;">15</td>
                                    <td style="border: 2px solid black;">صلاحية الجواز أقل من 6 أشهر</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">3</td>
                                    <td style="border: 2px solid black;">الشركة موقوفة</td>
                                    <td style="border: 2px solid black;">16</td>
                                    <td style="border: 2px solid black;">يوجد خطأ في بيانات النت</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">4</td>
                                    <td style="border: 2px solid black;">المهنة المطلوبة أو الأمر المنفذ بالكامل</td>
                                    <td style="border: 2px solid black;">17</td>
                                    <td style="border: 2px solid black;">الجواز لا يوجد عليه لصق المكتب ----------</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">5</td>
                                    <td style="border: 2px solid black;">لا توجد رخصة قيادة أو غير مطابقة للمهنة</td>
                                    <td style="border: 2px solid black;">18</td>
                                    <td style="border: 2px solid black;">لا يوجد كشف طبي (معامل / مستشفى خاص)</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">6</td>
                                    <td style="border: 2px solid black;">اعتماد المهني</td>
                                    <td style="border: 2px solid black;">19</td>
                                    <td style="border: 2px solid black;">الفحص المهني</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">7</td>
                                    <td style="border: 2px solid black;">رسوم التأشيرة غير مسددة ----------</td>
                                    <td style="border: 2px solid black;">20</td>
                                    <td style="border: 2px solid black;">غير لائق بسبب..........................</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">8</td>
                                    <td style="border: 2px solid black;">لا يوجد مؤهل دراسي</td>
                                    <td style="border: 2px solid black;">21</td>
                                    <td style="border: 2px solid black;">المؤهل غير مطابق أو غير مصدق</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">9</td>
                                    <td style="border: 2px solid black;">مطلوب شهادة خبرة</td>
                                    <td style="border: 2px solid black;">22</td>
                                    <td style="border: 2px solid black;">لا توجد وكالة من صاحب العمل</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">10</td>
                                    <td style="border: 2px solid black;">يوجد أكثر من وكالة للتأشيرة</td>
                                    <td style="border: 2px solid black;">23</td>
                                    <td style="border: 2px solid black;">أخطاء في الاسم/العلامة/الصلاحية بالتشبيه أو
                                        الشيفرة</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">11</td>
                                    <td style="border: 2px solid black;">إقرار العامل بالموافقة على المهنة</td>
                                    <td style="border: 2px solid black;">24</td>
                                    <td style="border: 2px solid black;">خطاب موافقة من صاحب العمل بالاستثناء</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">12</td>
                                    <td style="border: 2px solid black;">العمر أقل أو أكثر من المطلوب (21 - 60)</td>
                                    <td style="border: 2px solid black;">25</td>
                                    <td style="border: 2px solid black;">الباركود غير واضح أو به خطأ</td>
                                </tr>
                                <tr>
                                    <td style="border: 2px solid black;">13</td>
                                    <td style="border: 2px solid black;">ملاحظات أخرى</td>
                                    <td style="border: 2px solid black;">26</td>
                                    <td style="border: 2px solid black;">
                                        ........................................................</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span id="enumber_value" style="display: none;">{{ $customer->e_visa_number }}</span>
    <span id="visa_number" style="display: none;">{{ $customer->visa_number }}</span>
    <script>
        // استخراج الأرقام
        const visaNumber = document.getElementById('visa_number').textContent.trim();
        const eNumber = document.getElementById('enumber_value').textContent.trim();

        // توليد الباركود لرقم التأشيرة
        JsBarcode("#barcode_visa", visaNumber, {
            format: "CODE128",
            lineColor: "#000",
            width: 2,
            height: 50,
            displayValue: false
        });

        // توليد الباركود لرقم الطلب
        JsBarcode("#barcode_enumber", eNumber, {
            format: "CODE128",
            lineColor: "#000",
            width: 2,
            height: 50,
            displayValue: false
        });

        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
