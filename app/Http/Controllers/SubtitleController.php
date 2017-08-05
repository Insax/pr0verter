<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubtitleController extends Controller
{
    public function index()
    {
        return view('subtitle.home');
    }
}
