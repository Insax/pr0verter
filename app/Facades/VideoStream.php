<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;



class VideoStream extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'VideoStream';
    }
}