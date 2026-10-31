<?php

namespace App\Http\Requests\Pages;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Параметри каталогу ігор. Некоректні значення тихо відкидаються
 * (сторінка завжди відкривається), тому правил валідації тут немає.
 */
class GamesIndexRequest extends FormRequest
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

    public function categoryId(): ?int
    {
        $category = $this->stringOrEmpty('category');

        return ctype_digit($category) && (int) $category > 0 ? (int) $category : null;
    }

    public function platform(): ?string
    {
        $platform = mb_substr(trim($this->stringOrEmpty('platform')), 0, 100);

        return $platform === '' ? null : $platform;
    }

    public function sort(): string
    {
        $sort = $this->stringOrEmpty('sort');

        return in_array($sort, Game::SORTS, true) ? $sort : 'new';
    }

    public function hasFilters(): bool
    {
        return $this->search() !== '' || $this->categoryId() !== null || $this->platform() !== null;
    }

    private function stringOrEmpty(string $key): string
    {
        $value = $this->query($key);

        return is_string($value) ? $value : '';
    }
}
