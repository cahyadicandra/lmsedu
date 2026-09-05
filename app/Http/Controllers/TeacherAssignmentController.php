<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::where('teacher_id', Auth::id());

        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->school_class_id) {
            $query->where('school_class_id', $request->school_class_id);
        }
        if ($request->search) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $assignments = $query->with(['subject', 'schoolClass'])->orderBy('created_at', 'desc')->paginate(10);
        
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        $classes = SchoolClass::whereIn('id', $subjects->pluck('school_class_id'))->distinct()->get();

        return view('guru.tugas.index', compact('assignments', 'subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_link' => 'nullable|url|max:255',
            'file' => 'nullable|file|max:10240', // max 10MB
            'due_date' => 'required|date',
            'status' => 'required|in:Draft,Published,Closed'
        ]);

        $data = $request->except('file');
        $data['teacher_id'] = Auth::id();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create($data);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_link' => 'nullable|url|max:255',
            'file' => 'nullable|file|max:10240', // max 10MB
            'due_date' => 'required|date',
            'status' => 'required|in:Draft,Published,Closed'
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            // Delete old file if needed, skipping for brevity or implement if preferred:
            // if ($assignment->file_path) { Storage::disk('public')->delete($assignment->file_path); }
            $data['file_path'] = $request->file('file')->store('assignments', 'public');
        }

        $assignment->update($data);

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $assignment->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function show($id)
    {
        $assignment = Assignment::with(['subject', 'schoolClass', 'submissions.student'])->findOrFail($id);
        
        if ($assignment->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('guru.tugas.detail', compact('assignment'));
    }

    public function grade(Request $request, $id)
    {
        $submission = \App\Models\AssignmentSubmission::findOrFail($id);
        
        if ($submission->assignment->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'status' => 'Sudah Dinilai'
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
}
