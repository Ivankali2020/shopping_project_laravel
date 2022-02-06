<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name'=>'required',
            'email' => 'required|email', //|unique:users,'.$this->user->id
            'role' => 'required|min:0|max:1',
            'password' => 'required|min:3|max:8',
        ];
    }

    public function messages()
    {
        return [
            'email.*' => 'email is alredy takern'
        ];
    }
}
