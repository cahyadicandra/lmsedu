<?php
namespace App\Http\Controllers;
use App\Models\Subject;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
class SubjectController extends Controller {
    public function index() {
        $subjects = Subject::with("teacher","schoolClass","academicYear")->paginate(10);
        $teachers = User::where("role","Guru")->orderBy("name")->get();
        $classes = SchoolClass::orderBy("name")->get();
        $academicYears = AcademicYear::orderBy("name")->get();
        return view("akademik.mata-pelajaran.index", compact("subjects","teachers","classes","academicYears"));
    }
    public function store(Request $request) {
        $request->validate(["name"=>"required","code"=>"required|unique:subjects,code","status"=>"required"]);
        Subject::create($request->all());
        return redirect()->route("mata-pelajaran.index")->with("success","Mata pelajaran berhasil ditambahkan");
    }
    public function update(Request $request, Subject $mata_pelajaran) {
        $request->validate(["name"=>"required","code"=>"required|unique:subjects,code,".$mata_pelajaran->id,"status"=>"required"]);
        $mata_pelajaran->update($request->all());
        return redirect()->route("mata-pelajaran.index")->with("success","Mata pelajaran berhasil diperbarui");
    }
    public function destroy(Subject $mata_pelajaran) {
        $mata_pelajaran->delete();
        return redirect()->route("mata-pelajaran.index")->with("success","Mata pelajaran berhasil dihapus");
    }
}
