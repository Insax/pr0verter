<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $guids = DB::table('data')->where([['user_id', '=', Auth::id()], ['deleted', '=', 0]])->get();
        $guids ? : $guids = 'Du hast bisher keine Videos hochgeladen';
        return view('home', ['guids' => $guids]);
    }
}
