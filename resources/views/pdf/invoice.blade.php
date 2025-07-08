<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بيانات مندوب</title>
    <style>
        body { font-family: 'Cairo', sans-serif; direction: rtl; text-align: right; margin: 20px; background-color: #f8f9fa; }
        .container { border: 3px solid #007bff; padding: 25px; border-radius: 15px; width: 600px; margin: auto; background: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        h2 { text-align: center; color: #007bff; font-size: 26px; margin-bottom: 20px; }
        .info { margin-bottom: 15px; font-size: 20px; color: #333; }
        .label { font-weight: bold; color: #007bff; font-size: 22px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { width: 120px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="" alt="شعار الشركة">
            <h2>شركة الميثاق لإلحاق العمالة</h2>
        </div>
        @if(isset($delegate))
    <p class="info"><span class="label">اسم المندوب:</span> {{ $delegate->name }}</p>
    <p class="info"><span class="label">الرقم القومي:</span> {{ $delegate->card_id }}</p>
    <p class="info"><span class="label">رقم الهاتف:</span> {{ $delegate->phone }}</p>
    <p class="info"><span class="label">تاريخ التسجيل:</span> {{ $delegate->created_at->format('Y-m-d') }}</p>
@else
    <p class="info">لم يتم العثور على بيانات المندوب.</p>
@endif
    </div>
</body>
</html>
