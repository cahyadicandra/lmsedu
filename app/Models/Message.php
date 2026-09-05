<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'teacher_id',
        'sender_name',
        'sender_role',
        'content',
        'reply',
        'color',
        'is_read',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
