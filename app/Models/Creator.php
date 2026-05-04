<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Creator extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = [
        'first_name', 
        'last_name',
        'avatar', 
        'bio', 
        'games_count',
        'role',
        'company_id'
    ];

    public $translatable = ['bio', 'role'];

    protected $casts = [
        'bio' => 'array',
        'role' => 'array',
    ];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'creator_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
