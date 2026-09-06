<?php

namespace App\Http\Controllers;

use App\Models\LearningSession;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = LearningSession::whereIn('subject_id', function($q) {
            $q->select('id')->from('subjects')->where('teacher_id', Auth::id());
        });

        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->school_class_id) {
            $query->where('school_class_id', $request->school_class_id);
        }
        if ($request->search) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $sessions = $query->with(['subject', 'schoolClass'])->orderBy('date', 'desc')->orderBy('time', 'desc')->paginate(10);
        
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        $classes = SchoolClass::whereIn('id', $subjects->pluck('school_class_id'))->distinct()->get();

        return view('guru.pertemuan.index', compact('sessions', 'subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'meeting_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:Belum Dimulai,Berlangsung,Selesai'
        ]);

        LearningSession::create($request->all());

        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $session = LearningSession::with(['subject', 'schoolClass', 'attendances.student', 'schoolClass.students', 'materials'])->findOrFail($id);
        
        // Pastikan hanya guru yang mengajar mapel ini yang bisa lihat
        if ($session->subject->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('guru.pertemuan.detail', compact('session'));
    }

    public function update(Request $request, $id)
    {
        $session = LearningSession::findOrFail($id);
        
        if ($session->subject->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:school_classes,id',
            'meeting_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:Belum Dimulai,Berlangsung,Selesai'
        ]);

        $session->update($request->all());

        return redirect()->back()->with('success', 'Pertemuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $session = LearningSession::findOrFail($id);
        
        if ($session->subject->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $session->delete();

        return redirect()->route('pertemuan.index')->with('success', 'Pertemuan berhasil dihapus.');
    }

    public function storeMaterial(Request $request, $id)
    {
        $session = LearningSession::findOrFail($id);
        
        if ($session->subject->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('materials', $filename, 'public');
        }

        \App\Models\Material::create([
            'learning_session_id' => $session->id,
            'subject_id' => $session->subject_id,
            'school_class_id' => $session->school_class_id,
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'youtube_link' => $request->youtube_link,
            'file_path' => $filePath,
            'published_at' => now(),
            'status' => 'Aktif',
        ]);

        return redirect()->back()->with(['success' => 'Materi berhasil ditambahkan.', 'tab' => 'materi']);
    }

    public function destroyMaterial($id)
    {
        $material = \App\Models\Material::findOrFail($id);
        
        if ($material->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($material->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->back()->with(['success' => 'Materi berhasil dihapus.', 'tab' => 'materi']);
    }
}
