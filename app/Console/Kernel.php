<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $schedule->call(function () {
        $date = new DateTime;
        $date->modify('-1 day');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $data = DB::table('data')->where('created_at', '<', $formatted_date)->get(); Storage::delete($e);
        if ($data) {
          foreach ($data as $e) {
            if(file_exists(storage_path().$e->guid))
            	Storage::delete($e->guid);
            if(file_exists(storage_path().'public/'.$e->guid.'.mp4'))
            	Storage::delete('public/'.$e->guid.'.mp4');
            DB::table('data')->where('guid', '=', $e)->delete();
          }
        }
      })->daily();
    }
    /**
     * Register the Closure based commands for the application
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
