<?php

namespace App\Http\Requests\Pages;

use App\Models\Creator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Параметри списку творців. Некоректні значення тихо відкидаються
 * (сторінка завжди відкривається), тому правил валідації тут немає.
 */
class CreatorIndexRequest extends FormRequest
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

    public function companyId(): ?int
    {
        $company = $this->stringOrEmpty('company');

        return ctype_digit($company) && (int) $company > 0 ? (int) $company : null;
    }

    public function role(): ?string
    {
        $role = mb_substr(trim($this->stringOrEmpty('role')), 0, 100);

        return $role === '' ? null : $role;
    }

    public function sort(): string
    {
        $sort = $this->stringOrEmpty('sort');

        return in_array($sort, Creator::SORTS, true) ? $sort : 'new';
    }

    public function hasFilters(): bool
    {
        return $this->search() !== '' || $this->companyId() !== null || $this->role() !== null;
    }

    private function stringOrEmpty(string $key): string
    {
        $value = $this->query($key);

        return is_string($value) ? $value : '';
    }
}
