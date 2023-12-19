<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUserRequest extends FormRequest
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
            'email'=> 'required:email',
            'first_name'=> 'required:255',
            'last_name'=> 'required:255',
            'user_name'=> 'required:255:users,user_name',
            'phone_number'=> 'required:15:users,phone_number',
            'age'=> 'required:integer:18',
            'country' => 'required:255',
            'province'=> 'required:255',
            'city'=> 'required:255',
            'gender'=> 'required:male,female,other',
            'postal_code'=> 'required:8',
            'address'=> 'required:255',
            'password'=> 'required_with:password|same:password',
            'password_confirmation' => 'min6',
        ];
    }
}
