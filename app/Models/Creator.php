<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    use HasFactory;
    protected $table = "creators";
    protected $fillable = ['name', 'images', 'games-count', 'position', 'games'];
}
