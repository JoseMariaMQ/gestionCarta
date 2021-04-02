<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllergenDish extends Model
{
    use HasFactory;

    /**
     * Specify table name
     *
     * @var string
     */
    protected $table = "allergen_dish";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['allergen_id', 'dish_id'];


}
