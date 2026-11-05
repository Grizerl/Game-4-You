<?php

namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Параметри списку новин. Некоректні значення тихо відкидаються
 * (сторінка завжди відкривається), тому правил валідації тут немає.
 */
class NewsIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    public function search(): string
    {
        return mb_substr(trim($this->stringOrEmpty('q')), 0, 100);
    }

    public function tag(): ?string
    {
        $tag = trim($this->stringOrEmpty('tag'));

        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $tag) === 1 && strlen($tag) <= 80 ? $tag : null;
    }

    public function hasFilters(): bool
    {
        return $this->search() !== '' || $this->tag() !== null;
    }

    private function stringOrEmpty(string $key): string
    {
        $value = $this->query($key);

        return is_string($value) ? $value : '';
    }
}
