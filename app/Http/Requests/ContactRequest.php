<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_numbers' => 'array',
            'phone_numbers.*' => 'regex:/^01[0-9]{9}$/',
            'phone_operators' => 'array',
            'phone_operators.*' => 'string',
        ];
    }
    public function messages()
    {
        return [
            
            'name.required' => 'Name is required!',
            'address.required' => 'Address is required!',
            'phone_numbers.*.regex' => 'Valid phone number is required!',
            'phone_operators.*.string' => 'Please select operator!',
          
        ];
    }
}
