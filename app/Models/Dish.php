<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'price', 'units', 'extra', 'hidden', 'menu', 'price_menu', 'ingredients', 'section_id', 'picture_id'];

    /**
     * Get the section that owns the dish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sections() {
        return $this->belongsTo(Section::class);
    }

    /**
     * The allergens that belongs to the dish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allergens() {
        return $this->belongsToMany(Allergen::class);
    }

    /**
     * Get the picture associated with the dish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function picture() {
        return $this->hasOne(Picture::class);
    }
}
