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

    protected $with = ['picture'];

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
    public function picture() {
        return $this->hasOne(drinkPicture::class);
    }
}
