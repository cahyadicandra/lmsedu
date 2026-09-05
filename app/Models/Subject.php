<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Subject extends Model {
    protected $fillable = ["name", "code", "teacher_id", "school_class_id", "academic_year_id", "status"];
    public function teacher() { return $this->belongsTo(User::class, "teacher_id"); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class, "school_class_id"); }
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
    public function learningSessions() { return $this->hasMany(LearningSession::class); }
    public function grades() { return $this->hasMany(Grade::class); }
}
