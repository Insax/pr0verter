<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DateTime;

class StaticsController extends Controller
{
    public function index()
    {
        return view('statics.index');
    }

    public function error(Request $request)
    {
        if ($request->input('type') === 'vid') {
            return view('error.errorVid');
        } elseif ($request->input('type') === 'yt') {
            return view('error.errorYT');
        } else {
            Redirect::route('index');
        }
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
