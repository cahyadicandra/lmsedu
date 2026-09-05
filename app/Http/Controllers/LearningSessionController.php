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
        $session = LearningSession::with(['subject', 'schoolClass', 'attendances.student', 'schoolClass.students'])->findOrFail($id);
        
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
}
