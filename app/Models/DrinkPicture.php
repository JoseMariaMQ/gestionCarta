<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkPicture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['drink_id', 'url'];

    /**
     * Get the drink that owns the picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drink() {
        return $this->belongsTo(Drink::class);
    }
}
