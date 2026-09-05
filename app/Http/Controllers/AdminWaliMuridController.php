<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminWaliMuridController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where("role", "Wali Murid")->with("student");
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where("name", "like", "%".$request->search."%")
                  ->orWhere("email", "like", "%".$request->search."%");
            });
        }
        
        $users = $query->orderBy("created_at", "desc")->paginate(10);
        $students = User::where('role', 'Siswa')->orderBy('name')->get();
        
        return view("admin.walimurid.index", compact("users", "students"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
            "phone" => "nullable|string|max:20",
            "student_id" => "nullable|exists:users,id"
        ]);
        
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => "Wali Murid",
            "phone" => $request->phone,
            "student_id" => $request->student_id ?: null,
            "status" => $request->status ?? "Aktif"
        ]);
        
        return redirect()->route("data-wali-murid.index")->with("success", "Data Wali Murid berhasil ditambahkan");
    }

    public function update(Request $request, User $data_wali_murid)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email," . $data_wali_murid->id,
            "phone" => "nullable|string|max:20",
            "student_id" => "nullable|exists:users,id"
        ]);
        
        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "student_id" => $request->student_id ?: null,
            "status" => $request->status ?? "Aktif"
        ];
        
        if ($request->filled("password")) {
            $data["password"] = Hash::make($request->password);
        }
        
        $data_wali_murid->update($data);
        
        return redirect()->route("data-wali-murid.index")->with("success", "Data Wali Murid berhasil diperbarui");
    }

    public function destroy(User $data_wali_murid)
    {
        $data_wali_murid->delete();
        return redirect()->route("data-wali-murid.index")->with("success", "Data Wali Murid berhasil dihapus");
    }
}
