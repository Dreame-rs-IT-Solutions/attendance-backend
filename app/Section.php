<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * Fillable attributes
     */
    protected $fillable = [
        'teacher_id', 'name'
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'teacher_id',
        'created_at', 'updated_at'
    ];

    /**
     * Model Relationship
     */
    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
}
