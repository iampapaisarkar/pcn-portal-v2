<?php

namespace App\Http\Requests\HospitalPharmacy;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationUpdateRequest extends FormRequest
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
            'bed_capacity' => [
                'required'
            ],
            'pharmacist_name' => [
                'required'
            ],
            'pharmacist_email' => [
                'required'
            ],
            'pharmacist_phone' => [
                'required'
            ],
            'qualification_year' => [
                'required'
            ],
            'residential_address' => [
                'required'
            ]
        ];
    }
}
