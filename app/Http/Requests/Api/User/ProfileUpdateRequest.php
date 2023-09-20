<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileUpdateRequest extends FormRequest
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
            'last_name' => 'required|string',
//            'email' => 'required|email|unique:clients,email,' . auth('client')->user()->id,
//            'country_code' => 'required|string',
//            'phone' => 'required|string|unique:clients,phone,' . auth('client')->user()->id,
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:20480',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $error = implode('- ',$validator->errors()->all());
        throw new HttpResponseException(
            msg(false, $error, failed())
        );
    }
}
