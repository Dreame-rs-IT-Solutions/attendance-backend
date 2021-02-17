<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Fillable attributes
     */
    protected $fillable = [
        'section_id', 'name'
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'section_id',
        'created_at', 'updated_at'
    ];

    /**
     * Model Relationship
     */
    public function section() {
        return $this->belongsTo(Section::class);
    }
}
