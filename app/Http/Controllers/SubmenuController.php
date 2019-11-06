<?php

namespace App\Http\Controllers;

use App\UserMenu;
use App\UserSubmenu;
use Alert;
use DataTables;
use Illuminate\Http\Request;

class SubmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Menu';
        $user_menu = UserMenu::all();
        $user_submenu = UserSubmenu::all();
        return view('menu.submenu', compact('title', 'user_submenu', 'user_menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'menu' => 'required|numeric',
            'title' => 'required',
            'url' => 'required',
            'icon' => 'required',
        ]);
        $is_active = $request->is_active;
        if ($is_active == null) {
            $is_active = 0;
        }

        UserSubmenu::create([
            'menu_id' => $request->menu,
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'is_active' => $is_active
        ]);

        Alert::success('Submenu has been created', 'success');
        return redirect('/submenu');
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
        $request->validate([
            'menu' => 'required|numeric',
            'title' => 'required',
            'url' => 'required',
            'icon' => 'required',
        ]);

        $is_active = $request->is_active;
        if ($is_active == null) {
            $is_active = 0;
        }

        UserSubmenu::where('id', $id)->update([
            'menu_id' => $request->menu,
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'is_active' => $is_active
        ]);

        Alert::success('Submenu has been updated', 'success');
        return redirect('/submenu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserSubmenu::destroy($id);

        Alert::success('Submenu has been deleted', 'success');
        return redirect('/submenu');
    }

    public function getSubmenu()
    {
        $submenu = UserSubmenu::with('menu')->select('user_submenu.*');
        return DataTables::eloquent($submenu)
            ->addColumn('action', function ($s) {
                return '
            <button onclick="editSubmenu(' . $s->id . ')" class="editSubmenu btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#newSubmenuModal">
                <i class="fas fa-edit"></i>
            </button>
            <form class="d-inline-block" action="' . url('/submenu' . '/' . $s->id) . '" method="post">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_method" value="delete">
                <button type="submit" class="btn btn-danger btn-circle btn-sm" onclick="return confirm(`Are you sure want to delete this ' . $s->title . ' submenu?`)">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            ';
            })
            ->addColumn('icon', function ($s) {
                return '<i class="' . $s->icon . '"></i>';
            })
            ->rawColumns(['icon', 'action'])
            ->toJson();
    }

    public function getEditSubmenu(Request $request)
    {
        $submenu = UserSubmenu::findOrFail($request->id);
        echo json_encode($submenu);
    }
}
