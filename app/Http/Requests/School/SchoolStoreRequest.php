<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\School;

class SchoolStoreRequest extends FormRequest
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
            'name' => [
                'required', 'min:3', 'max:255'
            ],
            'code' => [
                'required', Rule::unique((new School)->getTable())->ignore($this->route()->school ?? null)
            ],
            'state' => [
                'required'
            ]
        ];
    }
}
