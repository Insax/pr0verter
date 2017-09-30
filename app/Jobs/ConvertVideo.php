<?php

namespace App\Jobs;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Coordinate\Dimension;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $filters;
    /**
     * @var int
     */
    private $maxDuration;

    /**
     * @var float
     */
    private $duration;
    /**
     * @var int
     */
    private $status;

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
     * @var float
     */
    private $px;

    /**
     * @var float
     */
    private $py;

    /**
     * @var
     */
    private $start;

    /**
     * @var
     */
    private $end;

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
    public function __construct($loc, $name, $sound, $res, $limit, $start, $end)
    {
        $this->loc = $loc;
        $this->name = $name;
        $this->sound = $sound;
        $this->res = $res;
        $this->limit = $limit;
        $this->start = $start;
        $this->end = $end;

        $this->maxDuration = env('VIDEO_MAX_DURATION_IN_SECONDS', 179);

        $this->params = [
            'ffmpeg.binaries' => env('FFMPEG_BIN', '/usr/local/bin/ffmpeg'),
            'ffmpeg.threads' => env('FFMPEG_THREADS', 12),
            'ffprobe.binaries' => env('FFMPEG_PROBE_BIN', '/usr/local/bin/ffprobe'),
            'timeout' => env('FFMPEG_TIMEOUT', 3600), ];

        $this->filters = [
            '-profile:v', 'baseline',
            '-level', '3.0',
            '-preset', 'medium',
            '-fs', $this->limit * 8192 .'k',
            '-movflags', '+faststart',
        ];
    }

    /**
     * Execute the job.
     *
     * converts video
     * short description of parameters
     * -t: set max video length
     * -profile:v baseline -level 3.0: pr0gramm only supports baseline lv 3.0
     * -preset: sets conversion speed
     * -fs: ffmpeg cuts on this size
     *
     * @return void
     */
    public function handle()
    {
        $ffprobe = FFProbe::create($this->params);
        $ffmpeg = FFMpeg::create($this->params);

        if ($this->isGif()) {
            $this->duration = $this->getGIFDuration();
            $this->sound = 0;

            $this->filters[] = '-pix_fmt';
            $this->filters[] = 'yuv420p';
        } else {
            $this->duration = (float) $ffprobe->format($this->loc.'/'.$this->name)->get('duration');
        }

        $this->px = $ffprobe->streams($this->loc.'/'.$this->name)->videos()->first()->getDimensions()->getWidth();
        $this->py = $ffprobe->streams($this->loc.'/'.$this->name)->videos()->first()->getDimensions()->getHeight();

        $video = $ffmpeg->open($this->loc.'/'.$this->name);

        if (! $this->res) {
            $this->getAutoResolution();
            $video->filters()->resize(new Dimension($this->px, $this->py));
        }

        if ($this->start > $this->duration) {
            $this->start = 0;
        }

        if ($this->end > $this->duration) {
            $this->end = $this->duration;
        }

        if (($this->end - $this->start) > $this->maxDuration) {
            $this->end = $this->start + $this->maxDuration;
        }

        if ($this->start || $this->end) {
            $this->duration = $this->end - $this->start;
        }

        if (! $this->start && ! $this->end) {
            $video->filters()->clip(TimeCode::fromSeconds($this->start), TimeCode::fromSeconds($this->maxDuration));
        }

        if ($this->start || $this->end) {
            $video->filters()->clip(TimeCode::fromSeconds($this->start), TimeCode::fromSeconds($this->duration));
        }

        $format = new X264();
        $format->setAudioCodec('aac');
        switch ($this->sound) {
            case 0:
                $this->filters[] = '-an';
                break;
            case 1:
                $format->setAudioKiloBitrate(60); // test value
                break;
            case 2:
                $format->setAudioKiloBitrate(120);
                break;
            case 3:
                $format->setAudioKiloBitrate(190); // test value
                break;
        }

        $format->setAdditionalParameters($this->filters);
        $format->setPasses(2);
        $format->setKiloBitrate($this->getBitrate($format->getAudioKiloBitrate()));

        $format->on('progress', function ($video, $format, $percentage) {
            DB::table('data')->where('guid', $this->name)->update(['progress' => $percentage]);
        });

        if ($video->save($format, $this->loc.'/public/'.$this->name.'.mp4')) {
            DB::table('data')->where('guid', $this->name)->update(['progress' => 100]);
        }
    }

    private function getBitrate($audioBitrate)
    {
        $this->duration = min($this->duration, $this->maxDuration);

        $bitrate = ($this->limit * 8000) / (float) $this->duration;

        ! $this->sound ?: $bitrate -= $audioBitrate;

        return $bitrate;
    }

    private function getAutoResolution()
    {
        if ($this->duration > 30 && $this->duration < 60 && $this->px >= 480) {
            if ($this->px * (16 / 9) === $this->py) {
                $this->px = 576;
                $this->py = 1024;
            } else {
                if ($this->px > 480 && $this->py < 720) {
                    $this->px /= 1.5;
                    $this->py /= 1.5;
                } elseif ($this->px > 720) {
                    $this->px /= 2;
                    $this->py /= 2;
                }
            }
        }
        if ($this->duration > 60 && $this->duration < 110 && $this->px > 480) {
            if ($this->px * (16 / 9) === $this->py) {
                $this->px = 480;
                $this->py = 854;
            } else {
                if ($this->px > 480 && $this->py < 720) {
                    $this->px /= 1.6; // WARNGING: Test Values
                    $this->py /= 1.6; //
                } elseif ($this->px > 720) {
                    $this->px /= 2.1; //
                    $this->py /= 2.1; //
                }
            }
        }
        if ($this->duration > 110 && $this->px > 480) {
            if ($this->px * (16 / 9) === $this->py) {
                $this->px = 432;
                $this->py = 768;
            } else {
                if ($this->px > 480 && $this->py < 720) {
                    $this->px /= 1.9; // test
                    $this->py /= 1.9; //
                } elseif ($this->px > 720) {
                    $this->px /= 2.5; //
                    $this->py /= 2.5; //
                }
            }
        }
        $this->px = round($this->px);
        $this->py = round($this->py);

        // resolution has to be even
        if ($this->px % 2 != 0) {
            $this->px++;
        }
        if ($this->py % 2 != 0) {
            $this->py++;
        }
    }

    private function getGIFDuration()
    {
        $gif_graphic_control_extension = '/21f904[0-9a-f]{2}([0-9a-f]{4})[0-9a-f]{2}00/';
        $file = file_get_contents($this->loc.'/'.$this->name);
        $file = bin2hex($file);

        $total_delay = 0;
        preg_match_all($gif_graphic_control_extension, $file, $matches);
        foreach ($matches[1] as $match) {
            $delay = hexdec(substr($match, -2).substr($match, 0, 2));
            if ($delay == 0) {
                $delay = 1;
            }
            $total_delay += $delay;
        }

        $total_delay /= 100;

        return $total_delay;
    }

    private function isGif()
    {
        if (strtolower(DB::table('data')->where('guid', $this->name)->value('origEnding')) === '.gif') {
            return true;
        } else {
            return false;
        }
    }

    public function failed()
    {
        DB::table('data')->where('guid', $this->name)->update(['progress' => 420]);
    }
}
