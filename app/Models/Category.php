<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = ["title"];

    /**
     * Summary of games
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Game, Category>
     */
    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class, 'category_id');
    }

}
