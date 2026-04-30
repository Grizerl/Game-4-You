<?php

namespace App\Http\Requests\Admin\Creator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            
            'bio.uk' => 'nullable|string|max:255',
            'bio.en' => 'nullable|string|max:255',
            
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'games_count' => 'required|integer',
            'role' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
