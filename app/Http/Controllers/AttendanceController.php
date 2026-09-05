<?php

namespace App\Http\Controllers;

use App\Models\LearningSession;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Jika ada parameter session_id, tampilkan form isi absensi untuk sesi tersebut
        if ($request->has('session_id')) {
            $session = LearningSession::with(['subject', 'schoolClass.students'])->findOrFail($request->session_id);
            
            if ($session->subject->teacher_id !== Auth::id()) {
                abort(403);
            }

            // Ambil absensi yang sudah ada
            $attendances = Attendance::where('learning_session_id', $session->id)
                                     ->get()->keyBy('user_id');

            return view('guru.absensi.isi', compact('session', 'attendances'));
        }

        // Tampilkan daftar pertemuan untuk absensi
        $query = LearningSession::whereIn('subject_id', function($q) {
            $q->select('id')->from('subjects')->where('teacher_id', Auth::id());
        });

        if ($request->subject_id) $query->where('subject_id', $request->subject_id);
        if ($request->school_class_id) $query->where('school_class_id', $request->school_class_id);
        if ($request->date) $query->whereDate('date', $request->date);

        $sessions = $query->with(['subject', 'schoolClass', 'attendances'])->orderBy('date', 'desc')->paginate(10);
        
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        $classes = SchoolClass::whereIn('id', $subjects->pluck('school_class_id'))->distinct()->get();

        return view('guru.absensi.index', compact('sessions', 'subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:learning_sessions,id',
            'attendance' => 'required|array', // user_id => status
        ]);

        $session = LearningSession::findOrFail($request->session_id);
        
        if ($session->subject->teacher_id !== Auth::id()) {
            abort(403);
        }

        foreach ($request->attendance as $userId => $status) {
            Attendance::updateOrCreate(
                ['learning_session_id' => $session->id, 'user_id' => $userId],
                ['status' => $status]
            );
        }

        return redirect()->route('pertemuan.show', $session->id)->with('success', 'Absensi berhasil disimpan.');
    }
}
