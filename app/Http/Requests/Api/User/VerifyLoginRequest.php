<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class VerifyLoginRequest extends FormRequest
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
            'country_code' => 'required|string',
            'phone' => 'required|exists:users,phone',
            'token' => 'required|numeric|digits:4',
            'fcm_token' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $error = implode('- ', $validator->errors()->all());
        throw new HttpResponseException(
            msg(false, $error, failed())
        );
    }
}
