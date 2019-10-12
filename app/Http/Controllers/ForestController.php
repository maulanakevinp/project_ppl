<?php

namespace App\Http\Controllers;

use App\Forest;
use Alert;
use Illuminate\Http\Request;

class ForestController extends Controller
{
    /**
     * Display a listing of the forest.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('manage_forest');

        $title = 'Forests';
        $forestQuery = Forest::query();
        $forestQuery->where('name', 'like', '%' . request('q') . '%');
        $forests = $forestQuery->paginate(25);

        return view('forests.index', compact('forests', 'title'));
    }

    /**
     * Show the form for creating a new forest.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Forest);
        $title = 'Forests';
        return view('forests.create', compact('title'));
    }

    /**
     * Store a newly created forest in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Forest);

        $newForest = $request->validate([
            'nik'               => 'required|size:16',
            'name'              => 'required|max:60',
            'owner_address'     => 'required|max:255',
            'address'           => 'required|max:255',
            'latitude'          => 'required|required_with:longitude|max:15',
            'longitude'         => 'required|required_with:latitude|max:15',
        ]);
        $newForest['creator_id'] = auth()->id();

        $forest = Forest::create($newForest);

        Alert::success('Forest has been added', 'success');
        return redirect()->route('forests.show', $forest);
    }

    /**
     * Display the specified forest.
     *
     * @param  \App\Forest  $forest
     * @return \Illuminate\View\View
     */
    public function show(Forest $forest)
    {
        $title = 'Forests';
        return view('forests.show', compact('forest', 'title'));
    }

    /**
     * Show the form for editing the specified forest.
     *
     * @param  \App\Forest  $forest
     * @return \Illuminate\View\View
     */
    public function edit(Forest $forest)
    {
        $this->authorize('update', $forest);
        $title = 'Forests';
        return view('forests.edit', compact('forest', 'title'));
    }

    /**
     * Update the specified forest in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forest  $forest
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Forest $forest)
    {
        $this->authorize('update', $forest);

        $forestData = $request->validate([
            'nik'               => 'required|size:16',
            'name'              => 'required|max:60',
            'owner_address'     => 'required|max:255',
            'address'           => 'required|max:255',
            'latitude'          => 'required|required_with:longitude|max:15',
            'longitude'         => 'required|required_with:latitude|max:15',
        ]);
        $forest->update($forestData);

        Alert::success('Forest has been updated', 'success');
        return redirect()->route('forests.show', $forest);
    }

    /**
     * Remove the specified forest from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forest  $forest
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Forest $forest)
    {
        $this->authorize('delete', $forest);

        $request->validate(['forest_id' => 'required']);

        if ($request->get('forest_id') == $forest->id && $forest->delete()) {
            Alert::success('Forest has been deleted', 'success');
            return redirect()->route('forests.index');
        }

        return back();
    }
}
