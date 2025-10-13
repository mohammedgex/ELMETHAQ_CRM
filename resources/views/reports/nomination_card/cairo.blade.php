<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استمارة ترشيح عمل</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 20mm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 145px;

            /* خلفية الصورة */
            background-image: url('{{ asset('./Screenshot_1.png') }}');
            background-size: cover;
            /* تغطي الورقة بالكامل */
            background-repeat: no-repeat;
            /* لا تتكرر الصورة */
            background-position: center center;
            /* توسيط الخلفية */
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 21px;
            font-weight: bold;
        }

        .section-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 25px 0 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        table,
        th,
        td {
            border: 2px solid #000;
        }

        .top th,
        .top td {
            padding: 3px 5px;
            text-align: center;
            font-size: 16px;
            font-weight: 900;
        }

        .owner-data td {
            height: 35px;
        }

        .red-text {
            color: red;
            font-weight: bold;
        }

        .barcode-note {
            font-size: 15px;
            color: red;
            margin-top: -15px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .barcode-left {
            text-align: left;
        }

        .barcode-right {
            text-align: right;
        }

        .applicant-data td {
            height: 30px;
        }

        .notes-section {
            margin-top: 20px;
        }

        .notes-table {
            border: 7px solid black;
        }

        .notes-table td {
            text-align: right;
            padding: 5px 10px;
            font-size: 12px;
            vertical-align: top;
            font-weight: bold;
        }

        .notes-table .note-number {
            width: 40px;
            text-align: center;
        }

        .notes-header {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
        }

        .footer-item {
            margin: 3px 0;
            text-align: right;
        }

        .signature-section {
            margin-top: 5px;
            text-align: right;
            font-size: 16px;
            font-style: italic;
            font-weight: bold;
        }

        .print-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                margin: 0;
                /* padding: 15mm 20mm; */
                box-shadow: none;
                page-break-after: auto;
                page-break-inside: avoid;
                height: 297mm;
                min-height: auto;
            }

            .no-print {
                display: none;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <button class="print-button no-print" onclick="window.print()">طباعة الاستمارة</button>

    <div class="page">
        <div class="header">
            <h1
                style="border: 3px solid black;
    width: fit-content;
    padding: 5px;
    margin: 0 auto 5px;
    color:red;
    font-weight: bold;">
                اعاده
                طباعة</h1>
            <h2> <u>بيانات صاحب العمل</u> </h2>
        </div>

        <div style="display: flex; gap: 10px; height: 164px;">
            <table class="top" style="border: 7px solid black; margin: 0 auto; ">
                <tr>
                    <td style="text-align: start;">الاسم</td>
                    <td style="width: 60%;">{{ $customer->customerGroup?->visaType?->sponser?->name ?? '-' }}</td>
                    <td rowspan="4" style="vertical-align: top; text-align: end;">رقم الصندوق : <span
                            style="display: block; widows: 100%; text-align: center; font-size: 35px;">418</span></td>
                </tr>
                <tr>
                    <td style="text-align: start;">رقم التأشيرة </td>
                    <td style="width: 60%; text-align: start; color: red;"><span>رقم</span>:
                        {{ $customer->customerGroup?->visaType?->outgoing_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="text-align: start;">رقم السجل </td>
                    <td style="width: 60%; text-align: start; color: red;"><span>رقم</span>:
                        {{ $customer->customerGroup?->visaType?->registration_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="text-align: start;">رقم الوكالة</td>
                    <td style="width: 60%;" id="number"></td>
                </tr>
            </table>
            <div style="width: 25%;">
                <img style="max-width: 100%; border-radius: 8px; height: 164px;"
                    src="{{ asset('storage/' . $customer->image) }}" alt="">
            </div>
        </div>

        <div style="display: flex;
    justify-content: space-between;
    margin-top: 18px;
    margin-bottom: 51px;">
            <div class="barcode-note barcode-left">باركود رقم التاشيرة</div>
            <div class="barcode-note barcode-right">باركود رقم انجاز</div>
        </div>

        <div class="section-title">
            <h2>
                <u>بيانات طالب العمل</u>
            </h2>
        </div>

        <table class="applicant-data">
            <tr>
                <th>الاسم</th>
                <th>رقم الجواز</th>
                <th>رقم انجاز</th>
                <th>المهنة</th>
                <th>المؤهل</th>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: center">{{ $customer->name_ar }}</td>
                <td style="font-weight: bold; text-align: center">{{ $customer->passport_id }}</td>
                <td style="font-weight: bold; text-align: center">{{ $customer->e_visa_number }}</td>
                <td style="font-weight: bold; text-align: center">{{ $customer->customerGroup?->visaProfession?->job }}
                </td>
                <td style="font-weight: bold; text-align: center"></td>
            </tr>
        </table>

        <table cellpadding="8" class="notes-table">
            <tr>
                <td rowspan="50" style="width: 16%;">ملاحظات</td>
                <td></td>
                <td>لا يوجد كشف طبي (معامل/ مستشفي خاص)</td>
                <td></td>
                <td>الصورة خطأ او غير موجودة</td>
            </tr>
            <tr>
                <td></td>
                <td>غير لائق بسبب .............</td>
                <td></td>
                <td>استمارة الترشيح غير موقعة او غير مختومة</td>
            </tr>
            <tr>
                <td></td>
                <td>لا يوجد مؤهل</td>
                <td></td>
                <td>المهنة مختلفة في الجواز عن التاشيرة</td>
            </tr>
            <tr>
                <td></td>
                <td>المؤهل (غير مطابق او غير مصدق)</td>
                <td></td>
                <td>صلاحيةالجواز اقل من 6 اشهر</td>
            </tr>
            <tr>
                <td></td>
                <td>مطلوب شهادة خبرة</td>
                <td></td>
                <td>الشركة موقوفة</td>
            </tr>
            <tr>
                <td></td>
                <td>لا توجد وكالة من صاحب العمل</td>
                <td></td>
                <td>يوجد خطا فى بيانات النت ......</td>
            </tr>
            <tr>
                <td></td>
                <td>يوجد اكثر من وكالة للتاشيرة</td>
                <td></td>
                <td>المهنة المطلوبة او الامر منفذ بالكامل</td>
            </tr>
            <tr>
                <td></td>
                <td>خطا في الفيش والتشبيه (الاسم / العلامة / الصلاحية)</td>
                <td></td>
                <td>الجواز لا يوجد عليه لاصق المكتب</td>
            </tr>
            <tr>
                <td></td>
                <td>اقر العامل بالموافقة علي المهنة</td>
                <td></td>
                <td>لا توجد رخصة قيادة او غير مطابقة للمهنة</td>
            </tr>
            <tr>
                <td></td>
                <td>خطاب موافقة من صاحب العمل بالاستثناء</td>
                <td></td>
                <td> الاعتماد المهني</td>
            </tr>
            <tr>
                <td></td>
                <td>العمر اقل او اكثر من المطلوب (21 - 60)</td>
                <td></td>
                <td>الفحص المهني</td>
            </tr>
            <tr>
                <td></td>
                <td>الباركود يقرا خطا او غير صحيح</td>
                <td></td>
                <td>ملاحظة اخري ...................</td>
            </tr>
            <tr>
                <td></td>
                <td> الخصائص الحيوية (البصمة)</td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <div class="signature-section">
            <div>أتعهد بصحة البيانات أعلاه</div>
            <div>التوقيع المعتمد والختم</div>
        </div>
    </div>
    <script>
        window.onload = function() {
            const agencyNumber = prompt("من فضلك أدخل رقم الوكالة:");
            if (agencyNumber) {
                document.getElementById("number").textContent = agencyNumber;
            }
        };
    </script>

</body>

</html>
