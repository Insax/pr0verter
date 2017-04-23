<?php

namespace App\Http\Controllers;


use App\Jobs\ConvertVideo;
use App\Facades\VideoStream;
use Ixudra\Curl\Facades\Curl;
use App\Http\Requests\CanDelete;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\AskForDuration;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UploadFileToConvert;
use Illuminate\Support\Facades\File;




class ConverterController extends Controller
{
    /**
     * Upload Handling Method - Redirects to Front or Progress Page
     *
     * @param UploadFileToConvert $request
     * @return $this|string
     */
    public function convert(UploadFileToConvert $request)
    {
        $saveLocation             = storage_path().'/app';
        $rndName                  = str_random(64);
        $requestSound             = $request->input('sound', 0);
        $requestAutoResolution    = $request->input('autoResolution', 'off');
        $requestLimit             = $request->input('limit', 6);
        $requestURL               = $request->input('url');
        $requestFile              = $request->file('file');

        while(1) {
            if(DB::table('data')->where('guid', '=', $rndName)->value('guid')) {
                $rndName = str_random(64);
            }
            else
                break;
        }

        if($requestLimit > 30)
            $requestLimit = 30;
        if($requestLimit < 1)
            $requestLimit = 1;

        if($requestSound > 3)
            $requestSound = 3;
        if($requestSound < 0)
            $requestSound = 0;

        if($requestAutoResolution === 'on')
            $requestAutoResolution = true;
        else
            $requestAutoResolution = false;

        if($requestFile) {
            $extension = '.'.Input::file('file')->getClientOriginalExtension();
            Input::file('file')->move($saveLocation, $rndName);
            $this->saveToDB($rndName, $extension);
            dispatch((new ConvertVideo($saveLocation, $rndName, $requestSound, $requestAutoResolution, $requestLimit))->onQueue('convert'));
            $data = ['sucess' => true, 'guid' => $rndName];
            echo json_encode($data);

        }
        elseif ($requestURL) {
            $extension = $this->getExtension($requestURL);
            Curl::to($requestURL)->download($saveLocation.'/'.$rndName);
            $this->saveToDB($rndName, $extension);
            dispatch((new ConvertVideo($saveLocation, $rndName, $requestSound, $requestAutoResolution, $requestLimit))->onQueue('convert'));
            $data = ['sucess' => true, 'guid' => $rndName];
            echo json_encode($data);
        }
        else
            return back()->withInput();


    }

    /**
     * @param $guid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function progress($guid)
    {
        if(DB::table('data')->where('guid', '=', $guid)->value('guid') == $guid)
            return view('converter.progress', ['guid' => $guid]);
        else
            return view('error.404');
    }

    /**
     * @param $guid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($guid)
    {
        if(DB::table('data')->where(['guid', '=', $guid])->value('guid') == $guid)
            return view('converter.show', ['view' => route('view', ['guid' => $guid]), 'download' => route('download', ['guid' => $guid])]);
        else
            return view('error.404');
    }

    /**
     * @param $guid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($guid)
    {
        if(DB::table('data')->where('guid', '=', $guid)->value('guid') == $guid)
        {
            VideoStream::start(storage_path().'/app/public/'.$guid.'.mp4');
        }
        else
            return view('error.404');
    }

    /**
     * @param $guid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function download($guid)
    {
        if(DB::table('data')->where('guid', '=', $guid)->value('guid') == $guid)
        {
            return response()->download(storage_path().'/app/public/'.$guid.'.mp4');
        }
        else
            return view('error.404');
    }

    /**
     * @param AskForDuration $request
     * @return string
     */
    public function duration(AskForDuration $request)
    {
        $guid = $request->input('file_name');
        if(DB::table('data')->where('guid', '=', $guid)->value('guid') == $guid)
        {
            return DB::table('data')->where('guid', $guid)->value('progress');
        }
        else
            return 'error';
    }

    /**
     * Return the extension of a given remote file
     *
     * @return string
     */
    private function getExtension($url)
    {
        $name = explode(".", $url);
        $elementCount = count($name);
        return '.'.$name[$elementCount - 1];
    }

    /**
     * Save validated data to DB
     *
     * @param $name
     * @param $ext
     *
     * @return void
     */
    private function saveToDB($name, $ext)
    {
        DB::table('data')->insert([[
            'guid' => $name,
            'origEnding' => $ext,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]]);
    }

}