<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    //
    public function module() { return $this->belongsTo(Module::class); }
}
