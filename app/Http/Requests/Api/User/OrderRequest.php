<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'box_id' => ['required', 'exists:boxes,id'],
            'main_category_id' => ['required', 'exists:main_categories,id'],
//            'payment_method' => ['required', 'string'],
            'address_id' => ['required', 'exists:addresses,id',
                function ($attribute, $value, $fail) {
                    // Check if the address belongs to the authenticated user
                    $user = Auth::guard('user')->user();
                    if (!$user->addresses()->where('id', $value)->exists()) {
                        $fail("The selected $attribute is invalid.");
                    }
                },],
            'products_id' => ['required', 'array', 'min:2'],
            'products_id.*' => ['required', 'exists:products,id'],

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
