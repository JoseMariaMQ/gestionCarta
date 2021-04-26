<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'order', 'hidden'];

    /**
     * Get the dishes for the section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dishes() {
        return $this->hasMany(Dish::class);
    }

    /**
     * Get the desserts for the section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desserts() {
        return $this->hasMany(Dessert::class);
    }

    /**
     * Get the drinks for the section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drinks() {
        return $this->hasMany(Drink::class);
    }

    /**
     * Get the picture associated with the section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sectionPicture() {
        return $this->hasOne(SectionPicture::class);
    }

    /**
     * Get picture as attribute of section
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getPictureAttribute()
    {
        return $this->sectionPicture()->first();
    }

    /**
     * Get dishes as attribute of section
     *
     * @return mixed
     */
    public function getDishesAttribute() {
        return Dish::where('section_id', $this->id)->with('allergens')->get()->append('picture');
    }

    /**
     * Get desserts as attribute of section
     *
     * @return mixed
     */
    public function getDessertsAttribute() {
        return Dessert::where('section_id', $this->id)->with('allergens')->get()->append('picture');
    }

    /**
     * Get drinks as attribute of section
     *
     * @return mixed
     */
    public function getDrinksAttribute() {
        return Drink::where('section_id', $this->id)->get()->append('picture');
    }
}
