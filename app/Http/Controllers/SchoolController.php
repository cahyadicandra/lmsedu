<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $query = School::query();
        
        if ($request->has("level") && $request->level != "") {
            $query->where("level", $request->level);
        }

        if ($request->has("search") && $request->search != "") {
            $query->where("name", "like", "%" . $request->search . "%")
                  ->orWhere("npsn", "like", "%" . $request->search . "%");
        }
        
        $schools = $query->orderBy("created_at", "desc")->paginate(10);
        $user = \App\Models\User::where("email", "fajar@asalink.edu")->first();
        if ($user) {
            $user->name = "Super Admin";
            $user->role = "Super Admin";
        }
        
        return view("schools.index", compact("schools", "user"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "npsn" => "required|string|unique:schools,npsn",
            "level" => "required|string",
            "status" => "required|string",
        ]);

        School::create($request->all());
        return redirect()->route("data-sekolah.index")->with("success", "Data Sekolah berhasil ditambahkan");
    }

    public function update(Request $request, School $data_sekolah)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "npsn" => "required|string|unique:schools,npsn," . $data_sekolah->id,
            "level" => "required|string",
            "status" => "required|string",
        ]);

        $data_sekolah->update($request->all());
        return redirect()->route("data-sekolah.index")->with("success", "Data Sekolah berhasil diperbarui");
    }

    public function destroy(School $data_sekolah)
    {
        if ($data_sekolah->status === 'Aktif') {
            return redirect()->route("data-sekolah.index")->withErrors(['error' => 'Data sekolah yang berstatus Aktif tidak dapat dihapus. Silakan ubah statusnya menjadi Nonaktif terlebih dahulu.']);
        }
        $data_sekolah->delete();
        return redirect()->route("data-sekolah.index")->with("success", "Data Sekolah berhasil dihapus");
    }
}
