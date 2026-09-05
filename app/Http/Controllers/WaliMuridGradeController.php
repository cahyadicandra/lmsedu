<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridGradeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return view('walimurid.nilai.index', ['student' => null, 'grades' => collect()]);
        }

        $query = $student->grades()->with(['subject.teacher']);

        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $grades = $query->orderBy('created_at', 'desc')->get();
        
        $subjects = \App\Models\Subject::where('school_class_id', $student->school_class_id)->get();
        
        $types = ['Tugas', 'Kuis', 'UTS', 'UAS', 'Praktik']; // Example standard types

        // Summary
        $totalGrades = $student->grades()->count();
        $averageGrade = $totalGrades > 0 ? round($student->grades()->avg('score'), 1) : 0;
        $highestGrade = $totalGrades > 0 ? $student->grades()->max('score') : 0;
        $lowestGrade = $totalGrades > 0 ? $student->grades()->min('score') : 0;

        return view('walimurid.nilai.index', compact(
            'student', 'grades', 'subjects', 'types',
            'totalGrades', 'averageGrade', 'highestGrade', 'lowestGrade'
        ));
    }
}
