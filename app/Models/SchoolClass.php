<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SchoolClass extends Model {
    protected $fillable = ["name", "level", "teacher_id", "academic_year_id", "status"];
    public function teacher() { return $this->belongsTo(User::class, "teacher_id"); }
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
    public function students() { return $this->hasMany(User::class, "school_class_id"); }
    public function subjects() { return $this->hasMany(Subject::class); }
    public function learningSessions() { return $this->hasMany(LearningSession::class); }
    public function grades() { return $this->hasMany(Grade::class); }
}
