<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'about_us' => 'nullable|string|max:255',
            'why_us' => 'nullable|string|max:255',
            'goal' => 'nullable|string|max:255',
            'vision' => 'nullable|string|max:255',
            'tax_percentage' => 'nullable|numeric',
            'shipping_fees' => 'nullable|numeric',
            'welcome_text' => 'nullable|string|max:255',
            'home_text' => 'nullable|string|max:255',
            'success_text' => 'nullable|string|max:255',
            'contact_us_text' => 'nullable|string|max:255',
            'terms_text' => 'nullable|string|max:255',
            'phone1' => 'nullable|string|max:255',
            'phone2' => 'nullable|string|max:255',
            'whatsapp1' => 'nullable|string|max:255',
            'whatsapp2' => 'nullable|string|max:255',
            'email1' => 'nullable|string|email|max:255',
            'email2' => 'nullable|string|email|max:255',
            'facebook' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'pinterest' => 'nullable|string|max:255',
            'map' => 'nullable|string|max:255',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
