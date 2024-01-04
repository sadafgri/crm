<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAuthRequest extends FormRequest
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
            'name'=>'required',
            'role'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required_with:password_confirmation|same:password_confirmation',
            'password_confirmation'=>"",
        ];
    }

    public function failedValidation(validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors=$validator->errors();
        $redirect= redirect()->back()->withInput()->withErrors($errors);
        throw new HttpResponseException($redirect);
    }
}
