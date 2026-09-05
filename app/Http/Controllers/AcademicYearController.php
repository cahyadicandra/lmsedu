<?php
namespace App\Http\Controllers;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
class AcademicYearController extends Controller {
    public function index() {
        $academicYears = AcademicYear::orderBy("created_at","desc")->paginate(10);
        return view("akademik.tahun-akademik.index", compact("academicYears"));
    }
    public function store(Request $request) {
        $request->validate(["name"=>"required","semester"=>"required","status"=>"required"]);
        AcademicYear::create($request->all());
        return redirect()->route("tahun-akademik.index")->with("success","Tahun akademik berhasil ditambahkan");
    }
    public function update(Request $request, AcademicYear $tahun_akademik) {
        $request->validate(["name"=>"required","semester"=>"required","status"=>"required"]);
        $tahun_akademik->update($request->all());
        return redirect()->route("tahun-akademik.index")->with("success","Tahun akademik berhasil diperbarui");
    }
    public function destroy(AcademicYear $tahun_akademik) {
        $tahun_akademik->delete();
        return redirect()->route("tahun-akademik.index")->with("success","Tahun akademik berhasil dihapus");
    }
}
