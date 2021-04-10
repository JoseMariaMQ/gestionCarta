<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionPicture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['section_id', 'url'];

    /**
     * Get the section that owns the picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section() {
        return $this->belongsTo(Section::class);
    }
}
