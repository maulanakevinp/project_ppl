<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use File;
use Alert;
use App\Forest;
use App\Http\Requests\UserRequest;
use App\Rules\Lat1;
use App\Rules\Lat2;
use App\Rules\Long1;
use App\Rules\Long2;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

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
        return view('users.index', compact('title', 'users'));
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
        return view('users.create', compact('title', 'subtitle', 'users', 'user_role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User;

        $request->validated();
        $user->role_id          = $request->role;
        $user->nip              = $request->nip;
        $user->name             = $request->name;
        $user->image            = $this->setImageUpload($request->file('image'), 'img/profile');
        $user->password         = Hash::make('rahasia');
        $user->reset_password   = Hash::make('rahasia');

        if ($request->role == 3) {
            $this->getRuleArea($request);
            $user->latitude1    = $request->latitude1;
            $user->longitude1   = $request->longitude1;
            $user->latitude2    = $request->latitude2;
            $user->longitude2   = $request->longitude2;
        }

        $user->save();

        Alert::success('User has been added', 'success');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified forest.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title = 'Detail User';
        $user = User::findOrFail($id);
        return view('users.show', compact('user', 'title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myProfile()
    {
        $title = auth()->user()->name;
        return view('users.my-profile', compact('title'));
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
        return view('users.edit', compact('title', 'subtitle', 'user', 'user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $request->validated();

        if ($request->file('image')) {
            $user->image = $this->setImageUpload($request->file('image'),'img/profile',$user->image);
        }

        if ($request->role == 3) {
            $this->getRuleArea($request);
            $user->latitude1    = $request->latitude1;
            $user->longitude1   = $request->longitude1;
            $user->latitude2    = $request->latitude2;
            $user->longitude2   = $request->longitude2;
        } else {
            $user->latitude1    = null;
            $user->longitude1   = null;
            $user->latitude2    = null;
            $user->longitude2   = null;
        }

        $user->role_id = $request->role;
        $user->name = $request->name;
        $user->nip  = $request->nip;
        $user->save();

        Alert::success('User has been updated', 'success');
        return redirect()->back();
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
        $data = DB::table('users')->where('id', $id)->first();
        
        $forests = Forest::whereCreatorId($id)->get();
        if($forests){
            foreach ($forests as $forest) {
                File::delete(public_path('img/nik/'.$forest->nik_file));
                File::delete(public_path('img/photo/'.$forest->photo_file));
            }
        }

        File::delete(public_path('img/profile/' . $data->image));

        $user->forceDelete();
        Alert::success('User has been deleted', 'success');
        return redirect('/users/deleted');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        Alert::success('User has been deleted', 'success');
        return redirect('/users');
    }

    public function showDeleted()
    {
        $title = 'Users';
        $subtitle = 'Users Trash';
        $users = User::onlyTrashed()->get();
        return view('users.deleted', compact('title', 'subtitle', 'users'));
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
        $user->password = $user->reset_password;
        $user->save();

        Alert::success('Password has been reset', 'success');
        return redirect('/users');
    }

    public function editProfile()
    {
        $title = auth()->user()->name;
        return view('users.edit-profile', compact('title'));
    }

    public function updateProfile(UserRequest $request, $id)
    {
        $user = User::find($id);
        $request->validated();

        if ($request->file('image')) {
            $user->image = $this->setImageUpload($request->file('image'),'img/profile',$user->image);
        }

        $user->name = $request->name;
        $user->save();
        Alert::success('Profile has been updated', 'success');
        return redirect('/my-profile');
    }

    public function changePassword()
    {
        $title = auth()->user()->name;
        return view('users.change-password', compact('title'));
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
                    return redirect('/my-profile');
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

    public function setImageUpload($file, $path, $old_file = null)
    {
        $file_name = time() . "_" . $file->getClientOriginalName();
        if ($file->move(public_path($path), $file_name)) {
            if ($old_file != "default.jpg") {
                File::delete(public_path($path . '/' . $old_file));
            }
            return $file_name;
        } else {
            Alert::error('Foto gagal diunggah', 'gagal')->persistent('tutup');
            return redirect()->back();
        }
    }

    private function getRuleArea($request)
    {
        $request->validate([
            'latitude1'     => ['required', new Lat1($request->latitude2)],
            'longitude1'    => ['required', new Long1($request->longitude2)],
            'latitude2'     => ['required', new Lat2($request->latitude1)],
            'longitude2'    => ['required', new Long2($request->longitude1)],
        ]);
    }

    public function getUser()
    {
        $users = User::with('role')->select('users.*');
        return DataTables::eloquent($users)
            ->addColumn('action', function ($user) {
                if (auth()->user()->role_id == 1) {
                    $output = '<a href="' . route('users.edit', $user->id) . '" class="btn btn-warning btn-sm" data-toggle="tool-tip" title="Edit"><i class="fas fa-edit"></i></a>';
                    if ($user->id != auth()->user()->id) {
                        $output .= '
                            <form class="d-inline-block" action="' . route('users.delete', $user->id) . '" method="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tool-tip" title="Delete" onclick="return confirm(`Are you sure want to delete this ' . $user->name . ' user?`)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <form class="d-inline-block" action="' . route('users.password_reset', $user->id) . '" method="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="patch">
                                <button type="submit" class="btn btn-dark btn-sm" data-toggle="tool-tip" title="Reset Password" onclick="return confirm(`return confirm(`Are you sure want to reset this password ' . $user->name . ' user?`)`);">
                                    <i class="fas fa-key"></i>
                                </button>
                            </form>
                        ';
                    }
                } elseif (auth()->user()->role_id == 2) {
                    $output = '<a href="' . route('users.show', $user->id) . '" class="btn btn-info btn-sm" data-toggle="tool-tip" title="Detail User"><i class="fas fa-eye"></i></a>';
                }
                return $output;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getUserDeleted()
    {
        $users = User::with('role')->onlyTrashed();
        return DataTables::eloquent($users)
            ->addColumn('action', function ($user) {
                return '
                    <form class="d-inline-block" action="' . route('users.restore', $user->id) . '" method="post">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="put">
                        <button type="submit" class="btn btn-warning btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="kembalikan" onclick="return confirm(`Are you sure want to restore this ' . $user->name . ' user?`)">
                            <i class="fas fa-trash-restore"></i>
                        </button>
                    </form>
                    <form class="d-inline-block" action="' . route('users.destroy', $user->id) . '" method="post">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="hapus" onclick="return confirm(`Are you sure want to delete this ' . $user->name . ' user?`)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getDetailUser(Request $request)
    {
        $user = User::with('role')->findOrFail($request->id);
        echo json_encode($user);
    }
}
