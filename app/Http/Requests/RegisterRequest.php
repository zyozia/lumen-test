<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'first_name' => __('First name'),
            'last_name' => __('Last name'),
            'phone' => __('Phone number'),
            'email' => __('Email'),
            'password' => __('Password'),
        ];
    }
}
