<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Material;
use App\Models\Subject;

class StudentMaterialController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Material::where('school_class_id', $user->school_class_id)->where('status', 'Aktif');

        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }

        $materials = $query->latest('published_at')->get();
        $subjects = Subject::all();

        return view('siswa.materi.index', compact('materials', 'subjects'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $material = Material::where('school_class_id', $user->school_class_id)->findOrFail($id);

        return view('siswa.materi.show', compact('material'));
    }
}
