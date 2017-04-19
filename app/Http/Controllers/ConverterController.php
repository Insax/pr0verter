<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertVideo;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UploadFileToConvert;
use FFMpeg\Format\ProgressListener\VideoProgressListener;



class ConverterController extends Controller
{
    /**
     * @var array
     */
    private $params;


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
     *
     * @param UploadFileToConvert $request
     * @return $this|string
     */
    public function upload(UploadFileToConvert $request)
    {
        $saveLocation             = storage_path().'/app';
        $rndName                  = str_random(64);
        $requestSound             = $request->input('sound', 'off');
        $requestAutoResolution    = $request->input('autoResolution', 'off');
        $requestLimit             = $request->input('limit', 6);
        $requestURL               = $request->input('url');
        $requestFile              = $request->file('file');

        if($requestLimit > 30)
            $requestLimit = 30;
        if($requestLimit < 1)
            $requestLimit = 1;

        if($requestSound === 'on')
            $requestSound = true;
        else
            $requestSound = false;

        if($requestAutoResolution === 'on')
            $requestAutoResolution = true;
        else
            $requestAutoResolution = false;

        if($requestFile) {
            $extension = '.'.Input::file('file')->getClientOriginalExtension();
            Input::file('file')->move($saveLocation, $rndName);
            $this->saveToDB($rndName, $extension);
            dispatch(new ConvertVideo($saveLocation, $rndName, $requestSound, $requestAutoResolution, $requestLimit));
            echo '<meta http-equiv="refresh" content="0;url=/progress/'.$rndName.'\" />';

        }
        elseif ($requestURL) {
            if($this->validateRemoteFile($requestURL)) {
                $extension = $this->getExtension($requestURL);
                Curl::to($requestURL)->download($saveLocation.'/'.$rndName);
                $this->saveToDB($rndName, $extension);
                dispatch(new ConvertVideo($saveLocation, $rndName, $requestSound, $requestAutoResolution, $requestLimit));
                echo '<meta http-equiv="refresh" content="0;url=/progress/'.$rndName.'\" />';

            }
            else
                return back()->withInput();
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
        if(DB::table('data')->where('guid', $guid)->value('guid') == $guid) {
            var_dump();
            //return view('converter.progress');
        }
        else
            return redirect()->route('welcome');

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
     * Validate the remote file given by url.
     *
     * @param $url
     * @return bool
     */
    private function validateRemoteFile($url)
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
        Auth::guest() ? $userID = 0 : $userID = Auth::id();
        DB::table('data')->insert([[
            'guid' => $name,
            'user_id' => $userID,
            'uploader_ip' => Request::ip(),
            'deleted' => 0,
            'duration' => 0,
            'origEnding' => $ext,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]]);
    }

}