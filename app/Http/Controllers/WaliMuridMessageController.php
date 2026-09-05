<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class WaliMuridMessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $messages = Message::where('sender_name', $user->name)
                           ->where('sender_role', 'Wali Murid')
                           ->orderBy('created_at', 'desc')
                           ->get();
                           
        // Get teachers of the student
        $teachers = collect();
        if ($user->student && $user->student->schoolClass) {
            $classId = $user->student->schoolClass->id;
            // Get all subjects taught in this class
            $subjects = \App\Models\Subject::where('school_class_id', $classId)->get();
            // Get all unique teachers for those subjects
            $teacherIds = $subjects->pluck('teacher_id')->unique();
            $teachers = User::whereIn('id', $teacherIds)->get();
        }

        return view('walimurid.pesan.index', compact('messages', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        
        // Pick random color
        $colors = ['bg-yellow-100', 'bg-blue-100', 'bg-pink-100', 'bg-green-100'];
        $color = $colors[array_rand($colors)];

        Message::create([
            'teacher_id' => $request->teacher_id,
            'sender_name' => $user->name,
            'sender_role' => $user->role,
            'content' => $request->content,
            'color' => $color,
        ]);

        return redirect()->route('walimurid.pesan.index')->with('success', 'Pesan (Sticky Note) berhasil dikirim kepada guru.');
    }

    public function destroy(Message $pesan)
    {
        $user = Auth::user();
        if ($pesan->sender_name == $user->name && $pesan->sender_role == $user->role) {
            $pesan->delete();
            return back()->with('success', 'Pesan berhasil dihapus.');
        }
        return back()->with('error', 'Tidak berhak menghapus pesan ini.');
    }
}
