<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'firstname' => [
                'required'
            ],
            // 'middlename' => [
            //     'required'
            // ],
            'surname' => [
                'required'
            ],
            'email' => [
                'required'
            ],
            'phone' => [
                'required'
            ],
            'gender' => [
                'required'
            ],
            'doq' => [
                'required'
            ],
            'residental_address' => [
                'required'
            ],
            'annual_licence_no' => [
                'required'
            ]
        ];
    }
}
