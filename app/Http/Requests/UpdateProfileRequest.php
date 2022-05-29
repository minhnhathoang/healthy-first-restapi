<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'surname' => 'string',
            'last_name' => 'required|string',
            'address' => 'string',
            'gender' => 'boolean',
            'mobile' => 'digits_between:10,12',
            'birthday' => 'date'
        ];
    }
}
