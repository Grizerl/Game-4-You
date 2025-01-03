<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
    public function games()
    {
        return $this->hasMany(Games::class);
    }

    protected $fillable = ['title'];
}

