<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>كشف دخول جوازات - تمركز كامل</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        body {
            font-family: "Cairo", Tahoma, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .controls {
            text-align: center;
            margin: 20px;
        }

        .controls button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .controls button:hover {
            background: #0056b3;
        }

        /* الصفحة A4 */
        .page {
            width: 210mm;
            height: 297mm;
            margin: auto;
            box-sizing: border-box;
            page-break-after: always;
            background: url("{{ asset('./Screenshot_1.png') }}") no-repeat center center;
            background-size: cover;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;

            /* تمركز المحتوى كامل */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .page-content {
            text-align: center;
            background: transparent;
        }

        h2 {
            margin: 0 0 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .info-table,
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
            margin-bottom: 10px;
        }

        .info-table td,
        .data-table th,
        .data-table td {
            border: 1px solid rgba(0, 0, 0, 0.6);
            padding: 6px 8px;
            font-size: 14px;
            background: transparent !important;
            text-align: center;
        }

        .data-table th {
            background: rgba(255, 255, 255, 0.3) !important;
        }

        .tdbarcode {
            padding: 4px !important;
        }

        .footer {
            font-size: 14px;
            margin-top: 10px;
            text-align: right;
            direction: rtl;
        }

        .footer-line {
            margin-bottom: 4px;
        }

        @media print {
            .controls {
                display: none;
            }

            @page {
                size: A4;
                margin: 0;
            }

            .page {
                margin: 0;
            }
        }
    </style>
</head>

<body style="font-family: 'Cairo', Tahoma, Arial, sans-serif; font-weight: bold;">

    <div class="controls">
        <button onclick="window.print()">طباعة</button>
    </div>

    <div id="pages-container"></div>
    <script>
        const rowsPerPage = 5;
        let globalData = @json(array_values($customers ?? []));

        function escapeHtml(s) {
            return String(s || '').replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [m]));
        }

        function createFooter() {
            return `
            <div style="display:flex;justify-content:space-between;margin-top:50px;">
              <div>ختم الشركة /</div>
              <div>المدير المسؤول /</div>
              <div>التوقيع /</div>
            </div>
        `;
        }

        function createPage(dataSlice, pageIndex, headerData, isFirst) {
            let headerHtml = '';
            if (isFirst) {
                headerHtml = `
                <h2>كشف دخول جوازات</h2>
                <table class="info-table">
                  <tr>
                    <td colspan="2">اسم المكتب / <b>شركة الميثاق لالحاق العمالة المصرية بالخارج ترخيص (768)</b></td>
                  </tr>
                  <tr>
                    <td colspan="2">صندوق رقم (<span>${escapeHtml(headerData.boxNumber)}</span>) ترخيص رقم ( <span>768</span> )</td>
                  </tr>
                  <tr>
                    <td colspan="2">نوع التاشيرة ( <span>عمل مؤقت</span> )</td>
                  </tr>
                  <tr>
                    <td colspan="2">اليوم : <span>${escapeHtml(headerData.day)}</span> &nbsp;&nbsp; التاريخ : <span>${escapeHtml(headerData.date)}</span></td>
                  </tr>
                </table>
            `;
            }

            let tableHtml = `
            <table class="data-table">
                <tr>
                    <th>م</th>
                    <th>الاسم</th>
                    <th>الباركود</th>
                </tr>
        `;
            dataSlice.forEach((item, i) => {
                const index = pageIndex * rowsPerPage + i + 1;
                tableHtml += `
                <tr>
                    <td>${index}</td>
                    <td style="font-weight: bold;">${escapeHtml(item.name_ar ?? item.name ?? '')}</td>
                    <td class="tdbarcode"><svg id="barcode-${pageIndex}-${i}"></svg></td>
                </tr>
            `;
            });
            tableHtml += `</table>`;

            return `
            <div class="page">
                <div class="page-content">
                    ${headerHtml}
                    ${tableHtml}
                    ${createFooter()}
                </div>
            </div>
        `;
        }

        function renderPages(headerData) {
            const container = document.getElementById('pages-container');
            container.innerHTML = '';
            const totalPages = Math.ceil(globalData.length / rowsPerPage);
            for (let p = 0; p < totalPages; p++) {
                const slice = globalData.slice(p * rowsPerPage, (p + 1) * rowsPerPage);
                container.innerHTML += createPage(slice, p, headerData, p === 0);
            }
            globalData.forEach((item, i) => {
                const page = Math.floor(i / rowsPerPage);
                const row = i % rowsPerPage;
                JsBarcode(`#barcode-${page}-${row}`, item.e_visa_number ?? item.visa_number ?? '', {
                    format: "CODE128",
                    displayValue: true,
                    width: 2,
                    height: 40
                });
            });
        }

        window.onload = function() {
            const boxNumber = prompt("أدخل صندوق رقم:", "");
            const day = prompt("أدخل اليوم:", "");
            const date = prompt("أدخل التاريخ:", new Date().toLocaleDateString('ar-EG'));
            renderPages({
                boxNumber: boxNumber || '........',
                day: day || '.............',
                date: date || '.............'
            });
        };
    </script>


</body>

</html>
