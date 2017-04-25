<p align="center">
<a href="https://travis-ci.org/Insax/pr0verter/"><img src="https://travis-ci.org/Insax/pr0verter-redone.svg" alt="Build Status"></a>
</p>

## About pr0verter

pr0verter is a Web Application for manipulating Video Data with FFmpeg.

## Requirements
- Composer
- php 7.0 >
- FFMpeg Binarys
- MySQL

## Install instructions
Download this Repository via Clone or Zip Download <br>
Run `composer install`, `cp .env.example .env`, `php artisan key:generate`<br>

Edit .env to your needs <br>
Run `php artisan migrate` <br>
If your queue driver is database, run `php artisan queue:work --queue=convert,default` otherwise your Videos won't get converted.


###Important notes for .env: <br>
You NEED an <a href="https://github.com/settings/tokens">Github Access Token</a> for the changelog to work <br>
If you want to run the converter in background set `QUEUE_DRIVER=sync` to `QUEUE_DRIVER=database`
