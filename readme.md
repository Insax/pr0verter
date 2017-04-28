<p align="center">
<a href="https://travis-ci.org/Insax/pr0verter/"><img src="https://travis-ci.org/Insax/pr0verter.svg" alt="Build Status"></a>
<a href="https://styleci.io/repos/87954236"><img src"https://styleci.io/repos/87954236/shield?branch=master" alt="StyleCI"></a>
</p>

## About pr0verter

pr0verter is a Web Application for manipulating Video Data with FFmpeg.

## Requirements
- Composer
- npm
- php >= 7.0 
- FFMpeg Binarys (`apt-get install ffmpeg`)
- youtube-dl Binarys (`apt-get install youtube-dl`)
- MySQL

## Install instructions
Download this Repository via Clone or Zip Download <br>
Run `composer install`, `cp .env.example .env`, `php artisan key:generate`<br>

Edit .env to your needs <br>
Run `php artisan migrate` <br>
If your queue driver is database, run `php artisan queue:work --queue=convert,download` otherwise your Videos won't get converted and/or downloaded.


###Important notes for .env: <br>
You NEED an <a href="https://github.com/settings/tokens">Github Access Token</a> for the changelog to work <br>
You NEED an <a href="https://console.developers.google.com/apis/credentials">Youtube Data API Token</a> for the Youtube download to work. <br>
If you want to run the converter in background set `QUEUE_DRIVER=sync` to `QUEUE_DRIVER=database`
