<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $appends = [
        'absences_count', 'attendances_count'
    ];

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
     * Model mutators and accessors
     */
    public function getAbsencesCountAttribute($value) {
        return $this->attendances()->where('STATUS', 'ABSENT')->count();
    }

    public function getAttendancesCountAttribute($value) {
        return $this->attendances()->where('STATUS', 'PRESENT')->count();
    }

    /**
     * Model Relationship
     */
    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
}
