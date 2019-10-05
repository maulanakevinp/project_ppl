<?php

namespace App\Http\Controllers;

use App\City;
use App\District;
use App\Forest;
use Illuminate\Http\Request;

class ForestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forests = Forest::all();
        $title = 'Forests Management';
        return view('forest.index', compact('title', 'forests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Forests Management';
        $subtitle = 'Add New Forest';
        $cities = City::all();
        return view('forest.create', compact('title', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $forest = Forest::find($id);
        $title = 'Forests Management';
        $subtitle = $forest->owner;
        return view('forest.show', compact('title', 'subtitle', 'forest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $forest = Forest::find($id);
        $title = 'Forests Management';
        $subtitle = 'Edit Forest';
        return view('forest.edit', compact('title', 'subtitle', 'forest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDistricts(Request $request)
    {
        $id = $request->id;
        $districts = District::where('city_id', $id)->get();

        echo "<option value=''> Choose district </option>";
        foreach ($districts as $district) {
            echo "<option value='" . $district['id'] . "'>" . $district['district'] . "</option>";
        }
    }
}
