<?php

namespace App\Http\Requests\Admin\Creator;

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            
            'bio.uk' => 'nullable|string|max:255',
            'bio.en' => 'nullable|string|max:255',
            
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp',
            'games_count' => 'required|integer',
            'company_id' => 'required|exists:companies,id',

            'role.uk' => 'required|string|max:255',
            'role.en' => 'required|string|max:255',
        ];
    }
}
