<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridChildProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if ($student) {
            $student->load(['schoolClass', 'attendances', 'grades']);
        }

        return view('walimurid.profil.index', compact('student'));
    }
}
