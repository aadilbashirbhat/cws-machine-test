<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:applicants',
            'address' => 'required|string|max:255',
            'dob' => 'required|date|before_or_equal:today|date_format:Y-m-d',
            'gender' => 'required|in:male,female',
            'resume' => 'required|mimes:pdf,docx|max:2048',
            'photo' => 'required|image|mimes:jpg,png|max:2048',
        ];
    }
}
