<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignmentSubmission;
use App\Models\Subject;

class StudentGradeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = AssignmentSubmission::where('student_id', $user->id)
                    ->whereNotNull('grade');

        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->whereHas('assignment', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        $grades = $query->latest('updated_at')->get();
        $subjects = Subject::all();

        return view('siswa.nilai.index', compact('grades', 'subjects'));
    }
}
