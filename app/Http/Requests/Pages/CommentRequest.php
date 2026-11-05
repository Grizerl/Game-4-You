<?php

namespace App\Http\Requests\Pages;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Після помилки валідації повертаємо до розділу коментарів.
     */
    protected function getRedirectUrl(): string
    {
        return strtok(url()->previous(), '#').'#comments';
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'content' => 'required|string|max:255',
            'game_id' => 'required|exists:games,id',
        ];
    }
}
