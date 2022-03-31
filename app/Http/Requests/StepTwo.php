<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StepTwo extends FormRequest
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
            'file.*' => 'required|image|mimes:jpg,png,img|max:8192'
        ];
    }
    public function messages()
    {
        return [
            'file.*.image' => 'Attachment file should an image.',
            'file.*.mimes' => 'Attachment file must be a file type: jpg,png,img'
        ];
    }
}
