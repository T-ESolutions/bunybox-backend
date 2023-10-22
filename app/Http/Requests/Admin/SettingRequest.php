<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'site_name_ar' => 'sometimes|string|max:255',
            'site_name_en' => 'sometimes|string|max:255',
            'phone_1' => 'sometimes|max:255|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone_2' => 'sometimes|max:255|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email_1' => 'sometimes|string|email|max:255',
            'email_2' => 'sometimes|string|email|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'snapchat' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'address_ar' => 'nullable|string|max:255',
            'address_en' => 'nullable|string|max:255',
            'logo_ar' => 'nullable|mimes:jpeg,jpg,png',
            'logo_en' => 'nullable|mimes:jpeg,jpg,png',
            'fav_icon' => 'nullable|mimes:ico',
            'shipp_value' => 'nullable|numeric',
            'working_hours_ar' => 'sometimes|string|max:255',
            'working_hours_en' => 'sometimes|string|max:255',
            'freeze_days' => 'nullable|numeric'
        ];
    }
}
