<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $fillable = ['name', 'description', 'images', 'release_date', 'updated', 'cursing', 'platforms', 'developers', 'genres', 'publishers'];
    
}
