<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>شركة الميثاق – نموذج اختبار للوظائف</title>
    <style>
        :root {
            --brand: #064180;
            --accent: #967947;
            --ink: #111;
            --muted: #666;
            --light-bg: #f8fafc;
            --border: #e6e8ef;
            --shadow: 0 4px 12px rgba(6, 65, 128, 0.08);
            --gradient: linear-gradient(135deg, #064180 0%, #0a5aa6 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            font-family: "Tajawal", "Cairo", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f6f7fb 0%, #e9ecf3 100%);
            color: var(--ink);
            font-size: 14px;
            line-height: 1.5;
            min-height: 100vh;
        }

        .sheet {
            width: 210mm;
            margin: 15mm auto;
            background: #fff;
            color: var(--ink);
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            position: relative;
            max-width: 210mm;
        }

        .sheet::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient);
        }

        .content-wrapper {
            padding: 15mm 12mm;
        }

        header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 12mm;
            padding: 15px 20px;
            background: linear-gradient(135deg, var(--light-bg) 0%, rgba(6, 65, 128, 0.02) 100%);
            border-radius: 10px;
            border: 2px solid var(--accent);
            position: relative;
            overflow: hidden;
        }

        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20" fill="none"><circle cx="10" cy="10" r="1" fill="rgba(150,121,71,0.1)"/><circle cx="30" cy="5" r="1" fill="rgba(150,121,71,0.1)"/><circle cx="50" cy="15" r="1" fill="rgba(150,121,71,0.1)"/><circle cx="70" cy="8" r="1" fill="rgba(150,121,71,0.1)"/><circle cx="90" cy="12" r="1" fill="rgba(150,121,71,0.1)"/></svg>') repeat;
            opacity: 0.3;
            z-index: 0;
        }

        header>* {
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 50px;
            height: 50px;
            border: 3px solid var(--accent);
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-weight: 900;
            color: var(--brand);
            font-size: 14px;
            background: linear-gradient(135deg, #fff 0%, var(--light-bg) 100%);
            box-shadow: 0 2px 8px rgba(150, 121, 71, 0.2);
        }

        .brand {
            flex: 1;
        }

        .brand h1 {
            font-size: 20px;
            color: var(--brand);
            line-height: 1.2;
            margin-bottom: 5px;
            font-weight: 800;
        }

        .brand .sub {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.4;
            font-weight: 500;
        }

        .photo-box {
            width: 28mm;
            height: 35mm;
            border: 2px dashed #b7c6da;
            border-radius: 8px;
            display: grid;
            place-items: center;
            font-size: 11px;
            color: #8aa2bf;
            flex-shrink: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #fafbfc 0%, #f0f4f7 100%);
            transition: all 0.3s ease;
        }

        .photo-box:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(183, 198, 218, 0.3);
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 6px;
        }

        .section {
            margin: 5mm 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section:last-of-type {
            margin-bottom: 6mm;
        }

        .section-title {
            background: var(--gradient);
            color: white;
            padding: 6px 12px;
            font-weight: 700;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4mm;
            font-size: 12px;
            box-shadow: 0 2px 6px rgba(6, 65, 128, 0.2);
            position: relative;
            overflow: hidden;
        }

        .section-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .section-title:hover::before {
            left: 100%;
        }

        .grid {
            display: grid;
            gap: 4mm 5mm;
            grid-template-columns: 1fr 1fr;
        }

        .grid.triple {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3mm 4mm;
        }

        .grid .full {
            grid-column: 1/-1;
        }

        .grid .span2 {
            grid-column: span 2;
        }

        .grid .span3 {
            grid-column: span 3;
        }

        .field {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 6px;
            padding: 8px 10px;
            border: 1px solid #e8eef7;
            transition: all 0.3s ease;
            position: relative;
        }

        .field:hover {
            border-color: var(--accent);
            box-shadow: 0 2px 8px rgba(150, 121, 71, 0.1);
            transform: translateY(-1px);
        }

        label {
            font-size: 12px;
            color: var(--brand);
            font-weight: 600;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        label::before {
            content: '●';
            color: var(--accent);
            font-size: 8px;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid #e8eef7;
            border-radius: 6px;
            background: #fafbfc;
            outline: none;
            transition: all 0.3s ease;
            font-size: 12px;
            height: 36px;
            font-family: inherit;
        }

        textarea {
            min-height: 60px;
            resize: vertical;
            height: auto;
            padding: 8px 12px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--brand);
            background: white;
            box-shadow: 0 0 0 3px rgba(6, 65, 128, 0.1);
            transform: translateY(-1px);
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8mm;
            margin: 4mm 0;
        }

        .row.single {
            grid-template-columns: 1fr;
        }

        .inline {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 12px;
            background: var(--light-bg);
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .check {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .check:hover {
            background: rgba(6, 65, 128, 0.05);
        }

        .check input {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: var(--brand);
        }

        .rating {
            display: flex;
            align-items: center;
            /* gap: 8px; */
            /* flex-wrap: wrap; */
            font-size: 10px;
            background: var(--light-bg);
            padding: 16px;
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .rating .num {
            width: 32px;
            height: 32px;
            border: 2px solid #d9e1ee;
            border-radius: 6px;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .rating .num:hover {
            border-color: var(--brand);
            transform: scale(1.1);
        }

        .rating input {
            display: none;
        }

        .rating input:checked+.num {
            background: var(--gradient);
            color: #fff;
            border-color: var(--brand);
            box-shadow: 0 2px 8px rgba(6, 65, 128, 0.3);
        }

        .answer-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            min-height: 50px;
            transition: all 0.3s ease;
        }

        .answer-box:hover {
            border-color: var(--accent);
            background: white;
        }

        .answer-box p {
            margin: 0;
            font-size: 13px;
            color: var(--ink);
        }

        .answer-tag {
            display: inline-block;
            background: linear-gradient(135deg, #e3f2fd 0%, #f0f8ff 100%);
            color: var(--brand);
            border: 1px solid #90caf9;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            margin: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .answer-tag:hover {
            background: linear-gradient(135deg, #bbdefb 0%, #e1f5fe 100%);
            border-color: #64b5f6;
            transform: translateY(-1px);
        }

        footer {
            margin-top: 6mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 15px;
            border-top: 2px solid var(--accent);
            padding-top: 4mm;
            font-size: 9px;
            color: var(--muted);
            background: var(--light-bg);
            padding: 12px 15px;
            border-radius: 6px;
        }

        .sign {
            display: grid;
            gap: 4mm;
        }

        .sign strong {
            font-size: 12px;
            color: var(--brand);
            font-weight: 700;
        }

        .line {
            height: 30px;
            border-bottom: 2px dashed var(--accent);
            margin: 4mm 0;
            position: relative;
        }

        .contact-info {
            text-align: left;
            direction: ltr;
            line-height: 1.6;
            font-size: 10px;
        }

        .no-print {
            margin-top: 15px;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
            padding: 10px;
            background: var(--light-bg);
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        /* تحسينات الطباعة - مُحسن لحجم A4 */
        @page {
            size: A4 portrait;
            margin: 10mm 8mm 8mm 8mm;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            body {
                /* background: #fff !important; */
                height: 100vh !important;
                font-size: 15px !important;
                line-height: 1.3 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .sheet {
                width: 100% !important;
                height: 100vh !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                page-break-inside: avoid;
            }

            .sheet::before {
                display: none !important;
            }

            .content-wrapper {
                padding: 5mm 3mm !important;
            }

            .no-print {
                display: none !important;
            }

            /* تحسين الهيدر للطباعة */
            header {
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
                margin-bottom: 4mm !important;
                padding: 6px 8px !important;
                /* background: #f8f9fa !important;
                border: 1px solid #064180 !important; */
                border-radius: 4px !important;
                page-break-inside: avoid;
            }

            header::before {
                display: none !important;
            }

            .logo {
                width: 32px !important;
                height: 32px !important;
                /* border: 2px solid var(--accent) !important; */
                border-radius: 6px !important;
                font-size: 9px !important;
                /* background: white !important; */
            }

            .brand h1 {
                font-size: 12px !important;
                margin-bottom: 2px !important;
            }

            .brand .sub {
                font-size: 7px !important;
                line-height: 1.2 !important;
            }

            .photo-box {
                width: 30mm !important;
                height: 38mm !important;
                border-radius: 4px !important;
                font-size: 10px !important;
            }

            .logo {
                width: 40px !important;
                height: 40px !important;
                font-size: 12px !important;
            }

            /* تحسين الأقسام */
            .section {
                margin: 3mm 0 !important;
                page-break-inside: avoid;
            }

            .section-title {
                /* background: #064180 !important;
                color: white !important; */
                padding: 3px 6px !important;
                font-size: 9px !important;
                font-weight: 700 !important;
                border-radius: 3px !important;
                margin-bottom: 2mm !important;
                box-shadow: none !important;
                display: inline-block !important;
            }

            .section-title::before {
                display: none !important;
            }

            /* تحسين الشبكة */
            .grid {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 2mm 3mm !important;
            }

            .grid.triple {
                grid-template-columns: 1fr 1fr 1fr !important;
                gap: 2mm !important;
            }

            .grid .full {
                grid-column: 1/-1 !important;
            }

            .grid .span2 {
                grid-column: span 2 !important;
            }

            .grid .span3 {
                grid-column: span 3 !important;
            }

            /* تحسين الحقول */
            .field {
                /* background: white !important; */
                /* border: 1px solid #ccc !important; */
                border-radius: 3px !important;
                padding: 4px 6px !important;
                margin: 0 !important;
                box-shadow: none !important;
                transform: none !important;
                page-break-inside: avoid;
            }

            .field:hover {
                /* border-color: #ccc !important; */
                box-shadow: none !important;
                transform: none !important;
            }

            label {
                font-size: 8px !important;
                font-weight: 600 !important;
                /* color: #064180 !important; */
                margin-bottom: 2px !important;
                display: block !important;
            }

            label::before {
                display: none !important;
            }

            input[type="text"],
            input[type="date"],
            input[type="tel"],
            input[type="number"],
            select,
            textarea {
                font-size: 8px !important;
                padding: 2px 4px !important;
                /* border: 1px solid #999 !important; */
                border-radius: 2px !important;
                /* background: white !important; */
                height: 20px !important;
                box-shadow: none !important;
                transform: none !important;
            }

            textarea {
                height: 30px !important;
                min-height: 30px !important;
            }

            input:focus,
            select:focus,
            textarea:focus {
                /* border-color: #999 !important; */
                box-shadow: none !important;
                transform: none !important;
            }

            /* تحسين الصفوف */
            .row {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 3mm !important;
                margin: 2mm 0 !important;
            }

            .row.single {
                grid-template-columns: 1fr !important;
            }

            .inline {
                display: flex !important;
                align-items: center !important;
                gap: 6px !important;
                flex-wrap: wrap !important;
                font-size: 8px !important;
                /* background: #f8f9fa !important; */
                padding: 4px 6px !important;
                /* border: 1px solid #ccc !important; */
                border-radius: 3px !important;
            }

            .check {
                font-size: 8px !important;
                gap: 3px !important;
                padding: 2px 4px !important;
            }

            .check input {
                width: 12px !important;
                height: 12px !important;
            }

            /* تحسين التقييم */
            .rating {
                display: flex;
                align-items: center;
                /* مسافة بين العناصر */
                flex-wrap: nowrap;
                /* يمنع النزول لسطر تاني */
                overflow-x: auto;
                /* في حالة الأرقام كتيرة جدا */
                white-space: nowrap;
            }

            .rating .check {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .rating .check input {
                display: none;
                /* نخفي الراديو الأصلي */
            }

            .rating .check .num {
                display: inline-block;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                /* border: 1px solid var(--brand, #064180);
                color: var(--brand, #064180); */
                font-size: 13px;
                text-align: center;
                line-height: 24px;
                cursor: pointer;
                transition: all 0.2s ease-in-out;
            }

            .rating .check input:checked+.num {
                /* background: var(--brand, #064180); */
                color: #fff;
            }


            /* تحسين صناديق الإجابات */
            .answer-box {
                /* background: #f8f9fa !important;
                border: 1px solid #ddd !important; */
                border-radius: 3px !important;
                padding: 4px 6px !important;
                min-height: 25px !important;
            }

            .answer-box:hover {
                /* border-color: #ddd !important;
                background: #f8f9fa !important; */
            }

            .answer-box p {
                font-size: 8px !important;
                margin: 0 !important;
                line-height: 1.3 !important;
            }

            .answer-tag {
                /* background: #e3f2fd !important;
                color: #064180 !important;
                border: 1px solid #90caf9 !important; */
                border-radius: 3px !important;
                padding: 2px 4px !important;
                font-size: 7px !important;
                font-weight: 500 !important;
                margin: 1px !important;
                display: inline-block !important;
                box-shadow: none !important;
            }

            .answer-tag:hover {
                /* background: #e3f2fd !important; */
                transform: none !important;
            }

            /* تحسين الفوتر */
            footer {
                margin-top: 4mm !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: flex-start !important;
                gap: 8px !important;
                border-top: 1px solid #064180 !important;
                padding: 4mm 3mm 2mm !important;
                font-size: 7px !important;
                color: #333 !important;
                background: white !important;
                margin-left: -3mm !important;
                margin-right: -3mm !important;
                page-break-inside: avoid;
            }

            .sign {
                display: grid !important;
                gap: 2mm !important;
                min-width: 40mm !important;
            }

            .sign strong {
                font-size: 8px !important;
                color: #064180 !important;
                font-weight: 700 !important;
            }

            .line {
                height: 15px !important;
                border-bottom: 1px dashed #967947 !important;
                margin: 1mm 0 !important;
            }

            .contact-info {
                text-align: left !important;
                direction: ltr !important;
                line-height: 1.4 !important;
                font-size: 6px !important;
                flex: 1 !important;
            }

            .contact-info div {
                margin-bottom: 1px !important;
            }

            /* منع تقطيع الصفحات */
            .section {
                page-break-inside: avoid;
            }

            .field {
                page-break-inside: avoid;
            }

            header {
                page-break-after: avoid;
            }

            footer {
                page-break-before: auto;
            }

            /* إخفاء الانيميشن في الطباعة */
            * {
                animation: none !important;
                transition: none !important;
            }

            body {
                font-size: 13px !important;
                line-height: 1.5 !important;
            }

            .brand h1 {
                font-size: 16px !important;
            }

            .brand .sub {
                font-size: 10px !important;
            }

            label {
                font-size: 11px !important;
            }

            input[type="text"],
            input[type="date"],
            input[type="tel"],
            input[type="number"],
            select,
            textarea {
                font-size: 11px !important;
                height: 26px !important;
                padding: 3px 6px !important;
            }

            .answer-box p,
            .answer-tag {
                font-size: 11px !important;
            }

            footer {
                font-size: 10px !important;
            }

            .sign strong {
                font-size: 11px !important;
            }

            .contact-info {
                font-size: 9px !important;
            }
        }

        /* للشاشات الصغيرة فقط */
        @media (max-width: 900px) {
            /* .sheet {
                width: auto;
                height: auto;
                margin: 10px;
                border-radius: 8px;
            } */

            .content-wrapper {
                padding: 8px;
            }

            .grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px;
            }

            .row {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px;
            }

            .photo-box {
                width: 22mm;
                height: 28mm;
            }

            header {
                padding: 12px 15px;
                gap: 12px;
            }

            .brand h1 {
                font-size: 20px !important;
            }

            .rating {
                justify-content: center;
            }

            .cv-footer {
                margin-top: 10mm;
                padding-top: 5mm;
                border-top: 1px solid #967947;
                /* نفس لون الـ accent */
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 12px;
                font-size: 10px;
                color: #444;
            }

            .cv-footer .sign {
                flex: 1;
                max-width: 40%;
            }

            .cv-footer .sign strong {
                display: block;
                margin-bottom: 3mm;
                font-size: 11px;
                color: #064180;
                /* لون البراند */
            }

            .cv-footer .sign .line {
                height: 20px;
                border-bottom: 1px dashed #bbb;
                margin: 3mm 0;
            }

            .cv-footer .contact-info {
                flex: 2;
                text-align: left;
                direction: ltr;
                font-size: 9.5px;
                line-height: 1.5;
                color: #555;
            }

            .cv-footer .contact-info strong {
                color: #064180;
                /* إبراز العناوين */
            }
        }
    </style>
</head>

<body>
    @foreach ($leads as $lead)
        <main class="sheet" style="padding-bottom: 20px">
            @php
                $questions = App\Models\JobQuestion::where('job_title_id', $lead->job_title_id)
                    ->with([
                        'answers' => function ($q) use ($lead) {
                            $q->where('lead_id', $lead->id);
                        },
                    ])
                    ->get();
            @endphp
            <div class="content-wrapper" style="padding-bottom: 20px;">
                <header>
                    <div class="photo-box">
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="شعار الشركة">
                    </div>
                    <div class="brand">
                        <h1>{{ $company->name }}</h1>
                        <div class="sub">لإلحاق العمالة المصرية بالخارج - ترخيص ({{ $company->license_number }})
                        </div>
                    </div>
                    <div class="photo-box">
                        <img src="{{ asset('storage/' . $lead->image) }}" alt="صورة المتقدم">
                    </div>
                </header>

                <section class="section">
                    <div class="section-title">البيانات الشخصية</div>
                    <div class="grid">
                        <div class="field">
                            <label>الاسم الكامل</label>
                            <input type="text" placeholder="الاسم ثلاثي" value="{{ $lead->name }}">
                        </div>
                        <div class="field">
                            <label>تاريخ الميلاد</label>
                            <input type="text" value="{{ $lead->date_of_birth }}">
                        </div>
                        <div class="field">
                            <label>العمر (سنة)</label>
                            @php
                                $age = '';
                                if ($lead->date_of_birth) {
                                    try {
                                        $dob = \Carbon\Carbon::createFromFormat('d/m/Y', $lead->date_of_birth);
                                        $age = $dob->age;
                                    } catch (\Exception $e) {
                                        $age = ''; // صيغة غير صحيحة، ترك الحقل فارغ
                                    }
                                }
                            @endphp
                            <input type="number" min="16" max="80" placeholder="30"
                                value="{{ $lead->age ?? ($age ?? '') }}">
                        </div>
                        <div class="field">
                            <label>جهة الميلاد</label>
                            <input type="text" value="{{ $lead->governorate }}">
                        </div>
                        <div class="field">
                            <label>الوظيفة المقدم عليها</label>
                            @php
                                $jobTitle = $lead->jobTitle->title ?? '— لا توجد وظيفة —';
                                $cleanTitle = preg_replace('/.*-(.*?)\s*\*.*/u', '$1', $jobTitle);
                            @endphp

                            <input type="text" value="{{ $cleanTitle }}">

                        </div>
                    </div>
                </section>

                <section class="section">
                    <div class="section-title">بيانات إضافية</div>
                    <div class="grid triple">
                        @foreach ($questions as $q)
                            <div class="field {{ in_array($q->type, ['textarea']) ? 'span2' : '' }}">
                                <label>
                                    {{ $q->question }}
                                </label>
                                <div class="answer-box">
                                    @if ($q->answers->isNotEmpty())
                                        @if ($q->type === 'checkbox')
                                            @foreach ($q->answers as $ans)
                                                <span class="answer-tag">
                                                    {{ $ans->answer }}
                                                </span>
                                            @endforeach
                                        @else
                                            <p class="answer-tag">
                                                {{ $q->answers->first()->answer ?? '— لا توجد إجابة —' }}
                                            </p>
                                        @endif
                                    @else
                                        <p style="color: var(--muted); font-style: italic;">— لا توجد إجابة —</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="section">
                    <div class="section-title">بيانات السفر والخبرة</div>
                    <div class="row">
                        <div class="inline">
                            <label style="display:inline; margin:0; font-weight: 600;">هل سبق لك العمل بالخارج؟</label>
                            <label class="check"><input type="radio" name="abroad"> نعم</label>
                            <label class="check"><input type="radio" name="abroad"> لا</label>
                        </div>
                        <div class="inline">
                            <label style="display:inline; margin:0; font-weight: 600;">حالة جواز السفر:</label>
                            <label class="check"><input type="radio" name="passport"> ساري</label>
                            <label class="check"><input type="radio" name="passport"> منتهي</label>
                            <label class="check"><input type="radio" name="passport"> غير موجود</label>
                        </div>
                    </div>
                </section>

                <section class="section">
                    <div class="section-title">تقييم المقابلة الشخصية</div>
                    <div class="rating">
                        <span style="font-weight: 600; color: var(--brand);">ضعيف</span>
                        <label class="check">
                            <span class="num">1</span>
                        </label>
                        <label class="check">
                            <span class="num">2</span>
                        </label>
                        <label class="check">
                            <span class="num">3</span>
                        </label>
                        <label class="check">
                            <span class="num">4</span>
                        </label>
                        <label class="check">
                            <span class="num">5</span>
                        </label>
                        <label class="check">
                            <span class="num">6</span>
                        </label>
                        <label class="check">
                            <span class="num">7</span>
                        </label>
                        <label class="check">
                            <span class="num">8</span>
                        </label>
                        <label class="check">
                            <span class="num">9</span>
                        </label>
                        <label class="check">
                            <span class="num">10</span>
                        </label>
                        <span style="font-weight: 600; color: var(--brand);">ممتاز</span>
                    </div>
                </section>
                <footer class="cv-footer" style="">
                    <div class="sign">
                        <strong>توقيع مسؤول المقابلة</strong>
                        <div class="line"></div>
                        <div>الاسم: ..................................................</div>
                    </div>
                    <div class="contact-info" style="margin: auto 0;">
                        <div><strong>العنوان:</strong> 38 ش صلاح سالم – ربيع حامد – بجوار محكمة شبرا – محطة مترو
                            الخلفاوي –
                            الدور 6 شقة 60</div>
                        <div><strong>الهاتف:</strong> 0235681797 – <strong>المحمول:</strong> 01288000239 – 01288000245
                        </div>
                        <div><strong>البريد الإلكتروني:</strong> K1173@yahoo.com – <strong>الموقع:</strong> elmethaq.com
                        </div>
                    </div>
                </footer>
            </div>
        </main>
    @endforeach
</body>

</html>
