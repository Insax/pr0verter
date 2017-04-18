<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadFileToConvert;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;
use Ixudra\Curl\Facades\Curl;

class ConverterController extends Controller
{
    private $saveLocation;
    private $rndName;
    private $requestSound;
    private $requestAutoResolution;
    private $requestLimit;
    private $requestURL;
    private $requestFile;

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
     * Handling after Fileupload is Requested, Checked and Validated
     *
     * @param UploadFileToConvert $request
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

        if(!$this->requestURL && !$this->requestFile)
            Redirect::url('converter');

        if($this->requestFile) {
            $this->rndName .= '.'.Input::file('file')->getClientOriginalExtension();
            Input::file('file')->move($this->saveLocation, $this->rndName);
            $this->convert();
        }
        elseif ($this->requestURL) {
            if($this->validateRemoteFile()) {
                $this->rndName .= $this->getExtension();
                Curl::to($this->requestURL)->download($this->saveLocation.'/'.$this->rndName);
                $this->convert();
            }
        }


    }


    private function convert() {

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
}