<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
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
            'collage_id' => 'required',
            'user_id' => 'nullable|unique:ratings,user_id,NULL,id,collage_id,' . $this->input('collage_id'),
            'user_ip' => 'unique:ratings,user_ip,NULL,id,collage_id,' . $this->input('collage_id'),
            'rating' => 'required',
            'body' => 'required|max:255',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['user_ip' => $this->ip()]);
    }

    public function messages()
    {
        return [
            'unique' => 'Už ste raz ohodnotili túto školu',
            'required' => 'Toto pole je povinné'
        ];
    }
}
