<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public static function getLocationFromCoordinates($latitude, $longitude)
    {

        $apiKey = config('services.database_api_key'); // Replace with your actual API key
        
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

        
        $response = Http::get($url);
       
        $metroArea = $response->header('X-Goog-Maps-Metro-Area') ?? 'NA';  // Access the header
        $address = "";    
        // You can log or return the metro area for debugging
        if ($response->successful()) {
            $data = $response->json();
            if (!empty($data['results'])) {
                $address = $data['results'][0]['formatted_address']; // Get the formatted address
            }
        }
        $add = $address !="" ? $address : $metroArea;
        return $add;
    }
}
