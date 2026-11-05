<?php

namespace App\Http\Requests\Admin\Article;

use App\Models\Article;
use App\Models\Tag;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Спільні правила форм створення й редагування новини.
 */
abstract class ArticleRequest extends FormRequest
{
    private const MAX_TAG_LENGTH = 60;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Порожній slug означає «згенерувати / не змінювати».
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => is_string($this->input('slug')) ? (trim($this->input('slug')) ?: null) : null,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $article = $this->route('article');

        return [
            'title.uk' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::notIn(Article::RESERVED_SLUGS),
                Rule::unique('articles', 'slug')->ignore($article instanceof Article ? $article->id : null),
            ],

            'excerpt.uk' => 'required|string|max:300',
            'excerpt.en' => 'required|string|max:300',

            'body.uk' => 'required|string|max:100000',
            'body.en' => 'required|string|max:100000',

            'cover_image' => $this->coverRules(),
            'published_at' => 'nullable|date',

            'tags' => [
                'nullable',
                'string',
                'max:1000',
                function (string $attribute, mixed $value, Closure $fail): void {
                    foreach (Tag::parseInput(is_string($value) ? $value : null) as $names) {
                        if (mb_strlen($names['uk']) > self::MAX_TAG_LENGTH || mb_strlen($names['en']) > self::MAX_TAG_LENGTH) {
                            $fail('Each tag must be at most '.self::MAX_TAG_LENGTH.' characters.');

                            return;
                        }
                    }
                },
            ],

            'games' => 'nullable|array',
            'games.*' => 'integer|exists:games,id',
            'companies' => 'nullable|array',
            'companies.*' => 'integer|exists:companies,id',
        ];
    }

    /**
     * @return array<int, string>
     */
    protected function coverRules(): array
    {
        return ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];
    }
}
