<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Translation\Translator;

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
            'file'              => 'nullable|mimes:webm,mp4,mkv,mov,avi,wmv,flv,3gp',
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
            $data = (object)$validator->getData();
            if($data->url) {
                if (!$this->validateRemoteFile($data->url))
                    $validator->errors()->add('url', 'Bitte eine richtige URL angeben!');
            }
        });
    }

    /**
     * Validate the remote file given by url.
     *
     * @param $url
     * @return bool
     */
    private function validateRemoteFile($url)
    {
        $curl = curl_init($url);
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
