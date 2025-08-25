<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\WatchRequest;

class GmailWatchCommand extends Command
{
    protected $signature = 'gmail:watch';
    protected $description = 'Start Gmail watch to Pub/Sub topic';

    public function handle()
    {
        try {
            $client = new Client();
            $client->setAuthConfig(storage_path('app/google-client.json')); // OAuth client.json
            $client->addScope(Gmail::GMAIL_READONLY);
            $client->addScope(Gmail::GMAIL_MODIFY);
            $client->setAccessType('offline');
            $client->setPrompt('consent');

            $tokenPath = storage_path('app/google-token.json');
            if (!file_exists($tokenPath)) {
                $this->error("❌ Token file not found. Run: php artisan gmail:auth");
                return 1;
            }

            $accessToken = json_decode(file_get_contents($tokenPath), true);

            // التحقق من صحة التوكن
            if (!is_array($accessToken) || !isset($accessToken['access_token'])) {
                $this->error("❌ Invalid token format. Run: php artisan gmail:auth again.");
                return 1;
            }

            $client->setAccessToken($accessToken);

            // تحديث التوكن لو منتهي
            if ($client->isAccessTokenExpired()) {
                $refreshToken = $client->getRefreshToken() ?: ($accessToken['refresh_token'] ?? null);
                if ($refreshToken) {
                    $newToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
                    if (isset($newToken['error'])) {
                        $this->error("❌ Failed to refresh token: " . $newToken['error']);
                        return 1;
                    }
                    $newToken['refresh_token'] = $refreshToken; // نضمن حفظ الـ refresh
                    file_put_contents($tokenPath, json_encode($newToken));
                    $client->setAccessToken($newToken);
                } else {
                    $this->error("❌ Refresh token missing. Run: php artisan gmail:auth again.");
                    return 1;
                }
            }

            // تفعيل Gmail API
            $gmail = new Gmail($client);

            // إنشاء طلب Watch
            $watchRequest = new WatchRequest([
                'labelIds' => ['INBOX'], // ممكن تغيرها أو تسيبها فاضية
                'topicName' => 'projects/flash-griffin-418118/topics/projects' // غيّر gmail-topic باسم التوبيك عندك
            ]);

            $response = $gmail->users->watch('me', $watchRequest);

            $this->info("✅ Gmail watch started successfully!");
            $this->line(json_encode($response, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            $this->error("❌ Error starting Gmail watch: " . $e->getMessage());
        }
    }
}
