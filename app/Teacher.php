<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /**
     * Fillable attributes
     */
    protected $fillable = [
        'user_id', 'name'
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'user_id',
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
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sections() {
        return $this->hasMany(Section::class);
    }
}
