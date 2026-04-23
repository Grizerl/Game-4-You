<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Creator extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name', 
        'last_name',
        'avatar', 
        'bio', 
        'games_count',
        'role'
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
