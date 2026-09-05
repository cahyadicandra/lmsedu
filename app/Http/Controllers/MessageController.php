<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Mark all unread messages as read
        Message::where('teacher_id', $teacherId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where('teacher_id', $teacherId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('guru.pesan.index', compact('messages'));
    }

    // For deleting a message
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        if ($message->teacher_id == Auth::id()) {
            $message->delete();
            return back()->with('success', 'Pesan berhasil dihapus.');
        }
        return back()->withErrors('Anda tidak memiliki akses untuk menghapus pesan ini.');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:1000'
        ]);

        $message = Message::findOrFail($id);
        if ($message->teacher_id == Auth::id()) {
            $message->update(['reply' => $request->reply]);
            return back()->with('success', 'Balasan berhasil dikirim.');
        }

        return back()->withErrors('Anda tidak memiliki akses untuk membalas pesan ini.');
    }
}
