<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllergenDessert extends Model
{
    use HasFactory;

    /**
     * Specify table name
     *
     * @var string
     */
    protected $table = "allergen_dessert";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['allergen_id', 'dessert_id'];
}
