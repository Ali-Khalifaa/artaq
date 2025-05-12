<?php

namespace App\Traits;

use App\Models\FirebaseSetting;
use Exception;

/**
 * trait FirebaseNotification
 * $this->sendFirebaseNotification();
 */
trait FirebaseNotification
{

    public function sendFirebaseNotification($tokens, $data, $title, $body, $image,$deviceType = 'android')
    {
        // $serviceAccountFile = storage_path('firebase.json');

        // $jsonKey = json_decode(file_get_contents($serviceAccountFile), true);
        $firebaseSetting = FirebaseSetting::first();
        $jsonKey = $firebaseSetting->setting;
        $data = $deviceType == 'android' ? [

            "message" => [
                "token" => $tokens,
                "data" => [
                    'data' => json_encode($data),
                    "notification" => json_encode([
                        "body" => $body,
                        "title" => $title,
                        "image" => $image ?? asset('assets/images/brand-logos/toggle-white.png'),
                    ])
                ],
            ],

        ] : [
            "message" => [
                "token" => $tokens,
                "data" => [
                    'data' => json_encode($data),
                ],
                "notification" => [
                    "body" => $body,
                    "title" => $title,
                    "image" => $image ?? asset('assets/images/brand-logos/toggle-white.png'),
                ]
            ],
        ];



        $dataString = json_encode($data);

        $headers = [

            'Authorization: Bearer ' . $this->getToken(),

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/' . $jsonKey['project_id'] . '/messages:send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;
    }

    protected function getToken()
    {

        $serviceAccountFile = storage_path('firebase.json');

        $jsonKey = json_decode(file_get_contents($serviceAccountFile), true);

        $header = json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
        ]);

        $expiry = time() + 3600;

        $payload = json_encode([
            'iss' => $jsonKey['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $jsonKey['token_uri'],
            'iat' => time(),
            'exp' => $expiry,
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = '';
        openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $jsonKey['private_key'], 'SHA256');

        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        // Requesting the OAuth token
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $jsonKey['token_uri'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]),
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $tokenData = json_decode($response, true);


        if (isset($tokenData['access_token'])) {
            return $tokenData['access_token'];
        }

        throw new Exception('Unable to retrieve access token.');
    }
}
