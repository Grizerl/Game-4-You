<?php

namespace App\Http\Requests\Admin\Game;

use App\Models\Game;
use App\Support\YouTube;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * Спільні правила форм створення й редагування гри.
 */
abstract class GameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Порожній slug означає «згенерувати / не змінювати», порожній трейлер — «без трейлера».
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => is_string($this->input('slug')) ? (trim($this->input('slug')) ?: null) : null,
            'trailer_url' => is_string($this->input('trailer_url')) ? (trim($this->input('trailer_url')) ?: null) : null,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $game = $this->route('game');

        return [
            'name.uk' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('games', 'slug')->ignore($game instanceof Game ? $game->id : null),
            ],

            'description.uk' => 'required|string',
            'description.en' => 'required|string',

            'rating' => 'required|numeric|min:0',
            'platforms' => 'required|string|max:255',
            'isNew' => 'required|boolean',
            'released_at' => 'nullable|date',

            'trailer_url' => [
                'nullable',
                'string',
                'max:255',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if (YouTube::id(is_string($value) ? $value : null) === null) {
                        $fail('The trailer must be a valid YouTube link.');
                    }
                },
            ],

            'cover_image' => $this->coverRules(),

            'screenshots' => 'nullable|array|max:'.Game::MAX_SCREENSHOTS,
            'screenshots.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_screenshots' => 'nullable|array',
            'remove_screenshots.*' => 'string',

            'category_id' => 'required|exists:categories,id',
            'creator_id' => 'required|exists:creators,id',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    /**
     * Загальна кількість скріншотів (наявні мінус видалені плюс нові) не перевищує ліміт.
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $game = $this->route('game');
                $existing = $game instanceof Game ? ($game->screenshots ?? []) : [];
                $remaining = count(array_diff($existing, (array) $this->input('remove_screenshots', [])));
                $added = count((array) $this->file('screenshots', []));

                if ($remaining + $added > Game::MAX_SCREENSHOTS) {
                    $validator->errors()->add('screenshots', 'No more than '.Game::MAX_SCREENSHOTS.' screenshots are allowed.');
                }
            },
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
