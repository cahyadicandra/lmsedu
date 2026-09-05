<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'subject_id', 'teacher_id', 'school_class_id', 'title', 'description', 'file_path', 'published_at', 'status'
    ];

    protected $casts = [
        'published_at' => 'datetime',
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
}
