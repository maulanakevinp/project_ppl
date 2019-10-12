<?php

namespace App\Http\Controllers;

use App\UserMenu;
use App\UserSubmenu;
use Alert;
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
        UserMenu::destroy($id);

        Alert::success('Submenu has been deleted', 'success');
        return redirect('/submenu');
    }
}
