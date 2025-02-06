<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Koossaayy\LaravelMapbox\Facades\Mapbox;
use App\Helpers\MapboxHelper;

class MapController extends Controller
{
    public function index() {
        return view('mapbox.map');
    }

    public function search(Request $request) {

        $address = $request->input('query'); 
        if (!$address) {
            return response()->json(['error' => 'Veuillez entrer une adresse.'], 400);
        }

        $coordinates = MapboxHelper::geocodeAddress($address);

        if (!$coordinates) {
            return response()->json(['error' => 'Adresse introuvable.'], 404);
        }

        return response()->json($coordinates);
    }

    public function getCoordinates(Request $request) {

        $address = $request->input('address');
        if (!$address) {
            return response()->json(['error' => 'Veuillez entrer une adresse.'], 400);
        }

        $coordinates = MapboxHelper::geocodeAddress($address);

        if (!$coordinates) {
            return response()->json(['error' => 'Adresse introuvable.'], 404);
        }

        return response()->json($coordinates);
    }

    public function showMultipleMarkers() {
        return view('mapbox.mapMultipleMarkers');
    }

    // Envoi des coordonnées markers en JSON
    public function getMarkers()
    {
        $markers = [
            [
                'name' => 'Université de Liège',
                'longitude' => 5.5718,
                'latitude' => 50.6372,
                'link' => 'https://www.uliege.be/'
            ],
            [
                'name' => 'Gare de Liège-Guillemins',
                'longitude' => 5.574,
                'latitude' => 50.6241,
                'link' => 'https://www.belgiantrain.be/fr/station-information/NL/LIEGE'
            ],
            [
                'name' => 'Opéra Royal de Wallonie',
                'longitude' => 5.5707,
                'latitude' => 50.6413,
                'link' => 'https://www.operaliege.be/'
            ],
            [
                'name' => 'Montagne de Bueren',
                'longitude' => 5.5742,
                'latitude' => 50.6466,
                'link' => 'https://www.visitezliege.be/fr/montagne-de-bueren'
            ]
        ];

        return response()->json($markers);
    }

   public function printPostmanDatas() {
        return response()->json(['POSTMAN-OK']);
   }


}
