<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\Course;
use App\Models\Module;
use App\Models\Schedule;
use App\Models\Challenge;
use App\Models\UserProgress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $mentor = User::create([
            "name" => "Super Admin",
            "email" => "admin@asalink.edu",
            "password" => Hash::make("password"),
            "role" => "Super Admin",
            "batch" => "Mentor",
        ]);

        User::create(["name"=>"Budi Santoso", "email"=>"budi@sekolah.edu", "password"=>Hash::make("password"), "role"=>"Admin Sekolah", "created_at"=>now(), "updated_at"=>now()]);
        User::create(["name"=>"Siti Aminah", "email"=>"siti@sekolah.edu", "password"=>Hash::make("password"), "role"=>"Guru", "created_at"=>now(), "updated_at"=>now()]);
        $siswa = User::create(["name"=>"Andi Kurniawan", "email"=>"andi@sekolah.edu", "password"=>Hash::make("password"), "role"=>"Siswa", "created_at"=>now(), "updated_at"=>now()]);
        User::create(["name"=>"Bapak Joko", "email"=>"joko@gmail.com", "password"=>Hash::make("password"), "role"=>"Wali Murid", "student_id" => $siswa->id, "created_at"=>now(), "updated_at"=>now()]);

        School::insert([
            ["name"=>"SD Negeri 1 Jakarta", "npsn"=>"12345678", "level"=>"SD", "status"=>"Aktif"],
            ["name"=>"SMP Bintang Harapan", "npsn"=>"87654321", "level"=>"SMP", "status"=>"Aktif"],
            ["name"=>"SMK Teknologi Cerdas", "npsn"=>"11223344", "level"=>"SMK", "status"=>"Aktif"],
            ["name"=>"SMA Pelita Nusantara", "npsn"=>"99887766", "level"=>"SMA", "status"=>"Nonaktif"]
        ]);
    }
}
