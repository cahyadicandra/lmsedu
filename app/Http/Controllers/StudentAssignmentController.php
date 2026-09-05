<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Subject;

class StudentAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Assignment::where('school_class_id', $user->school_class_id)->where('status', 'Published');

        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }

        $assignments = $query->with(['subject'])->latest('due_date')->get();
        $subjects = Subject::all();

        return view('siswa.tugas.index', compact('assignments', 'subjects'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $assignment = Assignment::where('school_class_id', $user->school_class_id)->findOrFail($id);
        $submission = AssignmentSubmission::where('assignment_id', $id)->where('student_id', $user->id)->first();

        return view('siswa.tugas.show', compact('assignment', 'submission'));
    }

    public function submit(Request $request, $id)
    {
        $request->validate([
            'content' => 'required_without:file|nullable|string',
            'file' => 'required_without:content|nullable|file|max:10240'
        ]);

        $user = Auth::user();
        $assignment = Assignment::where('school_class_id', $user->school_class_id)->findOrFail($id);

        $submission = AssignmentSubmission::firstOrNew([
            'assignment_id' => $assignment->id,
            'student_id' => $user->id
        ]);

        if ($request->has('content')) {
            $submission->content = $request->content;
        }
        
        if ($request->hasFile('file')) {
            $submission->file_path = $request->file('file')->store('submissions', 'public');
        }

        $submission->status = 'Sudah Dikumpulkan';
        
        // MVP logic for late
        if ($assignment->due_date && now() > $assignment->due_date) {
            $submission->status = 'Terlambat';
        }
        
        $submission->save();

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan.');
    }
}
