<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AcademicYear extends Model {
    protected $fillable = ["name", "semester", "start_date", "end_date", "status"];
    public function classes() { return $this->hasMany(SchoolClass::class); }
}
