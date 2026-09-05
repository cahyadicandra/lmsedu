<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        
        if ($role === "Super Admin") {
            $totalSchools = \App\Models\School::count();
            
            // Get user counts by role (excluding Super Admin if needed, but we can just group by role)
            $userCounts = User::whereIn('role', ['Siswa', 'Guru', 'Admin Sekolah', 'Wali Murid'])
                ->selectRaw('role, count(*) as total')
                ->groupBy('role')
                ->pluck('total', 'role')->toArray();
                
            $totalSiswa = $userCounts['Siswa'] ?? 0;
            $totalGuru = $userCounts['Guru'] ?? 0;
            $totalAdmin = $userCounts['Admin Sekolah'] ?? 0;
            $totalWali = $userCounts['Wali Murid'] ?? 0;
            $totalUsers = User::count(); // Or sum of the three above, let's use all users

            $counts = User::where('role', 'Siswa')
                ->join('schools', 'users.school_id', '=', 'schools.id')
                ->selectRaw('schools.level, count(*) as total')
                ->groupBy('schools.level')
                ->pluck('total', 'level')->toArray();
            
            $studentDistribution = [
                'SD' => $counts['SD'] ?? 0,
                'MI' => $counts['MI'] ?? 0,
                'SMP' => $counts['SMP'] ?? 0,
                'MTS' => $counts['MTS'] ?? 0,
                'SMA' => $counts['SMA'] ?? 0,
                'MA' => $counts['MA'] ?? 0,
                'SMK' => $counts['SMK'] ?? 0,
            ];

            return view("dashboard-peserta", compact('studentDistribution', 'totalSchools', 'totalSiswa', 'totalGuru', 'totalAdmin', 'totalWali', 'totalUsers'));
        } elseif ($role === "Admin Sekolah") {
            $totalSiswa = User::where("role", "Siswa")->count();
            $totalGuru = User::where("role", "Guru")->count();
            $totalKelas = SchoolClass::count();
            $totalMatpel = Subject::count();
            
            return view("dashboard.admin-sekolah", compact("totalSiswa", "totalGuru", "totalKelas", "totalMatpel"));
        } elseif ($role === "Guru") {
            $totalKelas = SchoolClass::where("teacher_id", Auth::id())->count();
            $totalMatpel = Subject::where("teacher_id", Auth::id())->count();
            $pertemuanHariIni = \App\Models\LearningSession::whereIn('subject_id', function($q) {
                $q->select('id')->from('subjects')->where('teacher_id', Auth::id());
            })->whereDate('date', today())->count();
            
            return view("dashboard.guru", compact("totalKelas", "totalMatpel", "pertemuanHariIni"));
        } elseif ($role === "Siswa") {
            $user = Auth::user();
            
            $totalMatpel = Subject::count();
            $totalKelas = SchoolClass::count();
            $tugasBelum = \App\Models\AssignmentSubmission::where('student_id', $user->id)
                            ->whereIn('status', ['Belum Dikerjakan', 'Sedang Dikerjakan'])
                            ->count();
            $nilaiTerbaru = \App\Models\AssignmentSubmission::where('student_id', $user->id)
                            ->whereNotNull('grade')
                            ->orderBy('updated_at', 'desc')
                            ->first();
            return view("dashboard.siswa", compact('totalMatpel', 'totalKelas', 'tugasBelum', 'nilaiTerbaru'));
        } elseif ($role === "Wali Murid") {
            return redirect()->route('walimurid.dashboard');
        }

        // Fallback for other roles
        return view("dashboard-peserta");
    }
}
