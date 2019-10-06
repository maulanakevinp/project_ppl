<?php

namespace App\Http\Controllers\Api;

use App\Forest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Forest as ForestResource;

class ForestController extends Controller
{
    /**
     * Get forest listing on Leaflet JS geoJSON data structure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $forests = Forest::all();

        $geoJSONdata = $forests->map(function ($forest) {
            return [
                'type'       => 'Feature',
                'properties' => new ForestResource($forest),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $forest->longitude,
                        $forest->latitude,
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }
}
