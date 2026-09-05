<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'subject_id', 'teacher_id', 'school_class_id', 'title', 'description', 'file_path', 'youtube_link', 'due_date', 'status'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function schoolClass() {
        return $this->belongsTo(SchoolClass::class);
    }
    public function submissions() {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
