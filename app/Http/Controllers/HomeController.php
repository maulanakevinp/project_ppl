<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\UserMenu;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $users = User::all();
        return view('index', compact('title', 'users'));
    }
}
