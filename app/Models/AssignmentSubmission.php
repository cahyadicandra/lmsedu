<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id', 'student_id', 'content', 'file_path', 'status', 'grade', 'feedback'
    ];

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }
    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
}
