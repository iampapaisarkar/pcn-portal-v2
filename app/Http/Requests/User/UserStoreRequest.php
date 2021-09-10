<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserStoreRequest extends FormRequest
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
                'required', 'min:3', 'max:255'
            ],
            'lastname' => [
                'required', 'min:3', 'max:255'
            ],
            'email' => [
                'required', Rule::unique((new User)->getTable())->ignore($this->route()->user ?? null)
            ],
            'phone' => [
                'required'
            ],
            'type' => [
                'required'
            ],
            'state' => [
                $this->type == 'state_office' ? 'required' : 'nullable'
            ]
        ];
    }
}
