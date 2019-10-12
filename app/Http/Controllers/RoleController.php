<?php

namespace App\Http\Controllers;

use App\UserAccessMenu;
use App\UserMenu;
use App\UserRole;
use Session;
use Illuminate\Http\Request;
use Alert;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Users';
        $user_role = UserRole::all();
        return view('role.index', compact('title', 'user_role'));
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
            'role' => 'required'
        ]);

        UserRole::create($request->all());

        Alert::success('Role has been created', 'success');
        return redirect('/role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = UserMenu::where('id', '!=', 1)
            ->orderBy('id', 'asc')
            ->get();
        $title = 'Users';
        $subtitle = 'Role Access';
        $role = UserRole::find($id);
        return view('role.edit', compact('menu', 'subtitle', 'title', 'role'));
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
            'role' => 'required'
        ]);

        UserRole::where('id', $id)->update([
            'role' => $request->role
        ]);

        Alert::success('Role has been updated', 'success');
        return redirect('/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserRole::destroy($id);

        Alert::success('Role has been deleted', 'success');
        return redirect('/role');
    }

    public function changeAccess(Request $request)
    {
        $access = UserAccessMenu::getAccessByRoleAndMenu($request->roleId, $request->menuId);
        if ($access < 1) {
            UserAccessMenu::create([
                'role_id' => $request->roleId,
                'menu_id' => $request->menuId
            ]);
        } else {
            UserAccessMenu::where('role_id', $request->roleId)
                ->where('menu_id', $request->menuId)
                ->delete();
        }
        Alert::success('Access has been changed!', 'success');
    }
}
