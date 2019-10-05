<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use File;
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
        $title = 'Users Management';
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
        $title = 'Users Management';
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
            return redirect('/users')->with('success', 'User has been added');
        } else {
            return redirect('/users')->with('failed', 'User has not been added');
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
        $title = 'My Profile';
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
        $title = 'Users Management';
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
                return redirect('/users' . '/' . $id . '/edit')->with('failed', 'Photo cannot moved');
            }
        }

        User::where('id', $id)->update([
            'role_id' => $request->role,
            'name' => $request->name,
            'image' => $user->image,
            'nip' => $request->nip
        ]);

        return redirect('/users')->with('success', 'User has been updated');
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
            return redirect('/users')->with('success', 'User has been deleted');
        } else {
            return redirect('/users')->with('failed', 'User has not been deleted');
        }
    }

    public function softdelete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'User has been deleted');
    }

    public function trash()
    {
        $title = 'Users Management';
        $subtitle = 'Users Trash';
        $users = User::onlyTrashed()->get();
        return view('user.trash', compact('title', 'subtitle', 'users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id);
        $user->restore();
        return redirect('/users')->with('success', 'User has been restored');
    }

    public function restoreAll()
    {
        $user = User::onlyTrashed();
        $user->restore();
        return redirect('/users')->with('success', 'User has been restored');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::find($id);
        User::where('id', $id)->update([
            'password' => $user->reset_password
        ]);
        return redirect('/users')->with('success', 'Password has been reset');
    }

    public function editProfile()
    {
        $title = 'Edit Profile';
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
                return redirect('/my-profile')->with('failed', 'Photo cannot moved');
            }
        }

        User::where('id', $id)->update([
            'name' => $request->name,
            'image' => $user->image,
        ]);
        return redirect('/my-profile')->with('success', 'Profile has been updated');
    }

    public function changePassword()
    {
        $title = 'Change Password';
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
                return redirect('/my-profile')->with('failed', 'Password has not been updated, nothing changed in password');
            } else {
                if ($request->new_password == $request->confirm_password) {
                    User::where('id', $id)->update([
                        'password' => Hash::make($request->confirm_password)
                    ]);
                    return redirect('/my-profile')->with('success', 'Password has been updated');
                } else {
                    return redirect('/my-profile')->with('failed', 'Password not match, Password has not been updated');
                }
            }
        } else {
            return redirect('/my-profile')->with('failed', 'Password not match with old password, Password has not been updated');
        }
    }
}
