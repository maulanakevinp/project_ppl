<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserMenu;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        return view('index', compact('title'));
    }
}
