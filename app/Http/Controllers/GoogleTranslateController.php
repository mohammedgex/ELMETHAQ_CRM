<?php

namespace App\Http\Controllers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class GoogleTranslateController extends Controller
{
    // public function translateName($name)
    // {
    //     // تحديد لغة الترجمة (عربي)
    //     $tr = new GoogleTranslate('ar'); // 'ar' هي اللغة العربية

    //     // ترجمة الاسم
    //     $translatedName = $tr->translate($name);

    //     // عرض الاسم المترجم
    //     return $translatedName;
    // }

    public function translateText($name)
    {
        // إعداد رابط الـ API مع النص
        $url = 'https://api.mymemory.translated.net/get';
        $query = [
            'q' => $name,
            'langpair' => 'en|ar'
        ];

        // إجراء الطلب
        $response = Http::get($url, $query);

        // التحقق من وجود استجابة صحيحة
        if ($response->successful()) {
            // استرجاع الترجمة من استجابة الـ API
            $data = $response->json();

            // استخراج الاسم المترجم مباشرة
            $translatedText = $data['responseData']['translatedText'];

            return  $translatedText;
        }

        // في حال فشل الطلب، إرجاع رسالة خطأ
        return response()->json(['error' => 'Failed to get translation'], 400);
    }
}
