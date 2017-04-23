<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticsController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function converter() {
        return view('converter.home');
    }

    public function faq() {
        return view('faq.home');
    }

    public function contact() {
        return view('contact.home');
    }
}
