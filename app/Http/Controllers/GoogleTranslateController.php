<?php

namespace App\Http\Controllers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;


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
    protected function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/gmail_Oauth.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setRedirectUri(url('/google/oauth2callback'));
        $client->addScope(Google_Service_Gmail::GMAIL_SEND);

        // تحميل التوكن إذا موجود
        if (Storage::exists('gmail-token.json')) {
            $accessToken = json_decode(Storage::get('gmail-token.json'), true);
            $client->setAccessToken($accessToken);

            // تحديث التوكن إذا انتهت صلاحيته
            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    Storage::put('gmail-token.json', json_encode($client->getAccessToken()));
                } else {
                    Storage::delete('gmail-token.json');
                }
            }
        }

        return $client;
    }

    public function redirectToGoogle()
    {
        $client = $this->getClient();
        return redirect()->away($client->createAuthUrl());
    }

    public function handleCallback(Request $request)
    {
        $client = $this->getClient();
        if ($request->has('code')) {
            $accessToken = $client->fetchAccessTokenWithAuthCode($request->code);
            Storage::put('gmail-token.json', json_encode($accessToken));
            return "✅ تم تسجيل الدخول بنجاح إلى Gmail.";
        }

        return "❌ لم يتم العثور على الكود.";
    }

    public function sendTestEmail()
    {
        $client = $this->getClient();

        if (!$client->getAccessToken()) {
            return redirect('/google/auth');
        }

        $service = new Google_Service_Gmail($client);

        $strRawMessage = "From: اسمك <you@gmail.com>\r\n";
        $strRawMessage .= "To: test@example.com\r\n";
        $strRawMessage .= "Subject: Test Email from Laravel Gmail API\r\n";
        $strRawMessage .= "MIME-Version: 1.0\r\n";
        $strRawMessage .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
        $strRawMessage .= "هذه رسالة اختبار من Laravel باستخدام Gmail API.";

        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');

        $message = new Google_Service_Gmail_Message();
        $message->setRaw($mime);

        try {
            $service->users_messages->send("me", $message);
            return "📧 تم إرسال الرسالة بنجاح!";
        } catch (\Exception $e) {
            return "❌ فشل في الإرسال: " . $e->getMessage();
        }
    }
}
