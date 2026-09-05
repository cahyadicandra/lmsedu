<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    public function learningSession() {
        return $this->belongsTo(LearningSession::class);
    }
    public function student() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
