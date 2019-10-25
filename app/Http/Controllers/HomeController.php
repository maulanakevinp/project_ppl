<?php

namespace App\Http\Controllers;

use App\Forest;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Head of Departement';
        $users = User::all();
        $forests = Forest::all();
        return view('home', compact('title','users', 'forests'));
    }
}
