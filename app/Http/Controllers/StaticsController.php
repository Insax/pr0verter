<?php

namespace App\Http\Controllers;

use YoutubeDl\YoutubeDl;

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

    public function test()
    {
        $dl = new YoutubeDl(['continue' => true, 'format' => 'bestvideo',]);
        $dl->setDownloadPath(storage_path());
        $video = $dl->download('https://www.youtube.com/watch?v=J7zr1qaeyS0');
        return var_dump($video, $video->getExt(), $video->getFile()->getPathname());
    }
}
