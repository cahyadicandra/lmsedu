<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        
        if (!$student) {
            return view('walimurid.dashboard', ['student' => null]);
        }

        // Hitung Kehadiran
        $attendances = $student->attendances;
        $totalMeetings = $attendances->count();
        $hadir = $attendances->where('status', 'Hadir')->count();
        $izin = $attendances->whereIn('status', ['Izin', 'Sakit'])->count();
        $alpa = $attendances->where('status', 'Alpa')->count();
        $attendancePercentage = $totalMeetings > 0 ? round(($hadir / $totalMeetings) * 100) : 0;

        // Hitung Nilai Rata-rata
        $grades = $student->grades;
        $averageGrade = $grades->count() > 0 ? round($grades->avg('score'), 1) : 0;
        
        $recentGrades = $student->grades()->with(['subject.teacher'])->latest()->take(5)->get();
        
        // Ambil Pesan Terbaru (yang dikirim Wali Murid ini)
        $recentMessages = \App\Models\Message::where('sender_name', $user->name)
                            ->where('sender_role', 'Wali Murid')
                            ->with('teacher')
                            ->latest()
                            ->take(4)
                            ->get();

        return view('walimurid.dashboard', compact(
            'student', 
            'hadir', 'izin', 'alpa', 'attendancePercentage',
            'averageGrade', 'recentGrades', 'recentMessages'
        ));
    }
}
