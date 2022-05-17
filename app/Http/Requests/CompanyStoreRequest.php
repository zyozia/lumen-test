<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
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
            'user_id' => __('User'),
            'title' => __('Title'),
            'phone' => __('Phone'),
            'description' => __('Description'),
        ];
    }
}
