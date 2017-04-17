<?php

return [
    'default_disk' => env('FFMPEG_DISK', 'local'),

    'ffmpeg.binaries' => env('FFMPEG_BIN', '/usr/local/bin/ffmpeg'),
    'ffmpeg.threads'  => env('FFMPEG_THREADS', 12),

    'ffprobe.binaries' => env('FFMPEG_PROBE_BIN', '/usr/local/bin/ffprobe'),

    'timeout' => env('FFMPEG_TIMEOUT', 3600),
];
