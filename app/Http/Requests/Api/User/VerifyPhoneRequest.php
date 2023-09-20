<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyPhoneRequest extends FormRequest
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
            'country_code' => 'required|string',
            'phone' => 'required|string|exists:users,phone',
            'otp' => 'required|numeric|digits:4',
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
