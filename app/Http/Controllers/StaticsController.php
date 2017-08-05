<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class StaticsController extends Controller
{
    public function index()
    {
        return view('statics.index');
    }

    public function error(Request $request)
    {
        if($request->input('type') === 'vid')
            return view('error.errorVid');
        else if($request->input('type') === 'yt')
            return view('error.errorYT');
        else
            Redirect::route('index');

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
