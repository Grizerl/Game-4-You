<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = [
        'title'
    ];

    public $translatable = ['title'];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'category_id');
    }
}
