<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    public function course() { return $this->belongsTo(Course::class); }
    public function mentor() { return $this->belongsTo(User::class, 'mentor_id'); }
}
