<?php

namespace App\Http\Controllers;

use YoutubeDl\YoutubeDl;
use Alaouy\Youtube\Facades\Youtube;

class StaticsController extends Controller
{
    public function index()
    {
        return view('statics.index');
    }

    public function converter()
    {
        return view('converter.home');
    }

    public function faq()
    {
        return view('statics.faq');
    }

    public function contact()
    {
        return view('statics.contact');
    }
}
