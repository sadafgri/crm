<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeOrderRequest extends FormRequest
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
            'explanations'=>'required|max:255',
            'order_name'=>'required|max:255',
        ];
    }
}
