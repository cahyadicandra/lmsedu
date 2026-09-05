<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class DataSiswaController extends Controller {
    public function index(Request $request) {
        $query = User::where("role","Siswa")->with("schoolClass");
        if ($request->search) $query->where(function($q) use ($request) { $q->where("name","like","%".$request->search."%")->orWhere("email","like","%".$request->search."%"); });
        if ($request->kelas) $query->where("school_class_id",$request->kelas);
        $users = $query->orderBy("created_at","desc")->paginate(10);
        $classes = SchoolClass::orderBy("name")->get();
        return view("pengguna.siswa.index", compact("users","classes"));
    }
    public function store(Request $request) {
        $request->validate(["name"=>"required","email"=>"required|email|unique:users,email","password"=>"required|min:6"]);
        User::create(["name"=>$request->name,"email"=>$request->email,"password"=>Hash::make($request->password),"role"=>"Siswa","school_class_id"=>$request->school_class_id?:null,"status"=>$request->status??"Aktif"]);
        return redirect()->route("data-siswa.index")->with("success","Data siswa berhasil ditambahkan");
    }
    public function update(Request $request, User $data_siswa) {
        $request->validate(["name"=>"required","email"=>"required|email|unique:users,email,".$data_siswa->id]);
        $data = ["name"=>$request->name,"email"=>$request->email,"school_class_id"=>$request->school_class_id?:null,"status"=>$request->status??"Aktif"];
        if ($request->filled("password")) $data["password"] = Hash::make($request->password);
        $data_siswa->update($data);
        return redirect()->route("data-siswa.index")->with("success","Data siswa berhasil diperbarui");
    }
    public function destroy(User $data_siswa) {
        $data_siswa->delete();
        return redirect()->route("data-siswa.index")->with("success","Data siswa berhasil dihapus");
    }
}
