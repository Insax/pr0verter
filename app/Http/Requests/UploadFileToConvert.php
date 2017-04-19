<?php

namespace App\Http\Requests;

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
            'limit'             => 'nullable|integer',
            'sound'             => 'nullable|string|max:2',
            'autoResolution'    => 'nullable|string|max:2',
            'subtitle'          => 'nullable|string|max:2',
            'file'              => 'nullable|mimes:webm,mp4,mkv,mov,avi,wmv,flv,3gp,gif,gifv'
        ];
    }
}
