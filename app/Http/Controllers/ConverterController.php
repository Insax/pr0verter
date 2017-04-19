<?php

namespace App\Http\Controllers;

use FFMpeg\Format\Video\X264;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UploadFileToConvert;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;

class ConverterController extends Controller
{
    private $saveLocation;
    private $rndName;
    private $requestSound;
    private $requestAutoResolution;
    private $requestLimit;
    private $requestURL;
    private $requestFile;
    private $requestSubtitle;
    private $userID;
    private $extension;
    private $duration;
    private $status;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Upload Handling Method - Redirects to Front or Progress Page
     * @param UploadFileToConvert $request
     * @return $this|string
     */
    public function upload(UploadFileToConvert $request)
    {
        $this->saveLocation             = storage_path().'/app';
        $this->rndName                  = str_random(64);
        $this->requestSound             = $request->input('sound', 'off');
        $this->requestAutoResolution    = $request->input('autoResolution', 'off');
        $this->requestLimit             = $request->input('limit', 6);
        $this->requestURL               = $request->input('url');
        $this->requestFile              = $request->file('file');
        $this->requestSubtitle          = $request->input('subtitle');


        if($this->requestFile) {
            $this->extension = '.'.Input::file('file')->getClientOriginalExtension();
            Input::file('file')->move($this->saveLocation, $this->rndName);
            $this->saveToDB();
            $this->convert();
            echo '<meta http-equiv="refresh" content="1;url=/progress/'.$this->rndName.'\" />';
        }
        elseif ($this->requestURL) {
            if($this->validateRemoteFile()) {
                $this->extension = $this->getExtension();
                Curl::to($this->requestURL)->download($this->saveLocation.'/'.$this->rndName);
                echo '<meta http-equiv="refresh" content="1;url=/progress/'.$this->rndName.'\" />';
                $this->convert();
            }
            else
                return back()->withInput();
        }
        else
            return back()->withInput();


    }

    public function progress($guid) {
        if(DB::table('data')->where('guid', $guid)->pluck('guid')) {
            return var_dump($this->status);//view('converter.progress');
        }

    }

    public function convert()
    {/*
        $this->status = FFMpeg::open($this->rndName)
            ->export()
            ->toDisk('public')
            ->inFormat(new X264('libfdk_aac', 'libx264')
            ->on('progress', function ($video, $format, $percentage) {
                echo "$percentage % transcoded";
            }))->save($this->rndName . '.mp4');
        die();*/
    }

    private function getExtension() {
        $name = explode(".", $this->requestURL);
        $elementCount = count($name);
        return '.'.$name[$elementCount - 1];
    }

    private function validateRemoteFile()
    {
        $curl = curl_init($this->requestURL);
        curl_setopt( $curl, CURLOPT_NOBODY, true );
        curl_setopt( $curl, CURLOPT_HEADER, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
        $data = curl_exec($curl);

        $response = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        curl_close($curl);

        if($data) {
            $content_length = "unknown";
            $status = "unknown";
            $result = 0;

            if(preg_match("/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches))
                $status = (int)$matches[1];

            if(preg_match("/Content-Length: (\d+)/", $data, $matches))
                $content_length = (int)$matches[1];

            // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
            if($status == 200 || ($status > 300 && $status <= 308))
                $result = $content_length;

            if(preg_match( '/^video.*/', $response) && $result < 104857600)
                return true;
            else
                return false;
        }
        return false;
    }

    private function saveToDB() {
        Auth::guest() ? $this->userID = 0 : $this->userID = Auth::id();
        DB::table('data')->insert([[
            'guid' => $this->rndName,
            'user_id' => $this->userID,
            'uploader_ip' => Request::ip(),
            'deleted' => 0,
            'duration' => 0,
            'origEnding' => $this->extension,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]]);
    }
}