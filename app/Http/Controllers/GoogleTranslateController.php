<?php

namespace App\Http\Controllers;

use Stichoza\GoogleTranslate\GoogleTranslate;


use Illuminate\Http\Request;

class GoogleTranslateController extends Controller
{
    public function translateName($name)
    {
        // تحديد لغة الترجمة (عربي)
        $tr = new GoogleTranslate('ar'); // 'ar' هي اللغة العربية

        // ترجمة الاسم
        $translatedName = $tr->translate($name);

        // عرض الاسم المترجم
        return $translatedName;
    }
}
