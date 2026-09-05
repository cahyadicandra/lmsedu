<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        // Jika ada subject_id dan school_class_id, tampilkan form input nilai
        if ($request->subject_id && $request->school_class_id) {
            $subject = Subject::findOrFail($request->subject_id);
            $schoolClass = SchoolClass::with('students')->findOrFail($request->school_class_id);
            
            if ($subject->teacher_id !== Auth::id()) {
                abort(403);
            }

            // Get existing grades
            $grades = Grade::where('subject_id', $subject->id)
                           ->whereIn('user_id', $schoolClass->students->pluck('id'))
                           ->get()->groupBy('user_id');

            // Optional: get list of unique grade types (Tugas 1, UTS, UAS, dll)
            $existingTypes = Grade::where('subject_id', $subject->id)
                                  ->select('type')->distinct()->pluck('type')->toArray();

            return view('guru.nilai.isi', compact('subject', 'schoolClass', 'grades', 'existingTypes'));
        }

        // Tampilkan daftar kelas dan mapel yang diajar
        $subjects = Subject::where('teacher_id', Auth::id())->with('schoolClass')->get();

        return view('guru.nilai.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'type' => 'required|string',
            'grades' => 'required|array', // user_id => score
        ]);

        $subject = Subject::findOrFail($request->subject_id);
        
        if ($subject->teacher_id !== Auth::id()) {
            abort(403);
        }

        foreach ($request->grades as $userId => $score) {
            if ($score !== null && $score !== '') {
                Grade::updateOrCreate(
                    [
                        'subject_id' => $subject->id,
                        'user_id' => $userId,
                        'type' => $request->type
                    ],
                    [
                        'score' => $score,
                        'notes' => $request->description ?? null,
                        'school_class_id' => $request->school_class_id,
                        'date' => now()->toDateString(),
                    ]
                );
            }
        }

        return redirect()->route('nilai.index', [
            'subject_id' => $request->subject_id, 
            'school_class_id' => $request->school_class_id
        ])->with('success', 'Nilai berhasil disimpan.');
    }

    public function destroyType(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|string',
        ]);

        $subject = Subject::findOrFail($request->subject_id);
        
        if ($subject->teacher_id !== Auth::id()) {
            abort(403);
        }

        Grade::where('subject_id', $subject->id)->where('type', $request->type)->delete();

        return redirect()->back()->with('success', 'Kolom nilai berhasil dihapus.');
    }
}
