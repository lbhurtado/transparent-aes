<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BallotImageRequest extends FormRequest
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
            'sender_mac_address' => 'required|regex:/^([0-9A-F]{2}[:-]){5}([0-9A-F]{2})$/i',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:4096'
        ];
    }
}
