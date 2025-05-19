<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Google\Client;
use Google\Service\Gmail;
use Smalot\PdfParser\Parser;
use App\Models\Customer;
use App\Models\History;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class JopController extends Controller
{
    public function net($id)
    {
        ini_set('max_execution_time', 300); // 5 minutes

        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->back()->with(['error' => 'Customer not found']);
        }

        // Check required fields exist
        if (
            empty($customer->name_ar) || empty($customer->name_en_mrz) ||
            empty($customer->passport_id) || empty($customer->passport_expire_date) ||
            empty($customer->date_birth) || empty($customer->card_id) ||
            !$customer->sponser || !$customer->visaType || !$customer->customerGroup ||
            !$customer->customerGroup->visaProfession
        ) {
            return redirect()->back()->with(['error' => 'الرجاء التأكد من اكمال بيانات العميل']);
        }

        $name_ar = explode(" ", $customer->name_ar);
        $name_en = explode(" ", $customer->name_en_mrz);

        if (count($name_ar) < 3 || count($name_en) < 3) {
            return response()->json(['error' => 'Invalid name format'], 400);
        }

        // Assign name parts safely
        $first_ar = $name_ar[0];
        $middle_ar = $name_ar[1] ?? '';
        $last_ar = $name_ar[2] ?? '';
        $end_ar = end($name_ar);

        $first_en = $name_en[0];
        $middle_en = $name_en[1] ?? '';
        $last_en = $name_en[2] ?? '';
        $end_en = end($name_en);

        $data = [
            "UserName" => "مكتب768",
            "Password" => "Ahmed121@@@",
            "VisaKind" => "تأشيرة العمل المؤقت لخدمات الحج والعمرة",
            "NATIONALITY" => "EGY",
            "ResidenceCountry" => "272",
            "EmbassyCode" => "320",
            "NumberOfEntries" => "0",
            "NumberEntryDay" => "90",
            "ResidencyInKSA" => "120",
            "AFIRSTNAME" => $first_ar,
            "AFATHER" => $middle_ar,
            "AGRAND" => $last_ar,
            "AFAMILY" => $end_ar,
            "EFIRSTNAME" => $first_en,
            "EFATHER" => $middle_en,
            "EGRAND" => $last_en,
            "EFAMILY" =>  $end_en,
            "PASSPORTnumber" => $customer->passport_id,
            "PASSPORType" => "1",
            "PASSPORT_ISSUE_PLACE" => "مصر",
            "PASSPORT_ISSUE_DATE" => "05/04/2023",
            "PASSPORT_EXPIRY_DATE" => $customer->passport_expire_date,
            "BIRTH_PLACE" => "القاهرة",
            "BIRTH_DATE" => $customer->date_birth,
            "PersonId" => $customer->card_id,
            "DEGREE" => "-",
            "DEGREE_SOURCE" => "-",
            "ADDRESS_HOME" => "بحره",
            "Personal_Email" => "moha@gmail.com",
            "SPONSER_NAME" => $customer->sponser->name,
            "SPONSER_NUMBER" => $customer->sponser->id_number,
            "SPONSER_ADDRESS" => $customer->sponser->address,
            "SPONSER_PHONE" => $customer->sponser->phone,
            "COMING_THROUGH" => "2",
            "ENTRY_POINT" => "1",
            "ExpectedEntryDate" =>  Carbon::now()->addMonths(2)->format('d/m/Y'),
            "porpose" => $customer->visaType->porpose,
            "car_number" => "SV123",
            "RELIGION" => "1",
            "SOCIAL_STATUS" => "2",
            "Sex" => "1",
            "ClassifyOccupations" => $customer->customerGroup->visaProfession->job_title,
            "JOB_OR_RELATION_Id" => $customer->customerGroup->visaProfession->job
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(0)->post('http://localhost:3000/submit-all', data: $data);

        $json = $response->json();

        if (isset($json['appNo'])) {
            $customer->e_visa_number = "E" . $json['appNo'];
            $customer->engaz_request = 'تم الحجز';
            $customer->save();
            return redirect()->route('customer.indes')->with("success", "نجح حجز أنجاز للعميل: " . $first_ar . " وتم تخزين الـ e number الخاص به");
        } else {
            return response()->json(['error' => 'Failed to get application number from response'], 500);
        }
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'customer_ids' => "required",
            "templite" => "required"
        ]);
        ini_set('max_execution_time', 300); // 5 minutes

        $customers = Customer::whereIn("id", $request->customer_ids)->get();
        foreach ($customers as $customer) {

            Http::withHeaders([
                'Authorization' => 'Bearer 490|iWcKkcltFVb9x4Or4r1uWDbUBiPXt1N4qU7bHmMM61249c65',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://bulk.whysms.com/api/v3/sms/send', [
                'recipient' => "2" . $customer->phone, // make sure it's in correct international format
                'sender_id' => 'Elmethaq Co',
                'type' => 'plain',
                'message' =>  $request->templite,
            ]);
        }
        return response()->json([
            'success' => 'true'
        ]);
    }

    public function sync()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/gmail_Oauth.json'));
        $client->addScope(Gmail::GMAIL_READONLY);
        $client->setAccessToken(json_decode(file_get_contents(storage_path('app/gmail-token.json')), true));

        $gmail = new Gmail($client);

        // جلب الرسائل المقروءة التي تحتوي على عنوان التأشيرة
        $messagesResponse = $gmail->users_messages->listUsersMessages('me', [
            'q' => 'subject:"التأشيرة الإلكترونية" is:read'
        ]);

        $messages = $messagesResponse->getMessages();

        $results = [];

        if (!$messages) {
            return response()->json(['message' => 'No relevant messages found']);
        }

        // دالة لفك تشفير محتوى الرسالة النصي أو HTML
        function getMessageContent($parts)
        {
            $content = '';
            foreach ($parts as $part) {
                $mimeType = $part->getMimeType();
                if (in_array($mimeType, ['text/plain', 'text/html'])) {
                    $data = $part->getBody()->getData();
                    if ($data) {
                        $content .= base64_decode(strtr($data, '-_', '+/'));
                    }
                } elseif ($part->getParts()) {
                    $content .= getMessageContent($part->getParts());
                }
            }
            return $content;
        }

        // دالة لاستخراج رقم التأشيرة ورقم الجواز
        function extractVisaPassport($text)
        {
            // رقم التأشيرة
            preg_match('/ﺭﻗﻢ\s*ﺍﻟﺘﺄﺷﻴﺮﺓ\s*[:\-]?\s*(\d+)/u', $text, $visaMatches);

            // رقم الجواز
            preg_match('/ﺭﻗﻢ\s*ﺍﻟﺠﻮﺍﺯ\s*[:\-]?\s*([A-Z0-9]+)/u', $text, $passportMatches);
            $passportNumber = isset($passportMatches[1]) ? substr($passportMatches[1], 0, -1) : null;
            // صالحة اعتباراً من
            preg_match('/ﺻﺎﻟﺤﺔ\s+ﺍﻋﺘﺒﺎﺭﺍ\s+ﻣﻦ\s*(\d{2}\/\d{2}\/\d{4})/u', $text, $validFromMatches);

            // صالحة لغاية
            preg_match('/ﺻﺎﻟﺤﺔ\s+ﻟﻐﺎﻳﺔ\s*(\d{2}\/\d{2}\/\d{4})/u', $text, $validUntilMatches);

            return [
                'visa_number'       => $visaMatches[1]        ?? 'غير موجود',
                'passport_number'   => $passportNumber        ?? 'غير موجود',
                'valid_from'        => $validFromMatches[1]   ?? 'غير موجود',
                'valid_until'       => $validUntilMatches[1]  ?? 'غير موجود',
            ];
        }


        $parser = new Parser();

        foreach ($messages as $msg) {
            $message = $gmail->users_messages->get('me', $msg->getId(), ['format' => 'full']);
            $payload = $message->getPayload();

            // قراءة النص من محتوى الرسالة
            $content = '';
            if ($payload->getParts()) {
                $content = getMessageContent($payload->getParts());
            } else {
                $data = $payload->getBody()->getData();
                $content = base64_decode(strtr($data, '-_', '+/'));
            }

            // استخراج مبدئي من نص الرسالة
            $dataExtracted = extractVisaPassport($content);

            // محاولة قراءة المرفقات لو فيه PDF
            $parts = $payload->getParts();
            if ($parts) {
                foreach ($parts as $part) {
                    $filename = $part->getFilename();
                    $body = $part->getBody();
                    $attachmentId = $body?->getAttachmentId();

                    if ($filename && str_ends_with(strtolower($filename), '.pdf') && $attachmentId) {
                        $attachment = $gmail->users_messages_attachments->get('me', $msg->getId(), $attachmentId);
                        $data = $attachment->getData();
                        $pdfData = base64_decode(strtr($data, '-_', '+/'));

                        // ✅ حفظ ملف الـ PDF في التخزين
                        $filename = 'visa_' . $msg->getId() . '.pdf';

                        // استخراج النص من ملف الـ PDF
                        $pdf = $parser->parseContent(content: $pdfData);
                        $pdfText = $pdf->getText();


                        // استخراج البيانات من النص داخل PDF
                        $dataExtracted = extractVisaPassport($pdfText);

                        break; // نكتفي بأول ملف PDF
                    }
                }
            }

            $visaNumber = $dataExtracted['visa_number'];
            $passportNumber = $dataExtracted['passport_number'];
            $valid_from = isset($dataExtracted['valid_from'])
                ? date('Y-m-d', strtotime(str_replace('/', '-', $dataExtracted['valid_from'])))
                : null;

            $valid_until = isset($dataExtracted['valid_until'])
                ? date('Y-m-d', strtotime(str_replace('/', '-', $dataExtracted['valid_until'])))
                : null;

            // ✅ تحديث العميل لو موجود
            if ($passportNumber !== 'غير موجود') {

                $customer = Customer::where(['passport_id' => $passportNumber, "visa_number" => null, "visa_issuance_date" => null, "visa_expiry_date" => null])->first();
                if ($customer) {
                    $customer->update(['visa_number' => $visaNumber, 'visa_issuance_date' => $valid_from, 'visa_expiry_date' => $valid_until]);
                    $document = new DocumentType();
                    Storage::disk('public')->put('visa-pdfs/' . $filename, contents: $pdfData);
                    $document->file = 'visa-pdfs/' . $filename;
                    $document->document_type = "تأشيرة";
                    $document->status = "موجود بالمكتب";
                    $document->customer_id = $customer->id;
                    $document->order_status = "accept";
                    $document->required = "اجباري";
                    $document->save();

                    $history = new History();
                    $history->description = "تم اصدار التأشيرة";
                    $history->date = now();

                    $history->customer_id = $customer->id;
                    $history->user_id = auth()->user()->id;
                    $history->save();
                    $sms_message = "تم إصدار التأشيرة برقم: {$visaNumber}, رقم الجواز: {$passportNumber}, صالحة من: {$valid_from}, وتنتهي في: {$valid_until},'لتحميل التأشيرة:'". asset($document->file);
                    $this->sendSmsToCustomers($customer->id, template: $sms_message);
                    $this->sendSmsToCustomers($customer->id, 'تم اصدر رقم تأشيرتك برقم ' . $visaNumber);
                } else {
                    return redirect()->back()->with('success', 'التأشيرة غير موجودة');
                }
            } else {
                return redirect()->back()->with('success', 'التأشيرة غير موجودة');
            }

            $results[] = [
                'message_id' => $msg->getId(),
                'visa_number' => $dataExtracted['visa_number'],
                'passport_number' => $dataExtracted['passport_number'],
                'snippet' => $message->getSnippet(),
            ];

            // يمكنك تعليم الرسالة كمقروءة بعد المعالجة:
            // $gmail->users_messages->modify('me', $msg->getId(), new \Google\Service\Gmail\ModifyMessageRequest([
            //     'removeLabelIds' => ['UNREAD']
            // ]));
        }

        return redirect()->back()->with('success', 'تم جلب تأشيرات بنجاح');
    }


    public function sendSmsToCustomers($customerId, string $template)
    {
        $customer = Customer::find($customerId);
        Http::withHeaders([
            'Authorization' => 'Bearer 490|iWcKkcltFVb9x4Or4r1uWDbUBiPXt1N4qU7bHmMM61249c65',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://bulk.whysms.com/api/v3/sms/send', [
            'recipient' => "2" . $customer->phone,
            'sender_id' => 'Elmethaq Co',
            'type' => 'plain',
            'message' =>  $template,
        ]);
    }
}
