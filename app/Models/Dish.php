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
    protected $fillable = ['name', 'price', 'units', 'extra', 'hidden', 'menu', 'price_menu', 'ingredients', 'section_id'];

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
        return $this->belongsToMany(Allergen::class, 'allergen_dish', 'dish_id', 'allergen_id');
    }

    /**
     * Get the picture associated with the dish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dishPicture() {
        return $this->hasOne(DishPicture::class);
    }

    /**
     * Get picture as attribute of dish
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getPictureAttribute() {
        return $this->dishPicture()->first();
    }

    /**
     * Get section as attribute of dish
     *
     * @return Section[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getSectionAttribute() {
        return Section::all()->find($this->section_id);
    }
}
