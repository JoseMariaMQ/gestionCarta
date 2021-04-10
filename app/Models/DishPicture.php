<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishPicture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['dish_id', 'url'];

    /**
     * Get the dish that owns the picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dish() {
        return $this->belongsTo(Dish::class);
    }
}
