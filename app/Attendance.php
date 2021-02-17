<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /**
     * Fillable attributes
     */
    protected $fillable = [
        'student_id', 'date', 'status'
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'student_id',
        'created_at', 'updated_at'
    ];

    /**
     * Model Relationship
     */
    public function student() {
        return $this->belongsTo(Student::class);
    }
}
