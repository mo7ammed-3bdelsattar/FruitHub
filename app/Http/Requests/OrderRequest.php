<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'subtotal_price' => 'required|numeric',
            'status' => 'nullable|string|in:pending,processing,completed,cancelled',
            'payment_method' => 'nullable|in:cash,online',
            'payment_status' => 'nullable|in:paid,pending,failed',

        ];
    }
}
