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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    /**
     * Model Relationship
     */
    public function student() {
        return $this->belongsTo(Student::class);
    }
}
