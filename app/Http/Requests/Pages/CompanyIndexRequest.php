<?php

namespace App\Http\Requests\Pages;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Параметри списку студій. Некоректні значення тихо відкидаються
 * (сторінка завжди відкривається), тому правил валідації тут немає.
 */
class CompanyIndexRequest extends FormRequest
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

    public function country(): ?string
    {
        $country = mb_substr(trim($this->stringOrEmpty('country')), 0, 100);

        return $country === '' ? null : $country;
    }

    public function sort(): string
    {
        $sort = $this->stringOrEmpty('sort');

        return in_array($sort, Company::SORTS, true) ? $sort : 'new';
    }

    public function hasFilters(): bool
    {
        return $this->search() !== '' || $this->country() !== null;
    }

    private function stringOrEmpty(string $key): string
    {
        $value = $this->query($key);

        return is_string($value) ? $value : '';
    }
}
