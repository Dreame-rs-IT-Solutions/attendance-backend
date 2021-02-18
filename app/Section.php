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
        'teacher_id', 'updated_at'
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
    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function students() {
        return $this->hasMany(Student::class);
    }
}
