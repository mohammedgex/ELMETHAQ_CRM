<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Barcode - Centered Big Number</title>

    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <style>
        body {
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        img {
            border: 1px solid #ccc;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <svg id="barcodeSvg" xmlns="http://www.w3.org/2000/svg" style="display:none;"></svg>
    <img id="barcodeImg" alt="barcode image" />

    <script>
        const barcodeSvg = document.getElementById('barcodeSvg');
        const barcodeImg = document.getElementById('barcodeImg');

        // الإعدادات (حسب طلبك)
        const finalWidth = 520; // عرض الصورة بالبيكسل
        const finalHeight = 250; // الارتفاع الكلي بالبيكسل
        const barcodeHeight = 180; // ارتفاع الباركود نفسه بالبيكسل
        const barLineWidth = 4; // عرض العمود الواحد في الباركود

        // مناطق الرسم
        const barcodeArea = {
            x: 0,
            y: 0,
            width: finalWidth,
            height: barcodeHeight
        };
        const textArea = {
            x: 0,
            y: barcodeHeight,
            width: finalWidth,
            height: finalHeight - barcodeHeight
        };

        async function generateImage(code) {
            // توليد SVG بالباركود (بدون النص)
            JsBarcode(barcodeSvg, String(code), {
                format: "CODE128",
                lineColor: "#000",
                width: barLineWidth,
                height: barcodeArea.height,
                displayValue: false,
                margin: 0
            });

            // تحويل svg إلى صورة
            const svgData = new XMLSerializer().serializeToString(barcodeSvg);
            const svgBlob = new Blob([svgData], {
                type: "image/svg+xml;charset=utf-8"
            });
            const url = URL.createObjectURL(svgBlob);

            const img = await new Promise((resolve, reject) => {
                const image = new Image();
                image.onload = () => resolve(image);
                image.onerror = (e) => reject(e);
                image.src = url;
            });

            // canvas نهائي
            const canvas = document.createElement('canvas');
            canvas.width = finalWidth;
            canvas.height = finalHeight;
            const ctx = canvas.getContext('2d');

            // خلفية بيضاء
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // رسم الباركود لملء العرض بالكامل (نرسم الصورة ممدودة لعرض finalWidth)
            ctx.drawImage(img, 0, 0, finalWidth, barcodeArea.height);

            // الآن نرسم الرقم تحت الباركود - بخوارزمية تضمن التوسيط وعدم اختفاء أول رقم
            const numberText = String(code);
            ctx.fillStyle = '#000';
            ctx.textBaseline = 'middle';

            // هامش صغير حتى لا يلتصق الحرف بالأطراف
            const sidePadding = 6; // بيكسل

            // نختار أكبر حجم خط ممكن بحيث مجموع أحجام الحروف (مع تباعد اختياري) <= maxTextWidth
            const maxTextWidth = textArea.width - sidePadding * 2;
            let fontSize = Math.floor(textArea.height); // نبدأ بأقصى ارتفاع ممكن
            if (fontSize < 6) fontSize = 6;

            let charWidths = [];
            let textWidthSum = 0;

            // ننقص حجم الخط حتى تتناسب عرض الأحرف بدون تباعد
            while (fontSize > 6) {
                ctx.font = `bold ${fontSize}px Arial`;
                charWidths = Array.from(numberText).map(ch => ctx.measureText(ch).width);
                textWidthSum = charWidths.reduce((a, b) => a + b, 0);
                if (textWidthSum <= maxTextWidth) break;
                fontSize--;
            }

            // الآن نحسب تباعد الحروف المطلوب إذا كان النص أقصر من maxTextWidth
            let letterSpacing = 0;
            if (numberText.length > 1) {
                const extraSpace = maxTextWidth - textWidthSum;
                // نوزع الفراغ بالتساوي بين الحروف (لاجهزة الطباعة قد تحتاج تقليل القيمة لو كانت كبيرة)
                letterSpacing = extraSpace > 0 ? extraSpace / (numberText.length - 1) : 0;
            } else {
                letterSpacing = 0;
            }

            // نحسب العرض الكلي بعد إضافة التباعد
            const totalWidthAfterSpacing = textWidthSum + Math.max(0, letterSpacing * (numberText.length - 1));
            // نقطة البدء حتى يكون النص في المنتصف تمامًا
            let startX = textArea.x + (textArea.width - totalWidthAfterSpacing) / 2;

            // تأكد أن القيمة لا تقل عن الهامش
            if (startX < sidePadding) startX = sidePadding;

            // ارسم كل حرف بمحاذاة left (حتى لا يختفي أول حرف)
            ctx.textAlign = 'left';
            const centerY = textArea.y + textArea.height / 2;

            for (let i = 0; i < numberText.length; i++) {
                const ch = numberText[i];
                ctx.fillText(ch, startX, centerY);
                startX += charWidths[i] + letterSpacing;
            }

            // تحرير URL المؤقت
            URL.revokeObjectURL(url);

            return canvas.toDataURL('image/png');
        }

        // عند التحميل: أنشئ الصورة وأعرضها
        window.addEventListener('load', async () => {
            try {
                const code = "{{ $code }}"; // رقم الباركود
                const dataUrl = await generateImage(code);

                // تحويل Data URL إلى Blob ثم فتحه
                fetch(dataUrl)
                    .then(res => res.blob())
                    .then(blob => {
                        const blobUrl = URL.createObjectURL(blob);
                        window.location.href = blobUrl; // فتح في نفس التبويب
                    });

            } catch (e) {
                console.error('فشل التوليد:', e);
                alert('حدث خطأ أثناء توليد الصورة. افتح الكونسول للمزيد من التفاصيل.');
            }
        });
    </script>
</body>

</html>
