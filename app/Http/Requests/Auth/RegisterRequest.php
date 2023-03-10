<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:6|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'age' => 'integer|min:16|max:102',
            'password' => 'required|min:6|max:255|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            "required" => "Toto pole je povinné",
            "email.email" => "Email musí mať správny formát",
            "email.unique" => "Tento email je už zaregistrovaný",
            "age.min" => "Musíte mať viac ako 16 rokov",
            "age.max" => "Musíte mať menej ako 102 rokov",
            "password.min" => "Heslo musí mať najmennej 6 znakov",
            "password.confirmed" => "Heslá sa musia zhodovať",
        ];
    }
}
