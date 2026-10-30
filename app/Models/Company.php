<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Company extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'country',
        'logo_path',
    ];

    public $translatable = ['name', 'description', 'country'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'country' => 'array',
    ];

    public function creator(): HasMany
    {
        return $this->hasMany(Creator::class);
    }
}
