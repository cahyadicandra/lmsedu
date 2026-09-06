<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningSession extends Model
{
    protected $guarded = [];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function schoolClass() {
        return $this->belongsTo(SchoolClass::class);
    }
    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
    public function materials() {
        return $this->hasMany(Material::class);
    }
}
