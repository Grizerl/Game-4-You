<?php

namespace App\Http\Requests\Admin\Creator;

use App\Models\Creator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Спільні правила форм створення й редагування творця.
 */
abstract class CreatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $creator = $this->route('creator');

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('creators', 'slug')->ignore($creator instanceof Creator ? $creator->id : null),
            ],

            'bio.uk' => 'nullable|string|max:5000',
            'bio.en' => 'nullable|string|max:5000',

            'country.uk' => 'nullable|string|max:100',
            'country.en' => 'nullable|string|max:100',

            'career_start' => 'nullable|integer|between:1950,'.now()->year,

            'socials' => 'nullable|array:'.implode(',', Creator::SOCIAL_KEYS),
            'socials.*' => 'nullable|url:http,https|max:255',

            'avatar' => $this->avatarRules(),
            'company_id' => 'required|exists:companies,id',

            'role.uk' => 'required|string|max:255',
            'role.en' => 'required|string|max:255',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected function avatarRules(): array
    {
        return ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
    }
}
