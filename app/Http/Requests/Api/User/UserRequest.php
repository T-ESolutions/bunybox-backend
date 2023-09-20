<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'country_code' => 'required|string',
            'phone' => 'required|string|max:11|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'age' => 'required|numeric',
            'shoes_size' => 'required|numeric',
            'size' => ['required',Rule::in(User::SIZE)],
            'fcm_token' => 'nullable',
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
