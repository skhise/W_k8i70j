<?php

namespace App\Services;
use App\Models\ProfileSetup;
use Auth;

class MessageService
{
    public static function sendMessage($number,$message)
    {
// Base URL
$baseUrl = 'https://int.chatway.in/api/send-msg';

// Parameters
$username = 'AMCMANAGE';
$number = '8408013399';
$token = 'U0d4dXUxWkhVS2FZdXVENlUrU29xQT09';
$message = 'hello test'; // Example message

// Construct the URL with encoded parameters
$url = $baseUrl . '?username=' . urlencode($username) . 
                  '&number=' . urlencode($number) . 
                  '&token=' . urlencode($token) . 
                  '&message=' . urlencode($message);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
curl_setopt($ch, CURLOPT_HTTPGET, true); // Set to GET method

// Execute the request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    // Check HTTP status code
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code == 200) {
        // Process the response
        $data = json_decode($response, true);
        print_r($data);
    } else {
        echo "HTTP Error: " . $http_code . " - " . $response;
    }
}

// Close the cURL session
curl_close($ch);

    }
}