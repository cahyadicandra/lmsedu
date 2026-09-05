<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\Subject;

class StudentClassController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // The student's class
        $myClass = SchoolClass::find($user->school_class_id);
        
        // Subjects taught in this class
        // (For MVP, we assume all subjects might be taught to this class, or we just show a few)
        $subjects = Subject::all(); // Simplified, in a real app this would be filtered by curriculum/class

        return view('siswa.kelas.index', compact('myClass', 'subjects'));
    }

    public function show($id)
    {
        // $id refers to Subject ID within the context of 'Kelas Saya'
        $subject = Subject::findOrFail($id);
        $user = Auth::user();
        
        $materials = \App\Models\Material::where('school_class_id', $user->school_class_id)
                        ->where('subject_id', $subject->id)
                        ->get();
                        
        $assignments = \App\Models\Assignment::where('school_class_id', $user->school_class_id)
                        ->where('subject_id', $subject->id)
                        ->get();
                        
        $sessions = \App\Models\LearningSession::where('school_class_id', $user->school_class_id)
                        ->where('subject_id', $subject->id)
                        ->get();

        return view('siswa.kelas.show', compact('subject', 'materials', 'assignments', 'sessions'));
    }
}
