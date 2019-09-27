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
            'nrp' => 'required|numeric',
            'password' => 'required',
        ]);
        if (!auth()->attempt(['nrp' => $request->nrp, 'password' => $request->password])) {
            return redirect('/login')->with('failed', 'NRP or Password is wrong');
        }

        return redirect()->route('my-profile');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
