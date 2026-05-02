<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Game extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name', 
        'description', 
        'cover_image', 
        'rating', 
        'platforms',
        'isNew',
        'category_id',
        'creator_id',
        'company_id',
    ];

    protected $casts = [
        'isNew' => 'boolean',
    ];

    public $translatable = ['name', 'description'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class, 'creator_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'game_id');
    }
}
