<?php

namespace App\Http\Requests\PpmvLocation;

use Illuminate\Foundation\Http\FormRequest;

class PpmvLocationStoreRequest extends FormRequest
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
                'required'
            ],
            'educational_certificate' => [
                'required'
            ],
            'income_tax' => [
                'required'
            ],
            'handwritten_certificate' => [
                'required'
            ],
            'reference_1_name' => [
                'required'
            ],
            'reference_1_phone' => [
                'required'
            ],
            'reference_1_email' => [
                'required'
            ],
            'reference_1_address' => [
                'required', 'min:3', 'max:255'
            ],
            'reference_1_letter' => [
                'required'
            ],
            'reference_2_name' => [
                'required'
            ],
            'reference_2_phone' => [
                'required'
            ],
            'reference_2_email' => [
                'required'
            ],
            'reference_2_address' => [
                'required', 'min:3', 'max:255'
            ],
            'reference_2_letter' => [
                'required'
            ],
            'current_annual_licence' => [
                'required', 'min:3', 'max:255'
            ],
            'reference_occupation' => [
                'required', 'min:3', 'max:255'
            ],
            'terms' => [
                'required'
            ]
        ];
    }
}
