<?php

namespace App\Http\Requests;


use Ixudra\Curl\Facades\Curl;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileToConvert extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url'               => 'nullable|string|max:255',
            'limit'             => 'required|integer',
            'sound'             => 'required|string|max:2',
            'autoResolution'    => 'nullable|string|max:2',
            'file'              => 'nullable|mimes:webm,mp4,mkv,mov,avi,wmv,flv,3gp,gif',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = (object) $validator->getData();
            if ($data->url)
                if (! $this->validateRemoteFile($data->url))
                    $validator->errors()->add('url', 'Bitte eine richtige URL angeben!');

            if ($data->youtube)
                if(!Youtube::getVideoInfo(Youtube::parseVidFromURL($data->youtube)))
                    $validator->errors()->add('youtube', 'Diese Youtube Adresse ist nicht gültig');
                elseif($this->YTDurationToSeconds(Youtube::getVideoInfo(Youtube::parseVidFromURL($data->youtube))->contentDetails->duration) > (40*60))
                    $validator->errors()->add('youtube', 'Dieses Youtube Video ist zu lang!');

            if($data->cutstart && $data->cutend && $data->cutstart > $data->cutend)
                $validator->errors()->add('cutstart', 'Der Start des Videos kann nicht nach dem Ende sein!');
        });
    }

    private function YTDurationToSeconds($duration) {
        $match = preg_match($duration, '/PT(\d+H)?(\d+M)?(\d+S)?/');
        $hours = (intval($match[1]) || 0);
        $minutes = (intval($match[2]) || 0);
        $seconds = (intval($match[3]) || 0);
        return $hours * 3600 + $minutes * 60 + $seconds;
    }

    /**
     * Validate the remote file given by url.
     *
     * @param $url
     * @return bool
     */
    private function validateRemoteFile($url)
    {
        $data = Curl::to($url)->allowRedirect()->withOption('NOBODY', true)->withOption('HEADER', true)->get();

        if ($data) {
            if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches)) {
                $status = (int) $matches[1];
            }

            if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
                $contentLength = (int) $matches[1];
            }

            if (preg_match('/Content-Type: (\w+\/\w+)/', $data, $matches)) {
                $contentType = $matches[1];
            }

            if (isset($status)) {
                if ($status == 200 || ($status > 300 && $status <= 308)) {
                    if (isset($contentLength)) {
                        $contentSize = $contentLength;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }

            if (isset($contentType)) {
                if (($contentType === 'image/gif' || (preg_match('/^video\/.*/', $contentType))) && $contentSize < 104857600) {
                    return true;
                } else {
                    return false;
                }
            }

            return false;
        }

        return false;
    }
}
