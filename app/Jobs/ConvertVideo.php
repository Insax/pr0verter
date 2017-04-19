<?php

namespace App\Jobs;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $duration;
    /**
     * @var integer
     */
    public $status;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $loc;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $sound;

    /**
     * @var bool
     */
    private $res;

    /**
     * @var bool
     */
    private $limit;

    /**
     * Create a new job instance.
     *
     * @param $loc
     * @param $name
     * @param $sound
     * @param $res
     * @param $limit
     * @return void
     */

    public function __construct($loc, $name, $sound, $res, $limit)
    {
        $this->loc = $loc;
        $this->name = $name;
        $this->sound = $sound;
        $this->res  = $res;
        $this->limit = $limit;

        $this->params = [
            'ffmpeg.binaries'   => env('FFMPEG_BIN', '/usr/local/bin/ffmpeg'),
            'ffmpeg.threads'    => env('FFMPEG_THREADS', 12),
            'ffprobe.binaries'  => env('FFMPEG_PROBE_BIN', '/usr/local/bin/ffprobe'),
            'timeout'           => env('FFMPEG_TIMEOUT', 3600)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ffprobe  = FFProbe::create($this->params);
        $ffmpeg   = FFMpeg::create($this->params);


        $this->duration = $ffprobe
            ->format($this->loc.'/'.$this->name) // extracts file informations
            ->get('duration');             // returns the duration property

        $video = $ffmpeg->open($this->loc.'/'.$this->name);
        //TODO: Format Logic here!
        $format = new X264();
        $format->setAudioCodec('aac');
        $format->on('progress', function ($video, $format, $percentage) {
            //TODO: Insert into DB --
        });

        if($video->save($format, $this->loc.'/public/'.$this->name.'.mp4')) {
            //TODO: Set Percentage to 100% and send update to client.
        }
    }
}
