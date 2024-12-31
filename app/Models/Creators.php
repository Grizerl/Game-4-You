<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creators extends Model
{
    protected $fillable = ['name', 'images', 'games-count', 'position', 'games'];
}
