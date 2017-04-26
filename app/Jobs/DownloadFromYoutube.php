<?php

namespace App\Jobs;


use YoutubeDl\YoutubeDl;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class DownloadFromYoutube implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;
    private $loc;
    private $name;
    private $sound;
    private $res;
    private $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $loc, $name, $sound, $res, $limit)
    {
        $this->url = $url;
        $this->loc = $loc;
        $this->name = $name;
        $this->sound = $sound;
        $this->res = $res;
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dl = new YoutubeDl(['continue' => true, 'format' => 'bestvideo']);

        $dl->setDownloadPath($this->loc);
        $video = $dl->download($this->url);
        DB::table('data')->where('guid', '=', $this->name)->update(['origEnding' => '.'.$video->getExt()]);
        File::move($video->getFile()->getPathname(), $this->loc.'/'.$this->name);
        dispatch((new ConvertVideo($this->loc, $this->name, $this->sound, $this->res, $this->limit))->onQueue('convert'));
    }
}
