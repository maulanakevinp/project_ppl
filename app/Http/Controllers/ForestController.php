<?php

namespace App\Http\Controllers;

use App\Forest;
use Alert;
use App\Rules\MustNumeric;
use App\Rules\OwnLat;
use App\Rules\OwnLong;
use File;
use DataTables;
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
        $forests = Forest::all();
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
            'nik'               => 'required|digits:16',
            'name'              => 'required|max:60',
            'owner_address'     => 'required',
            'address'           => 'required',
            'latitude'          => ['required', 'required_with:longitude', 'max:15', new MustNumeric , new OwnLat(auth()->user()->latitude1, auth()->user()->latitude2)],
            'longitude'         => ['required', 'required_with:latitude', 'max:15', new MustNumeric, new OwnLong(auth()->user()->longitude1, auth()->user()->longitude2)],
            'ktp_scan'          => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'photo_file'        => ['required', 'image', 'mimes:jpeg,png', 'max:2048']
        ]);
        $newForest['nik_file'] = $this->setImageUpload($request->file('ktp_scan'),'img/nik');
        $newForest['photo_file'] = $this->setImageUpload($request->file('photo_file'),'img/photo');
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
        if ($forest->creator_id == auth()->user()->id) {
            $this->authorize('update', $forest);
            $title = 'Forests';
            return view('forests.edit', compact('forest', 'title'));
        } else {
            return abort(403, 'Access Forbidden');
        }
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
            'nik'               => 'required|digits:16',
            'name'              => 'required|max:60',
            'owner_address'     => 'required',
            'address'           => 'required',
            'latitude'          => ['required', 'required_with:longitude', 'max:15', new MustNumeric, new OwnLat(auth()->user()->latitude1, auth()->user()->latitude2)],
            'longitude'         => ['required', 'required_with:latitude', 'max:15', new MustNumeric, new OwnLong(auth()->user()->longitude1, auth()->user()->longitude2)],
            'ktp_scan'          => ['image', 'mimes:jpeg,png', 'max:2048'],
            'photo_file'        => ['image', 'mimes:jpeg,png', 'max:2048']
        ]);

        if ($request->file('ktp_scan')) {
            $forestData['nik_file'] = $this->setImageUpload($request->file('ktp_scan'), 'img/nik', $forest->nik_file);
        }
        
        if ($request->file('photo_file')) {
            $forestData['photo_file'] = $this->setImageUpload($request->file('photo_file'), 'img/photo', $forest->photo_file);
        }

        $forestData['verify'] = null;
        $forestData['reason'] = null;
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
    public function destroy(Forest $forest)
    {
        $this->authorize('delete', $forest);
        File::delete(public_path('img/nik/'.$forest->nik_file));
        File::delete(public_path('img/photo/'.$forest->photo_file));
        $forest->delete();
        Alert::success('Forest has been deleted', 'success');
        return redirect()->route('forests.index');
    }

    public function setImageUpload($file, $path, $old_file = null)
    {
        $file_name = time() . "_" . $file->getClientOriginalName();
        if ($file->move(public_path($path), $file_name)) {
            if ($old_file) {
                File::delete(public_path($path . '/' . $old_file));
            }
            return $file_name;
        } else {
            Alert::error('Foto gagal diunggah', 'gagal')->persistent('tutup');
            return back();
        }
    }

    /**
     * Approving the specified forest from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forest  $forest
     * @return \Illuminate\Routing\Redirector
     */
    public function approving(Forest $forest)
    {
        $forest->verify = 1;
        $forest->reason = null;
        $forest->save();
        Alert::success('Forest has been approved', 'success');
        return back();
    }

    /**
     * Rejecting the specified forest from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forest  $forest
     * @return \Illuminate\Routing\Redirector
     */
    public function rejecting(Request $request,Forest $forest)
    {
        $request->validate([
            'reason' => 'required'
        ]);
        $forest->verify = -1;
        $forest->reason = $request->reason;
        $forest->save();
        Alert::success('Forest has been rejected', 'success');
        return back();
    }

    public function getForest()
    {
        $forests = Forest::select('forests.*');
        return DataTables::eloquent($forests)
            ->addColumn('action',function($forest){
                return  '<a href="' . route('forests.show', $forest->id) . '" class="btn btn-info btn-sm" data-toggle="tool-tip" title="Detail Forest"><i class="fas fa-eye"></i></a>';
            })
            ->addColumn('status',function($forest){
                if ($forest->verify == 1) {
                    return 'Approved';
                } elseif ($forest->verify == -1) {
                    return 'Rejected';
                } else {
                    return 'Not yet approved';
                }
            })
            ->addColumn('creator',function($forest){
                if (auth()->user()->role_id == 2) {
                    return '<a href="'.route('users.show',$forest->creator_id).'">'.$forest->creator->name.'</a>';
                } else {
                    return $forest->creator->name;
                }
            })
            ->addColumn('created_at',function($forest){
                return $forest->created_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['creator','action', 'status', 'created_at'])
            ->toJson();
    }
}
