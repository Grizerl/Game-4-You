<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Спільні правила форм створення й редагування користувача.
 * Під час редагування пароль необов'язковий: порожній — не змінюється.
 */
class UserRequest extends FormRequest
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
        /** @var User|null $user */
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email:rfc', 'max:255',
                Rule::unique(User::class, 'email')->ignore($user?->getKey()),
            ],
            'password' => [
                $user ? 'nullable' : 'required',
                'string', 'confirmed', Password::min(8),
            ],
        ];
    }
}
