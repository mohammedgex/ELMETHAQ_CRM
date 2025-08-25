<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;

class GmailAuthCommand extends Command
{
    protected $signature = 'gmail:auth';
    protected $description = 'Authenticate with Gmail API and store access token';

    public function handle()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-client.json'));
        $client->setRedirectUri('http://127.0.0.1:8000/google/callback');
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->addScope([
            'https://www.googleapis.com/auth/gmail.readonly',
            'https://www.googleapis.com/auth/gmail.modify',
        ]);

        $tokenPath = storage_path('app/google-token.json');

        if (!file_exists($tokenPath)) {
            $authUrl = $client->createAuthUrl();
            $this->info("افتح الرابط وسجّل دخولك:");
            $this->line($authUrl);
            $this->info("انسخ القيمة بعد code= من عنوان المتصفح والصقها هنا:");
            $authCode = trim(fgets(STDIN));

            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            if (isset($accessToken['error'])) {
                $this->error('فشل الحصول على التوكن: ' . $accessToken['error']);
                return 1;
            }

            file_put_contents($tokenPath, json_encode($accessToken));
            $this->info("✅ Token saved to: " . $tokenPath);
        } else {
            $this->info("🔑 Token already exists at: " . $tokenPath);
        }

        return 0;
    }
}
