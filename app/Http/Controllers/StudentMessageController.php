<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Subject;
use App\Models\User;

class StudentMessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('sender_name', $user->name)
                           ->where('sender_role', 'like', 'Siswa%')
                           ->latest()
                           ->get();
        
        // Get teachers for this student's class
        $teachers = User::where('role', 'Guru')->get(); // Simplified for MVP
        $subjects = Subject::all();

        return view('siswa.pesan.index', compact('messages', 'teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $className = $user->schoolClass->name ?? 'Tanpa Kelas';

        Message::create([
            'teacher_id' => $request->teacher_id,
            'sender_name' => $user->name,
            'sender_role' => 'Siswa - ' . $className,
            'content' => $request->content,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim ke guru.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $user = Auth::user();

        // Check if the message belongs to this student
        if ($message->sender_name === $user->name && str_starts_with($message->sender_role, 'Siswa')) {
            $message->delete();
            return back()->with('success', 'Pesan berhasil dihapus.');
        }

        return back()->withErrors('Anda tidak memiliki akses untuk menghapus pesan ini.');
    }
}
