<?php

namespace App\Http\Controllers;

use App\Rules\LoginRule;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip'       => ['required','size:18','required_with:password',new LoginRule($request->password)],
            'password'  => ['required']
        ]);

        return redirect()->route('my_profile');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
