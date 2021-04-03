<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['url'];

    /**
     * Get the section that owns the picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section() {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the dish that owns the picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dish() {
        return $this->belongsTo(Dish::class);
    }

    /**
     * Get the drink that owns the picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drink() {
        return $this->belongsTo(Drink::class);
    }
}
