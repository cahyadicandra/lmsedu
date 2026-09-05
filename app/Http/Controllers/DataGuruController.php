<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class DataGuruController extends Controller {
    public function index(Request $request) {
        $query = User::where("role","Guru");
        if ($request->search) $query->where(function($q) use ($request) { $q->where("name","like","%".$request->search."%")->orWhere("email","like","%".$request->search."%"); });
        $users = $query->orderBy("created_at","desc")->paginate(10);
        return view("pengguna.guru.index", compact("users"));
    }
    public function store(Request $request) {
        $request->validate(["name"=>"required","email"=>"required|email|unique:users,email","password"=>"required|min:6"]);
        User::create(["name"=>$request->name,"email"=>$request->email,"password"=>Hash::make($request->password),"role"=>"Guru","status"=>$request->status??"Aktif"]);
        return redirect()->route("data-guru.index")->with("success","Data guru berhasil ditambahkan");
    }
    public function update(Request $request, User $data_guru) {
        $request->validate(["name"=>"required","email"=>"required|email|unique:users,email,".$data_guru->id]);
        $data = ["name"=>$request->name,"email"=>$request->email,"status"=>$request->status??"Aktif"];
        if ($request->filled("password")) $data["password"] = Hash::make($request->password);
        $data_guru->update($data);
        return redirect()->route("data-guru.index")->with("success","Data guru berhasil diperbarui");
    }
    public function destroy(User $data_guru) {
        $data_guru->delete();
        return redirect()->route("data-guru.index")->with("success","Data guru berhasil dihapus");
    }
}
