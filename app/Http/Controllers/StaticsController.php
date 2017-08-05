<?php

namespace App\Http\Controllers;

class StaticsController extends Controller
{
    public function index()
    {
        return view('statics.index');
    }

    public function error()
    {
        return view('statics.error');
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
