<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use File;
use Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Users';
        $users = User::all();
        return view('user.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Users';
        $subtitle = 'Add New User';
        $users = User::all();
        $user_role = UserRole::all();
        return view('user.create', compact('title', 'subtitle', 'users', 'user_role'));
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
            'role' => 'required|numeric',
            'nip' => 'required|size:18',
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048'
        ]);

        $file = $request->file('image');
        $file_name = time() . "_" . $file->getClientOriginalName();

        if ($file->move(public_path('img/profile'), $file_name)) {
            User::create([
                'role_id' => $request->role,
                'nip' => $request->nip,
                'name' => $request->name,
                'image' => $file_name,
                'password' => Hash::make('rahasia'),
                'reset_password' => Hash::make('rahasia')
            ]);

            Alert::success('User has been added', 'success');
            return redirect('/users');
        } else {
            Alert::error('User has not been added', 'failed')->persistent("Close this");
            return redirect('/users');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $title = auth()->user()->name;
        return view('user.show', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Users';
        $subtitle = 'Edit User';
        $user = User::find($id);
        $user_role = UserRole::all();
        return view('user.edit', compact('title', 'subtitle', 'user', 'user_role'));
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
        $user = User::find($id);
        $request->validate([
            'role' => 'required',
            'nip' => 'required|size:18',
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,gif|max:2048'
        ]);

        $file = $request->file('image');
        if (!empty($file)) {
            $file_name = time() . "_" . $file->getClientOriginalName();
            if ($file->move(public_path('img/profile'), $file_name)) {
                if ($user->image != "default.jpg") {
                    File::delete(public_path('img/profile/' . $user->image));
                }
                $user->image = $file_name;
            } else {
                Alert::error('Photo cannot moved', 'failed')->persistent("Close this");
                return redirect('/users' . '/' . $id . '/edit');
            }
        }

        User::where('id', $id)->update([
            'role_id' => $request->role,
            'name' => $request->name,
            'image' => $user->image,
            'nip' => $request->nip
        ]);

        Alert::success('User has been updated', 'success');
        return redirect('/users' . '/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id);
        $image = DB::table('users')->where('id', $id)->first();
        $delete = File::delete(public_path('img/profile/' . $image->image));

        if ($delete) {
            $user->forceDelete();
            Alert::success('User has been deleted', 'success');
            return redirect('/users/trash');
        } else {
            Alert::success('User has not been deleted', 'success');
            return redirect('/users/trash');
        }
    }

    public function softdelete($id)
    {
        $user = User::find($id);
        $user->delete();
        Alert::success('User has been deleted', 'success');
        return redirect('/users');
    }

    public function trash()
    {
        $title = 'Users';
        $subtitle = 'Users Trash';
        $users = User::onlyTrashed()->get();
        return view('user.trash', compact('title', 'subtitle', 'users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id);
        $user->restore();
        Alert::success('User has been restored', 'success');
        return redirect('/users');
    }

    public function restoreAll()
    {
        $user = User::onlyTrashed();
        $user->restore();
        Alert::success('User has been restored all', 'success');
        return redirect('/users');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::find($id);
        User::where('id', $id)->update([
            'password' => $user->reset_password
        ]);
        Alert::success('Password has been reset', 'success');
        return redirect('/users');
    }

    public function editProfile()
    {
        $title = auth()->user()->name;
        return view('user.edit-profile', compact('title'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,gif|max:2048'
        ]);

        $file = $request->file('image');

        $file = $request->file('image');
        if (!empty($file)) {
            $file_name = time() . "_" . $file->getClientOriginalName();
            if ($file->move(public_path('img/profile'), $file_name)) {
                if ($user->image != "default.jpg") {
                    File::delete(public_path('img/profile/' . $user->image));
                }
                $user->image = $file_name;
            } else {
                Alert::error('Photo cannot moved', 'failed')->persistent("Close this");
                return redirect('/my-profile');
            }
        }

        User::where('id', $id)->update([
            'name' => $request->name,
            'image' => $user->image,
        ]);
        Alert::success('Profile has been updated', 'success');
        return redirect('/my-profile');
    }

    public function changePassword()
    {
        $title = auth()->user()->name;
        return view('user.change-password', compact('title'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ]);
        $user = User::find($id);
        if (Hash::check($request->current_password, $user->password)) {
            if ($request->current_password == $request->confirm_password) {
                Alert::error('Password has not been updated, nothing changed in password', 'failed')->persistent("Close this");
                return redirect('/change-password');
            } else {
                if ($request->new_password == $request->confirm_password) {
                    User::where('id', $id)->update([
                        'password' => Hash::make($request->confirm_password)
                    ]);
                    Alert::success('Password has been updated', 'success');
                    return redirect('/change-password');
                } else {
                    Alert::error('Password not match, Password has not been updated', 'failed')->persistent("Close this");
                    return redirect('/change-password');
                }
            }
        } else {
            Alert::error('Password not match with old password, Password has not been updated', 'failed')->persistent("Close this");
            return redirect('/change-password');
        }
    }
}
