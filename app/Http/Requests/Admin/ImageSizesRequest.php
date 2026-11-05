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
            'cover_thumb_desktop' => 'мініатюра обкладинки (десктоп)',
            'cover_thumb_mobile' => 'мініатюра обкладинки (мобільний)',
            'cover_large_desktop' => 'великий банер (десктоп)',
            'cover_large_mobile' => 'великий банер (мобільний)',
            'avatar_thumb' => 'аватар творця',
            'logo_thumb' => 'логотип компанії',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'Вкажіть значення: :attribute.',
            'integer' => 'Поле «:attribute» має бути цілим числом.',
            'min' => 'Поле «:attribute» не може бути меншим за :min px.',
            'max' => 'Поле «:attribute» не може бути більшим за :max px.',
            'lte' => 'Мобільна ширина («:attribute») не може бути більшою за десктопну (:value px).',
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
