<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'description',
        'country',
        'logo_path'
    ];

    public function creator(): HasMany
    {
        return $this->hasMany(Creator::class);
    }
}
