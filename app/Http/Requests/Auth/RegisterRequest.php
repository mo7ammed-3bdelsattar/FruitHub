<?php

namespace App\Http\Requests\Auth;

use App\Helpers\ApiResponse;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator){

        if($this->is('api/*')){
            $response = ApiResponse::sendResponse(422, "Validation Errors", $validator->errors());
            throw new ValidationException($validator, $response);
        }
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:14',
            'password' =>'required|min:6',
        ];
    }

    public function attributes(){
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' =>'Password',
        ];
    }
}
