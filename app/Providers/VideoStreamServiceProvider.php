<?php

namespace App\Providers;
use App\Helpers\VideoStream;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class VideoStreamServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('VideoStream', function () {
            return new VideoStream;
        });
    }
}
