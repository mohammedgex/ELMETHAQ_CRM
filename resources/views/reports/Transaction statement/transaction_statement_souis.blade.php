<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>نموذج تسليم معاملات</title>

    <style>
        /* ----- خطوط وتهيئة عامة (محلية فقط) ----- */
        .ts-body {
            font-family: 'Cairo', Tahoma, Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
            color: #111;
        }

        .ts-container {
            width: 900px;
            margin: 30px auto;
            border: 1px solid #222;
            padding: 0;
            background: #fff;
        }

        .ts-page {
            page-break-after: always;
            margin-bottom: 30px;
        }

        .ts-page:last-child {
            page-break-after: avoid;
        }

        .ts-title {
            text-align: center;
            margin: 20px 0 10px 0;
            font-size: 22px;
            font-weight: bold;
        }

        .ts-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .ts-info-table td {
            border: 1px solid #222;
            padding: 10px 8px;
            font-size: 18px;
            text-align: center;
        }

        .ts-data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .ts-data-table th,
        .ts-data-table td {
            border: 1px solid #222;
            padding: 10px 8px;
            text-align: center;
            font-size: 18px;
        }

        .ts-data-table th {
            background: linear-gradient(45deg, #f4f6f9, #e9eef8);
            font-weight: 600;
            color: #0b1220;
        }

        .ts-passport {
            font-weight: bold;
            color: #222;
        }

        .ts-footer {
            width: 900px;
            margin: 30px auto 20px auto;
            font-size: 16px;
            text-align: right;
            direction: rtl;
            color: #444;
            padding-top: 10px;
        }

        .ts-footer-line {
            margin-bottom: 6px;
            line-height: 1.7;
        }

        .ts-footer b {
            color: #222;
            font-weight: bold;
            font-size: 17px;
        }

        .ts-controls {
            width: 900px;
            margin: 20px auto;
            text-align: center;
            direction: rtl;
        }

        .ts-controls button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 18px;
            margin: 0 6px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        .ts-controls button:hover {
            background: #0056b3;
        }

        .ts-page-number {
            text-align: center;
            font-size: 18px;
            margin: 10px 0;
            font-weight: bold;
        }

        /* Responsive print-friendly adjustments */
        @media print {
            .ts-controls {
                display: none !important;
            }

            .ts-page {
                page-break-after: always;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .ts-container,
            .ts-footer {
                width: 100%;
                max-width: none;
                margin: 0;
                border: none;
                padding: 10px 15px;
                box-sizing: border-box;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
            }

            @page {
                size: A4;
                margin: 15mm 15mm 15mm 15mm;
            }

            .ts-info-table td,
            .ts-data-table th,
            .ts-data-table td {
                padding: 8px 6px;
                font-size: 16px;
            }

            .ts-title {
                font-size: 20px;
                margin: 12px 0;
            }

            .ts-page-number {
                font-size: 16px;
            }

            .ts-footer-line {
                font-size: 14px;
                line-height: 1.6;
            }
        }
    </style>
</head>

<body class="ts-body">

    {{-- Controls (print + refresh) --}}
    <div class="ts-controls" id="ts-controls">
        <button id="btn-print" type="button">طباعة</button>
    </div>

    {{-- {{ dd($customers) }} --}}
    {{-- الصفحة الأولى (تُستخدم كقالب) --}}

    {{-- المكان الذي ستنشأ وتعرض فيه الصفحات --}}
    <div id="pages-container">
        {{-- سيتم إنشاء الصفحة الأولى افتراضياً إذا لزم --}}
    </div>

    <script>
        /***** إعدادات محلية *****/
        const rowsPerPage = 15; // عدد الصفوف في كل صفحة
        let globalData = [];
        const customersFromServer = @json($customers ?? [], JSON_UNESCAPED_UNICODE);

        console.log(customersFromServer);
        /* دالة هروب النص للعرض الآمن (تجنّب HTML injection) */
        function escapeHtml(str) {
            return String(str || '')
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        /* إنشاء صفحة جديدة كاملة بالقالب (جدول + footer) */
        function createNewPage(pageNum) {
            const pagesContainer = document.getElementById('pages-container');
            const newPage = document.createElement('div');
            newPage.className = 'ts-page';
            newPage.id = `ts-page-${pageNum}`;

            newPage.innerHTML = `
                <div class="ts-container">
                    <h2 class="ts-title">نموذج تسليم معاملات</h2>

                    <table class="ts-info-table">
                        <tr>
                            <td colspan="2">اسم المكتب / <b>شركة الميثاق لالحاق العمالة المصرية بالخارج ترخيص (768)</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="ts-delegate-row">اسم المندوب / <span id="ts-delegate-name">احمد بشير</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="ts-date-row">اليوم : <span id="ts-day">.............</span> &nbsp;&nbsp; التاريخ : <span id="ts-date">.............</span></td>
                        </tr>
                    </table>

                    <table class="ts-data-table" id="ts-table-${pageNum}">
                        <tr>
                            <th>م</th>
                            <th>الاسم</th>
                            <th>رقم الجواز</th>
                            <th>نوع المعاملة</th>
                        </tr>
                    </table>
                </div>

                <div class="ts-footer">
                    <div class="ts-footer-line"> المستلم /</div>
                    <div class="ts-footer-line">أقر أنا مندوب مكتب <b>شركة الميثاق لالحاق العمالة المصرية بالخارج ترخيص (768)</b></div>
                    <div class="ts-footer-line">بأنني استلمت جميع المعاملات المشار إليها في البيان أعلاه وعلى هذا جرى التوقيع .</div>
                    <div class="ts-footer-line">الاسم /</div>
                    <div class="ts-footer-line">التوقيع /</div>
                </div>
            `;

            pagesContainer.appendChild(newPage);
        }

        /* تحديث جدول صفحة معينة: يعيد بناء رأس الجدول ثم يضيف الصفوف المناسبة */
        function updateTable(pageNum) {
            const table = document.getElementById(`ts-table-${pageNum}`);
            if (!table) return;

            // رأس الجدول ثابت
            const headerHTML = `
                <tr>
                    <th>م</th>
                    <th>الاسم</th>
                    <th>رقم الجواز</th>
                    <th>نوع المعاملة</th>
                </tr>
            `;
            table.innerHTML = headerHTML;

            const startIndex = (pageNum - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, globalData.length);

            for (let i = startIndex; i < endIndex; i++) {
                const idx = i + 1;
                const row = document.createElement('tr');

                // استخدم حقول name_ar و passport_id و customer_group.visa_type.visa_peroid إن وجدت
                const name = escapeHtml(globalData[i].name || '');
                const passport = escapeHtml(globalData[i].passport || '');
                const type = escapeHtml(globalData[i].type || '');

                row.innerHTML = `
                    <td>${idx}</td>
                    <td>${name}</td>
                    <td class="ts-passport">${passport}</td>
                    <td>${type}</td>
                `;
                table.appendChild(row);
            }

            // لو الصف أقل من rowsPerPage، نترك الصفوف الفارغة (اختياري) — حالياً نتركها فارغة
        }

        /* إعادة بناء كل الصفحات: إنشاء/حذف صفحات حسب طول البيانات */
        function updateAllPages() {
            const pagesContainer = document.getElementById('pages-container');

            // نحسب عدد الصفحات المطلوبة (على الأقل صفحة واحدة)
            const neededPages = Math.max(1, Math.ceil(globalData.length / rowsPerPage));

            // نزيل كل الصفحات الحالية ثم نعيد إنشاء العدد المطلوب لضمان تناسق DOM
            pagesContainer.innerHTML = '';
            for (let p = 1; p <= neededPages; p++) {
                createNewPage(p);
            }

            for (let p = 1; p <= neededPages; p++) {
                updateTable(p);
            }

            // تحديث أرقام الصفحة الظاهرة (اختياري)
            const pageNumbers = document.querySelectorAll('.ts-page-number');
            pageNumbers.forEach((el, idx) => el.textContent = `الصفحة ${idx + 1}`);
        }

        /* تحميل البيانات من الـ Blade (customersFromServer) وتحويلها للشكل المطلوب */
        function loadDataFromServerArray(arr) {
            if (!Array.isArray(arr)) return;
            globalData = arr.map(item => ({
                // نحاول استخلاص الحقول بأكثر من اسم محتمل
                name: item.name_ar ?? item.name ?? '',
                passport: item.passport_id ?? item.passport ?? '',
                type: item.customer_group?.visa_type?.visa_peroid ?? item.type ?? ''
            }));
            updateAllPages();
        }

        /* تحميل أي بيانات موجودة مسبقاً في أول جدول (لو أردت دعم هذا) */
        function loadExistingTableData() {
            const firstTable = document.getElementById('ts-table-1');
            if (!firstTable) return;
            const rows = firstTable.querySelectorAll('tr');
            // في حال وجدنا صفوف إضافية يملؤها المستخدم يدوياً، نأخذها
            const temp = [];
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].querySelectorAll('td');
                if (cells.length >= 4) {
                    temp.push({
                        name: cells[1].textContent.trim(),
                        passport: cells[2].textContent.trim(),
                        type: cells[3].textContent.trim()
                    });
                }
            }
            if (temp.length) {
                globalData = temp;
            }
        }

        /* زر الطباعة */
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'btn-print') {
                window.print();
            }
            if (e.target && e.target.id === 'btn-refresh') {
                // إعادة بناء العرض
                updateAllPages();
            }
        });

        /* عند التحميل: نملأ البيانات مرة واحدة من المصفوفة الممررة من الـ Blade */
        // window.addEventListener('load', function() {
        //     // 1) املأ من أي جدول موجود مسبقاً (اختياري)
        //     loadExistingTableData();

        //     // 2) إذا لا توجد بيانات محلياً، املأ من server variable
        //     if ((!globalData || globalData.length === 0) && Array.isArray(customersFromServer) &&
        //         customersFromServer.length > 0) {
        //         loadDataFromServerArray(customersFromServer);
        //     } else {
        //         // حتى لو كانت globalData غير فارغة (تم ملؤها يدوياً)، نحدث العرض
        //         updateAllPages();
        //     }

        //     // ضع قيم افتراضية للمندوب والتاريخ إن رغبت
        //     const delegateNameEl = document.getElementById('ts-delegate-name');
        //     const dayEl = document.getElementById('ts-day');
        //     const dateEl = document.getElementById('ts-date');
        //     if (delegateNameEl && delegateNameEl.textContent.trim() === '') delegateNameEl.textContent =
        //         'احمد بشير';
        //     if (dayEl && dayEl.textContent.trim() === '') dayEl.textContent = '.............';
        //     if (dateEl && dateEl.textContent.trim() === '') dateEl.textContent = '.............';
        // });
        window.addEventListener('load', function() {
            // 1) املأ من أي جدول موجود مسبقاً
            loadExistingTableData();

            // 2) إذا لا توجد بيانات محلياً، املأ من server variable
            if ((!globalData || globalData.length === 0) && Array.isArray(customersFromServer) &&
                customersFromServer.length > 0) {
                loadDataFromServerArray(customersFromServer);
            } else {
                updateAllPages();
            }

            // --- ⬇️ هنا نسأل المستخدم ---
            let delegateName = prompt("ادخل اسم المندوب:", "احمد بشير");
            let day = prompt("ادخل اليوم:", new Date().toLocaleDateString("ar-EG", {
                weekday: 'long'
            }));
            let date = prompt("ادخل التاريخ:", new Date().toLocaleDateString("ar-EG"));

            // إذا المستخدم ضغط Cancel، نخلي القيم كما هي
            if (delegateName) {
                const delegateNameEls = document.querySelectorAll('#ts-delegate-name');
                delegateNameEls.forEach(el => el.textContent = delegateName);
            }

            if (day) {
                const dayEls = document.querySelectorAll('#ts-day');
                dayEls.forEach(el => el.textContent = day);
            }

            if (date) {
                const dateEls = document.querySelectorAll('#ts-date');
                dateEls.forEach(el => el.textContent = date);
            }
        });
    </script>
</body>

</html>
