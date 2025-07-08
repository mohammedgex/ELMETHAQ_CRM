<?php

require_once __DIR__ . '/vendor/autoload.php';

use Google\Client;

// Set up the Google Client
$client = new Client();
$client->setAuthConfig(__DIR__ . '/storage/app/gmail_Oauth.json');
$client->addScope('https://www.googleapis.com/auth/gmail.readonly'); // Adjust the scope as needed
$client->setAccessType('offline');
$client->setPrompt('consent');
$client->setRedirectUri('http://localhost:8000/oauth2callback'); // Or any redirect URI allowed in your OAuth settings

$tokenPath = __DIR__ . '/storage/app/gmail-token.json';

if (file_exists($tokenPath)) {
    // Load token from file
    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);

    // Refresh if expired
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
            echo "Token refreshed and saved.\n";
        } else {
            echo "No refresh token available. Re-authentication required.\n";
            unlink($tokenPath); // Delete token to force new auth next run
        }
    } else {
        echo "Token loaded successfully.\n";
    }
} else {
    // No token yet — first-time authentication
    $authUrl = $client->createAuthUrl();
    echo "Open the following link in your browser:\n$authUrl\n";
    echo "Enter the authorization code here: ";
    $authCode = trim(fgets(STDIN)); // Wait for user input

    // Exchange the auth code for an access token
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    if (isset($accessToken['error'])) {
        exit("Error fetching access token: " . $accessToken['error_description']);
    }

    // Save the token to a file
    file_put_contents($tokenPath, json_encode($accessToken));
    echo "Token saved successfully to: $tokenPath\n";
}

