<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageSizes;
use Illuminate\Foundation\Http\FormRequest;

class ImageSizesRequest extends FormRequest
{
    /** Поля форми → ключі `ImageSizes` (крапка в назві поля ламала б вкладеність). */
    public const FIELDS = [
        'cover_thumb_desktop' => 'cover.thumb.desktop',
        'cover_thumb_mobile' => 'cover.thumb.mobile',
        'cover_large_desktop' => 'cover.large.desktop',
        'cover_large_mobile' => 'cover.large.mobile',
        'avatar_thumb' => 'avatar.thumb',
        'logo_thumb' => 'logo.thumb',
    ];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $range = ['required', 'integer', 'min:'.ImageSizes::MIN, 'max:'.ImageSizes::MAX];

        return [
            'cover_thumb_desktop' => $range,
            'cover_thumb_mobile' => [...$range, 'lte:cover_thumb_desktop'],
            'cover_large_desktop' => $range,
            'cover_large_mobile' => [...$range, 'lte:cover_large_desktop'],
            'avatar_thumb' => $range,
            'logo_thumb' => $range,
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'cover_thumb_desktop' => 'cover thumbnail (desktop)',
            'cover_thumb_mobile' => 'cover thumbnail (mobile)',
            'cover_large_desktop' => 'large banner (desktop)',
            'cover_large_mobile' => 'large banner (mobile)',
            'avatar_thumb' => 'creator avatar',
            'logo_thumb' => 'company logo',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'Please enter a value for :attribute.',
            'integer' => 'The :attribute must be a whole number.',
            'min' => 'The :attribute cannot be smaller than :min px.',
            'max' => 'The :attribute cannot be larger than :max px.',
            'lte' => 'The :attribute cannot be wider than the desktop width (:value px).',
        ];
    }

    /**
     * Розміри у форматі ключів `ImageSizes`.
     *
     * @return array<string, int>
     */
    public function sizes(): array
    {
        $validated = $this->validated();

        return collect(self::FIELDS)->mapWithKeys(fn (string $key, string $field): array => [$key => (int) $validated[$field]])->all();
    }
}
