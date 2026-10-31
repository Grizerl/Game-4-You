<?php

namespace App\Http\Requests\Admin\Company;

use App\Models\Company;
use App\Support\SocialLinks;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Спільні правила форм створення й редагування студії.
 */
abstract class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Порожні соціальні посилання не зберігаємо; порожній slug означає «згенерувати / не змінювати».
     */
    protected function prepareForValidation(): void
    {
        $socials = $this->input('socials');

        if (is_array($socials)) {
            $socials = array_filter(
                array_map(fn (mixed $url): mixed => is_string($url) ? trim($url) : $url, $socials),
                fn (mixed $url): bool => $url !== null && $url !== ''
            );
        }

        $this->merge([
            'socials' => $socials ?: null,
            'slug' => is_string($this->input('slug')) ? (trim($this->input('slug')) ?: null) : null,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'name.uk' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('companies', 'slug')->ignore($company instanceof Company ? $company->id : null),
            ],

            'description.uk' => 'nullable|string|max:5000',
            'description.en' => 'nullable|string|max:5000',

            'country.uk' => 'required|string|max:255',
            'country.en' => 'required|string|max:255',

            'founded_year' => 'nullable|integer|between:1970,'.now()->year,

            'socials' => 'nullable|array:'.implode(',', SocialLinks::KEYS),
            'socials.*' => 'nullable|url:http,https|max:255',

            'logo_path' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ];
    }
}
