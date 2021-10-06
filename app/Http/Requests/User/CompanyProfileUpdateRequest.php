<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileUpdateRequest extends FormRequest
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
            // Company 
            'company_name' => [
                'required', 'min:3', 'max:255'
            ],
            'copmany_address' => [
                'required', 'min:3', 'max:255'
            ],
            'state' => [
                'required'
            ],
            'lga' => [
                'required'
            ],
            'category' => [
                'required'
            ],


            // Business 
            'pharmacist_name' => [
                'required', 'min:3', 'max:255'
            ],
            'pharmacist_registration_number' => [
                'required', 'min:3', 'max:255'
            ],
            // 'supporting_document' => [
            //     'required'
            // ],
            // 'passport' => [
            //     'required'
            // ],

            // Director 
            // 'director_name' => [
            //     'required', 'min:3', 'max:255'
            // ],
            // 'director_registration_number' => [
            //     'required', 'min:3', 'max:255'
            // ],
            // 'director_licence_number' => [
            //     'required'
            // ],


            // Other Director 
            // 'other_director_name' => [
            //     'required', 'min:3', 'max:255'
            // ],
            // 'other_director_profession' => [
            //     'required', 'min:3', 'max:255'
            // ]
            
        ];
    }
}
