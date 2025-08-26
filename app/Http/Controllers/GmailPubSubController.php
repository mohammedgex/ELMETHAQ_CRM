<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Google\Client;
use Google\Service\Gmail;
use Smalot\PdfParser\Parser;

class GmailPubSubController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('Raw request: ' . $request->getContent());

        $message = $request->input('message');
        if (!$message || !isset($message['data'])) {
            return response()->json(['status' => 'invalid message'], 400);
        }

        $decodedJson = base64_decode($message['data']);
        \Log::info('Decoded base64: ' . $decodedJson);

        $decoded = json_decode($decodedJson, true);
        if (!$decoded || !isset($decoded['historyId'])) {
            return response()->json(['status' => 'invalid message'], 400);
        }

        $historyId = $decoded['historyId'];
        \Log::info("Gmail Pub/Sub notification received, historyId: $historyId");

        $this->fetchNewMessages($historyId);

        return response()->json(['status' => 'ok']);
    }

    private function fetchNewMessages($historyId)
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-client.json'));
        $client->setAccessToken(json_decode(file_get_contents(storage_path('app/google-token.json')), true));

        $gmail = new Gmail($client);

        $params = ['labelIds' => ['INBOX'], 'maxResults' => 10];

        try {
            $messagesResponse = $gmail->users_messages->listUsersMessages('me', $params);
            $messages = $messagesResponse->getMessages();

            if (!$messages) {
                \Log::info("No new messages found for historyId: $historyId");
                return;
            }

            foreach ($messages as $msg) {
                $mail = $gmail->users_messages->get('me', $msg->getId(), ['format' => 'full']);
                $headers = collect($mail->getPayload()->getHeaders());
                $from = $headers->firstWhere('name', 'From')['value'] ?? 'Unknown';
                $subject = $headers->firstWhere('name', 'Subject')['value'] ?? '(No subject)';
                \Log::info("📩 From: $from | Subject: $subject | ID: {$msg->getId()}");

                // 🟢 استخراج نص الميل
                $body = $this->getBody($mail->getPayload());
                $visaNumber = null;
                // \Log::info($body);

                if ($body) {
                    if (preg_match('/(?:Visa\s*(?:No\.?|Number)?|رقم\s*التأشيرة)\s*[:\-]?\s*([0-9]{8,12})/ui', $body, $matches)) {
                        $visaNumber = $matches[1];
                    } else {
                        \Log::info("No visa number found in email body.");
                    }
                }

                // البحث عن المرفقات ومعالجة PDF
                $this->processParts($gmail, $mail->getId(), $mail->getPayload()->getParts(), $visaNumber);
            }
        } catch (\Exception $e) {
            \Log::error("Error fetching messages: " . $e->getMessage());
        }
    }

    private function processParts($gmail, $messageId, $parts, $visaNumber = null)
    {
        if (!$parts) return;

        foreach ($parts as $part) {
            $filename = $part->getFilename();
            $body = $part->getBody();
            $attachmentId = $body->getAttachmentId() ?? null;

            if ($filename && $attachmentId) {
                $attachment = $gmail->users_messages_attachments->get('me', $messageId, $attachmentId);
                $data = base64_decode(strtr($attachment->getData(), '-_', '+/'));

                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (strtolower($ext) === 'pdf') {
                    // ✅ نحلل PDF مباشرة بدون ما نخزنه إلا بعد التأكد من العميل
                    $parser = new Parser();
                    $pdf = $parser->parseContent($data);
                    $text = $pdf->getText();

                    $passportNumber = null;

                    // ✅ استخراج رقم الجواز من MRZ
                    if (preg_match('/([A-Z]{1}[0-9]{7,9})[A-Z0-9<]/', $text, $matches)) {
                        $passportNumber = $matches[1];
                        \Log::info("Extracted Passport Number: " . $passportNumber);
                    }

                    if ($passportNumber) {
                        $customer = Customer::where('passport_id', $passportNumber)->first();

                        if ($customer && empty($customer->visa_number)) {
                            \Log::info("Found customer with passport number: " . $passportNumber);

                            // ✅ هنا فقط نخزن الملف
                            $randomName = time() . '_' . rand(1000, 9999) . ".{$ext}";
                            \Storage::disk('public')->put("uploads/{$randomName}", $data);
                            $fullPath = storage_path("app/public/uploads/{$randomName}");
                            \Log::info("Attachment saved: " . $fullPath);

                            // ربط المرفق بالعميل
                            $customer->documentTypes()->where('document_type', 'التاشيرة')->delete();
                            $customer->visa_number = $visaNumber;
                            $customer->save();

                            $document = new DocumentType();
                            $document->document_type = "التاشيرة";
                            $document->status = "موجود بالمكتب";
                            $document->file = "uploads/{$randomName}";
                            $document->customer_id = $customer->id;
                            $document->required = "اجباري";
                            $document->save();

                            \Log::info("✅ Visa number {$visaNumber} saved for customer {$customer->id}");
                        } else {
                            \Log::info("⏩ Skipped: customer not found OR already has visa");
                        }
                    } else {
                        \Log::info("No passport number found in PDF.");
                    }
                }
            }

            if ($part->getParts()) {
                $this->processParts($gmail, $messageId, $part->getParts(), $visaNumber);
            }
        }
    }


    // 🟢 دالة مساعدة لاستخراج النصوص من الميل
    private function getBody($payload)
    {
        $body = '';
        if ($payload->getBody() && $payload->getBody()->getData()) {
            $body .= base64_decode(strtr($payload->getBody()->getData(), '-_', '+/'));
        }

        if ($payload->getParts()) {
            foreach ($payload->getParts() as $part) {
                $body .= $this->getBody($part);
            }
        }
        return $body;
    }

    public function handleCallback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['error' => 'No code returned']);
        }

        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-client.json')); // ده يفضل زي ما هو للـ client credentials
        $client->addScope([
            'https://www.googleapis.com/auth/gmail.readonly',
            'https://www.googleapis.com/auth/gmail.modify',
        ]);
        $client->setRedirectUri(url('/google/callback'));

        // تبادل الـ code مع access token
        $token = $client->fetchAccessTokenWithAuthCode($code);

        // ✅ لو فيه error
        if (isset($token['error'])) {
            return response()->json([
                'status' => 'error',
                'message' => $token['error_description'] ?? $token['error']
            ], 400);
        }

        // ✅ حفظ التوكن في google-token.json
        file_put_contents(storage_path('app/google-token.json'), json_encode($token));

        // ✅ تأكيد وجود refresh token
        if (!empty($token['refresh_token'])) {
            $client->setAccessToken($token);
            file_put_contents(storage_path('app/google-token.json'), json_encode($client->getAccessToken()));
        }

        return response()->json([
            'status' => 'Token saved',
            'token' => $token
        ]);
    }
}
