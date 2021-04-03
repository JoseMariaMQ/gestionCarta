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
    protected $fillable = ['name', 'price', 'hidden', 'picture', 'section_id'];

    /**
     * Get the section that owns the drink
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sections() {
        return $this->belongsTo(Section::class);
    }
}
