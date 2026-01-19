<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MessageService
{
    public static function sendMessage($number, $message)
    {
        $baseUrl = 'https://int.chatway.in/api/send-msg';

        $username = 'AMCMANAGE';
        $number   = '91' . $number;
        $token    = 'U0d4dXUxWkhVS2FZdXVENlUrU29xQT09';

        $url = $baseUrl . '?username=' . urlencode($username)
            . '&number=' . urlencode($number)
            . '&token=' . urlencode($token)
            . '&message=' . urlencode($message);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET        => true,

            // 🔑 Timeout handling
            CURLOPT_CONNECTTIMEOUT => 5,   // seconds to wait while connecting
            CURLOPT_TIMEOUT        => 10,  // max execution time

            // Optional but recommended
            CURLOPT_FAILONERROR    => true,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $errorNo  = curl_errno($ch);
            $errorMsg = curl_error($ch);

            // Handle timeout separately
            if ($errorNo === CURLE_OPERATION_TIMEDOUT) {
                Log::error('Message API Timeout', [
                    'number' => $number,
                    'error'  => $errorMsg
                ]);

                return [
                    'status'  => false,
                    'message' => 'Request timed out'
                ];
            }

            // Other cURL errors
            Log::error('Message API cURL Error', [
                'number' => $number,
                'error'  => $errorMsg
            ]);

            return [
                'status'  => false,
                'message' => $errorMsg
            ];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            Log::error('Message API HTTP Error', [
                'number'   => $number,
                'httpCode' => $httpCode,
                'response' => $response
            ]);

            return [
                'status'  => false,
                'message' => 'HTTP Error: ' . $httpCode
            ];
        }

        return [
            'status' => true,
            'data'   => json_decode($response, true)
        ];
    }
}
