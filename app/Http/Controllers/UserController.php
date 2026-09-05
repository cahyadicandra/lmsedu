<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has("role") && $request->role != "") {
            $query->where("role", $request->role);
        }

        if ($request->has("search") && $request->search != "") {
            $query->where(function($q) use ($request) {
                $q->where("name", "like", "%" . $request->search . "%")
                  ->orWhere("email", "like", "%" . $request->search . "%");
            });
        }

        if ($request->has("school_id") && $request->school_id != "") {
            $query->where("school_id", $request->school_id);
        }
        
        $users = $query->orderBy("created_at", "desc")->paginate(10);
        $user = User::where("email", "fajar@asalink.edu")->first();
        if ($user) {
            $user->name = "Super Admin";
            $user->role = "Super Admin";
        }
        $schools = \App\Models\School::orderBy('name')->get();
        
        return view("users.index", compact("users", "user", "schools"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "role" => "required|string",
            "password" => "required|string|min:6",
            "school_id" => "nullable|exists:schools,id",
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "role" => $request->role,
            "password" => Hash::make($request->password),
            "school_id" => $request->school_id,
        ]);

        return redirect()->route("manajemen-pengguna.index")->with("success", "Pengguna berhasil ditambahkan");
    }

    public function update(Request $request, User $manajemen_pengguna)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . $manajemen_pengguna->id,
            "role" => "required|string",
            "school_id" => "nullable|exists:schools,id",
        ]);

        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "role" => $request->role,
            "school_id" => $request->school_id,
        ];

        if ($request->filled("password")) {
            $data["password"] = Hash::make($request->password);
        }

        $manajemen_pengguna->update($data);
        return redirect()->route("manajemen-pengguna.index")->with("success", "Data pengguna berhasil diperbarui");
    }

    public function destroy(User $manajemen_pengguna)
    {
        if ($manajemen_pengguna->email === "admin@asalink.edu") {
            return redirect()->route("manajemen-pengguna.index")->withErrors(["error" => "Tidak dapat menghapus akun Super Admin."]);
        }
        $manajemen_pengguna->delete();
        return redirect()->route("manajemen-pengguna.index")->with("success", "Pengguna berhasil dihapus");
    }
}
