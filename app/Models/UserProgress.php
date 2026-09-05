<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    //
    public function user() { return $this->belongsTo(User::class); }
    public function module() { return $this->belongsTo(Module::class); }
}
