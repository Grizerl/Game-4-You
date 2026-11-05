<?php

namespace App\Http\Requests\Admin\Game;

class StoreRequest extends GameRequest
{
    /**
     * @return array<int, string>
     */
    protected function coverRules(): array
    {
        return ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];
    }
}
