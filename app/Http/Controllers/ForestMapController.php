<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForestMapController extends Controller
{
    /**
     * Show the forest listing in LeafletJS map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Forests';
        return view('forests.map', compact('title'));
    }
}
