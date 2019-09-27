<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use File;
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
        $title = 'Add User';
        $users = User::all();
        $user_role = UserRole::all();
        return view('user.create', compact('title', 'users', 'user_role'));
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
            'name' => 'required',
            'nrp' => 'required|numeric|min:12',
            'image' => 'required',
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ]);

        $file = $request->file('image');
        $file_name = time() . "_" . $file->getClientOriginalName();
        $move = $file->move('img/profile', $file_name);

        if ($move) {
            User::create([
                'role_id' => $request->role,
                'name' => $request->name,
                'nrp' => $request->nrp,
                'image' => $file_name,
                'password' => Hash::make($request->confirm_password),
            ]);
            return redirect('/users')->with('success', 'Profile has been added');
        } else {
            return redirect('/users')->with('failed', 'Profile has not been added');
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
        $title = 'Edit User';
        $user = User::find($id);
        $user_role = UserRole::all();
        return view('user.edit', compact('title', 'user', 'user_role'));
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
            'nrp' => 'required|numeric',
            'name' => 'required'
        ]);

        $file = $request->file('image');

        if (!empty($file)) {
            $file_name = time() . "_" . $file->getClientOriginalName();
            $delete = File::delete('img/profile/' . $user->image);

            if ($delete) {
                $move = $file->move('img/profile', $file_name);
                if ($move) {
                    User::where('id', $id)->update([
                        'role_id' => $request->role,
                        'name' => $request->name,
                        'image' => $file_name,
                        'nrp' => $request->nrp
                    ]);
                    return redirect('/users')->with('success', 'Profile has been updated');
                } else {
                    return redirect('/users' . '/' . $id . '/edit')->with('failed', 'Photo cannot moved');
                }
            } else {
                return redirect('/users' . '/' . $id . '/edit')->with('failed', 'Photo cannot deleted');
            }
        } else {
            User::where('id', $id)->update([
                'role_id' => $request->role,
                'name' => $request->name,
                'nrp' => $request->nrp
            ]);

            return redirect('/users')->with('success', 'Profile has been updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $delete = File::delete('img/profile/' . $user->image);

        if ($delete) {
            User::destroy($id);
            return redirect('/users')->with('success', 'Profile has been deleted');
        } else {
            return redirect('/users')->with('failed', 'Profile has not been deleted');
        }
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
            'nrp' => 'required|numeric',
            'name' => 'required'
        ]);

        $file = $request->file('image');

        if (!empty($file)) {
            $file_name = time() . "_" . $file->getClientOriginalName();
            $delete = File::delete('img/profile/' . $user->image);

            if ($delete) {
                $move = $file->move('img/profile', $file_name);
                if ($move) {
                    User::where('id', $id)->update([
                        'name' => $request->name,
                        'image' => $file_name,
                        'nrp' => $request->nrp
                    ]);
                    return redirect('/my-profile')->with('success', 'Profile has been updated');
                } else {
                    return redirect('/my-profile')->with('failed', 'Photo cannot moved');
                }
            } else {
                return redirect('/my-profile')->with('failed', 'Photo cannot deleted');
            }
        } else {
            User::where('id', $id)->update([
                'name' => $request->name,
                'nrp' => $request->nrp
            ]);

            return redirect('/my-profile')->with('success', 'Profile has been updated');
        }
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
            if ($request->new_password == $request->confirm_password) {
                User::where('id', $id)->update([
                    'password' => Hash::make($request->confirm_password)
                ]);
                return redirect('/my-profile')->with('success', 'Password has been updated');
            } else {
                return redirect('/my-profile')->with('failed', 'Password not match, Password has not been updated');
            }
        } else {
            return redirect('/my-profile')->with('failed', 'Password not match with old password, Password has not been updated');
        }
    }
}
