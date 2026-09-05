<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'role',
        'batch',
        'points',
        'school_class_id',
        'student_id',
        'phone',
        'status',
        'school_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function progress() { return $this->hasMany(UserProgress::class); }
    public function schedulesAsMentor() { return $this->hasMany(Schedule::class, 'mentor_id'); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class, 'school_class_id'); }
    public function school() { return $this->belongsTo(School::class); }
    
    // For Wali Murid linking to Siswa
    public function student() { return $this->belongsTo(User::class, 'student_id'); }
    
    public function attendances() { return $this->hasMany(Attendance::class, 'user_id'); }
    public function grades() { return $this->hasMany(Grade::class, 'user_id'); }
}
