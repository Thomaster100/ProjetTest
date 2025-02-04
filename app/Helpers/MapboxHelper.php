<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class MapboxHelper
{
    public static function geocodeAddress($address) {

        $apiKey = env('MAPBOX_TOKEN');
        $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/" . urlencode($address) . ".json?access_token={$apiKey}";

        $response = Http::withOptions(['verify' => false])->get($url);
        
        if (!$response->successful()) {
            return null; // Evite une erreur 500 si Mapbox ne répond pas
        }

        $data = $response->json();
        if (!isset($data['features'][0])) {
            return null;
        }

        return [
            'longitude' => $data['features'][0]['geometry']['coordinates'][0],
            'latitude' => $data['features'][0]['geometry']['coordinates'][1],
            'full_address' => $data['features'][0]['place_name'],
        ];
    }
}
