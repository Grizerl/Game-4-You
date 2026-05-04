<?php

namespace App\Http\Requests\Admin\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name.uk' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',

            'description.uk' => 'nullable|string',
            'description.en' => 'nullable|string',
            
            'country.uk' => 'required|string|max:255',
            'country.en' => 'required|string|max:255',

            'logo_path' => 'required|image|mimes:jpg,png,jpeg,webp'
        ];
    }
}
