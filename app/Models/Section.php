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
     * Get dishes, desserts, drinks and picture of section
     *
     * @var string[]
     */
    protected $with = ['dishes', 'desserts', 'drinks', 'picture'];

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
    public function picture() {
        return $this->hasOne(SectionPicture::class);
    }
}
