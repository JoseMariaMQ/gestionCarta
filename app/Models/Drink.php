<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'price', 'hidden', 'section_id'];

    /**
     * Get the section that owns the drink
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sections() {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the picture associated with the drink
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drinkPicture() {
        return $this->hasOne(drinkPicture::class);
    }

    /**
     * Get picture as attribute of drink
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getPictureAttribute() {
        return $this->drinkPicture()->first();
    }

    /**
     * Get section as attribute of drink
     *
     * @return Section[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getSectionAttribute() {
        return Section::all()->find($this->section_id);
    }
}
