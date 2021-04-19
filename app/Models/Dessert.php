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
    public function dessertPicture() {
        return $this->hasOne(DessertPicture::class);
    }

    /**
     * Get picture as attribute of dessert
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getPictureAttribute() {
        return $this->dessertPicture()->first();
    }

    /**
     * Get section as attribute of dessert
     *
     * @return Section[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getSectionAttribute() {
        return Section::all()->find($this->section_id);
    }
}
