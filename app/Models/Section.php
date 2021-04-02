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
    protected $fillable = ['name', 'picture', 'order', 'hidden'];

    /**
     * Get the dishes for the section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dishes() {
        return $this->hasMany(Dish::class);
    }
}
