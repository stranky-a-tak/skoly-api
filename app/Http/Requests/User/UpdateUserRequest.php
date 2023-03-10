<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'min:6|max:255',
            'age' => 'integer|min:16|max:102',
        ];
    }

    public function messages()
    {
        return [
            "age.min" => "Musíte mať viac ako 16 rokov",
            "age.max" => "Musíte mať menej ako 102 rokov",
        ];
    }
}
