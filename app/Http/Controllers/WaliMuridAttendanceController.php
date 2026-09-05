<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return view('walimurid.kehadiran.index', ['student' => null, 'attendances' => collect()]);
        }

        $query = $student->attendances()->with(['learningSession.subject.teacher']);

        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->whereHas('learningSession', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('created_at', 'desc')->get();
        
        $subjects = \App\Models\Subject::where('school_class_id', $student->school_class_id)->get();

        // Summary
        $totalMeetings = $student->attendances()->count();
        $hadir = $student->attendances()->where('status', 'Hadir')->count();
        $izin = $student->attendances()->where('status', 'Izin')->count();
        $sakit = $student->attendances()->where('status', 'Sakit')->count();
        $alpa = $student->attendances()->where('status', 'Alpa')->count();
        $attendancePercentage = $totalMeetings > 0 ? round(($hadir / $totalMeetings) * 100) : 0;

        return view('walimurid.kehadiran.index', compact(
            'student', 'attendances', 'subjects',
            'totalMeetings', 'hadir', 'izin', 'sakit', 'alpa', 'attendancePercentage'
        ));
    }
}
