<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DessertPicture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['dessert_id', 'url'];

    /**
     * Get the dessert that owns the picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dessert() {
        return $this->belongsTo(Dessert::class);
    }
}
