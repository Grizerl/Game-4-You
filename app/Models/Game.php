<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $table = "games";

    protected $fillable = ['name', 'description', 'images', 'release_date', 'updated', 'cursing', 'platforms', 'developers', 'genres', 'publishers'];

    /**
     * Summary of category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Game>
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
