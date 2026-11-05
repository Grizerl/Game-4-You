<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Прості налаштування сайту «ключ → JSON-значення» (наприклад, розміри зображень).
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = ['value' => 'array'];
}
