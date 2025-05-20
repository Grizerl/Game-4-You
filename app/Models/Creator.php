<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    protected $table = "creators";
    protected $fillable = ['name', 'images', 'games-count', 'position', 'games'];
}
