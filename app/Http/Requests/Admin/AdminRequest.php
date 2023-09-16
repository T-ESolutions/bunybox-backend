<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $this->id,
            'phone' => 'required|digits:12|regex:/(966)[0-9]{8}/|unique:admins,phone,' . $this->id,
            'password' => ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
                Rule::requiredIf($this->routeIs('admins.store'))],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg'],

        ];
    }
}
