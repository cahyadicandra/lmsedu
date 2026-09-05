<?php
namespace App\Http\Controllers;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
class SchoolClassController extends Controller {
    public function index() {
        $classes = SchoolClass::with("teacher","academicYear","students")->paginate(10);
        $teachers = User::where("role","Guru")->orderBy("name")->get();
        $academicYears = AcademicYear::orderBy("name")->get();
        return view("akademik.kelas.index", compact("classes","teachers","academicYears"));
    }
    public function store(Request $request) {
        $request->validate(["name"=>"required","level"=>"required","status"=>"required"]);
        SchoolClass::create($request->all());
        return redirect()->route("kelas.index")->with("success","Kelas berhasil ditambahkan");
    }
    public function update(Request $request, SchoolClass $kela) {
        $request->validate(["name"=>"required","level"=>"required","status"=>"required"]);
        $kela->update($request->all());
        return redirect()->route("kelas.index")->with("success","Kelas berhasil diperbarui");
    }
    public function destroy(SchoolClass $kela) {
        $kela->delete();
        return redirect()->route("kelas.index")->with("success","Kelas berhasil dihapus");
    }
}
