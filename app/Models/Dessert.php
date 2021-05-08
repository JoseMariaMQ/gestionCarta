<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dessert extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'price', 'units', 'extra', 'hidden', 'menu', 'price_menu', 'ingredients', 'section_id'];

    protected $with = ['picture', 'allergens'];

    /**
     * Get the section that owns the dessert
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sections() {
        return $this->belongsTo(Section::class);
    }

    /**
     * The allergens that belongs to the dessert
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allergens() {
        return $this->belongsToMany(Allergen::class, 'allergen_dessert', 'dessert_id', 'allergen_id');
    }

    /**
     * Get the picture associated with the dessert
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function picture() {
        return $this->hasOne(DessertPicture::class);
    }
}
