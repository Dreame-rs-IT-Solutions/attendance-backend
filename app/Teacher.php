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
     * Model Relationship
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
