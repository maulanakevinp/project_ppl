<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|size:18',
            'password' => 'required',
        ]);
        if (!auth()->attempt(['nip' => $request->nip, 'password' => $request->password])) {
            return redirect('/login')->with('failed', 'NIP or Password is wrong');
        }

        return redirect()->route('my-profile');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
