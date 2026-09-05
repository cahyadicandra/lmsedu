<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    public function modules() { return $this->hasMany(Module::class); }
    public function schedules() { return $this->hasMany(Schedule::class); }
}
