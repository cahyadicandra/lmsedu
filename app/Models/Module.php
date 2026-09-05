<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    public function course() { return $this->belongsTo(Course::class); }
    public function challenges() { return $this->hasMany(Challenge::class); }
}
