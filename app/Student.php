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
        'section_id', 'updated_at'
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
     * Model mutators and accessors
     */
    public function getAbsencesCountAttribute($value) {
        return $this->attendances()->where('status', 'ABSENT')->count();
    }

    public function getAttendancesCountAttribute($value) {
        return $this->attendances()->where('status', 'PRESENT')->count();
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
