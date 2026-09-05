<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $guarded = [];

    public function student() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function schoolClass() {
        return $this->belongsTo(SchoolClass::class);
    }
}
