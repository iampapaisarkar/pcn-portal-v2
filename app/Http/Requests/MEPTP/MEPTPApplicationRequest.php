<?php

namespace App\Http\Requests\MEPTP;

use Illuminate\Foundation\Http\FormRequest;

class MEPTPApplicationRequest extends FormRequest
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
            'birth_certificate' => [
                // 'required', 'mimes:jpg,jpeg,png,bmp,tiff'
                'required'
            ],
            'educational_certificate' => [
                // 'required', 'mimes:jpg,jpeg,png,bmp,tiff'
                'required'
            ],
            'academic_certificate' => [
                // 'required', 'mimes:jpg,jpeg,png,bmp,tiff'
                'required'
            ],
            'shop_name' => [
                'required', 'min:3', 'max:255'
            ],
            'shop_phone' => [
                'required', 'min:3', 'max:255'
            ],
            'shop_email' => [
                'required', 'email', 'min:3', 'max:64'
            ],
            'shop_address' => [
                'required', 'min:3', 'max:255'
            ],
            'city' => [
                'required', 'min:3', 'max:124'
            ],
            'state' => [
                'required'
            ],
            'lga' => [
                'required'
            ],
            'is_registered' => [
                'required'
            ],
            'ppmvl_no' => [
                $this->is_registered == 'yes' ? 'required' : 'nullable'
            ],
            'school' => [
                'required'
            ]
        ];
    }
}
