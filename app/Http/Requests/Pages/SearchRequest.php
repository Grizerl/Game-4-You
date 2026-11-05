<?php

namespace App\Http\Requests\Pages;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Запит підказок пошуку: обов'язковий непорожній рядок (від 2 символів після нормалізації).
 * Відповідь на помилку валідації завжди JSON 422 — ендпоінт використовується лише з JS.
 */
class SearchRequest extends FormRequest
{
    public const MIN_LENGTH = 2;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'q' => ['required', 'string', 'min:'.self::MIN_LENGTH],
        ];
    }

    protected function prepareForValidation(): void
    {
        $query = $this->query('q');
        $query = is_string($query) ? $query : '';

        $this->merge([
            'q' => mb_substr(trim((string) preg_replace('/\s+/u', ' ', $query)), 0, (int) config('search.max_query_length')),
        ]);
    }

    public function search(): string
    {
        return (string) $this->validated('q');
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first('q'),
            'errors' => $validator->errors()->toArray(),
        ], 422));
    }
}
