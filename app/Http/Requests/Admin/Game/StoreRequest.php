<?php

namespace App\Http\Requests\Admin\Game;

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

            'description.uk' => 'required|string',
            'description.en' => 'required|string',
            
            'rating' => 'required|numeric|min:0',
            'platforms' => 'required|string|max:255',
            'isNew' => 'required|boolean',

            'cover_image' => 'required|image|mimes:jpg,jpeg,png,webp',

            'category_id' => 'required|exists:categories,id',
            'creator_id'  => 'required|exists:creators,id',
            'company_id'  => 'required|exists:companies,id',
        ];
    }
}
