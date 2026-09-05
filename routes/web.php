<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DataGuruController;
use App\Http\Controllers\DataSiswaController;


Route::get("/login", [AuthController::class, "showLoginForm"])->name("login");
Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"])->name("logout");

Route::middleware("auth")->group(function () {
    // Dashboard (role-aware)
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");

    // Super Admin routes
    Route::resource("data-sekolah", SchoolController::class)->parameters(["data-sekolah" => "data_sekolah"]);
    Route::resource("manajemen-pengguna", UserController::class)->parameters(["manajemen-pengguna" => "manajemen_pengguna"]);

    // Admin Sekolah - Akademik
    Route::get("profil-sekolah", [\App\Http\Controllers\AdminSchoolController::class, 'edit'])->name('admin.sekolah.edit');
    Route::put("profil-sekolah", [\App\Http\Controllers\AdminSchoolController::class, 'update'])->name('admin.sekolah.update');
    Route::resource("tahun-akademik", AcademicYearController::class)->parameters(["tahun-akademik" => "tahun_akademik"]);
    Route::resource("kelas", SchoolClassController::class)->parameters(["kelas" => "kela"]);
    Route::resource("mata-pelajaran", SubjectController::class)->parameters(["mata-pelajaran" => "mata_pelajaran"]);

    // Admin Sekolah - Pengguna
    Route::resource("data-guru", DataGuruController::class)->parameters(["data-guru" => "data_guru"]);
    Route::resource("data-siswa", DataSiswaController::class)->parameters(["data-siswa" => "data_siswa"]);
    Route::resource("data-wali-murid", \App\Http\Controllers\AdminWaliMuridController::class)->parameters(["data-wali-murid" => "data_wali_murid"]);

    // Guru - Pembelajaran
    Route::resource("pertemuan", \App\Http\Controllers\LearningSessionController::class);
    Route::resource("tugas", \App\Http\Controllers\TeacherAssignmentController::class);
    Route::post("tugas/grade/{id}", [\App\Http\Controllers\TeacherAssignmentController::class, 'grade'])->name('tugas.grade');
    Route::resource("absensi", \App\Http\Controllers\AttendanceController::class);
    Route::resource("nilai", \App\Http\Controllers\GradeController::class);
    Route::delete("nilai/destroyType", [\App\Http\Controllers\GradeController::class, "destroyType"])->name("nilai.destroyType");
    Route::resource("pesan", \App\Http\Controllers\MessageController::class)->only(['index', 'destroy']);
    Route::post("pesan/{pesan}/reply", [\App\Http\Controllers\MessageController::class, 'reply'])->name('pesan.reply');

    // Siswa
    Route::prefix('siswa')->name('siswa.')->group(function() {
        Route::resource('kelas', \App\Http\Controllers\StudentClassController::class)->only(['index', 'show']);
        Route::resource('materi', \App\Http\Controllers\StudentMaterialController::class)->only(['index', 'show']);
        Route::resource('tugas', \App\Http\Controllers\StudentAssignmentController::class)->only(['index', 'show']);
        Route::post('tugas/{tugas}/submit', [\App\Http\Controllers\StudentAssignmentController::class, 'submit'])->name('tugas.submit');
        Route::resource('nilai', \App\Http\Controllers\StudentGradeController::class)->only(['index']);
        Route::resource('pesan', \App\Http\Controllers\StudentMessageController::class)->only(['index', 'store', 'show', 'destroy']);
    });

    // Wali Murid
    Route::prefix('wali-murid')->name('walimurid.')->group(function() {
        Route::get('dashboard', [\App\Http\Controllers\WaliMuridDashboardController::class, 'index'])->name('dashboard');
        Route::get('kehadiran', [\App\Http\Controllers\WaliMuridAttendanceController::class, 'index'])->name('kehadiran.index');
        Route::get('nilai', [\App\Http\Controllers\WaliMuridGradeController::class, 'index'])->name('nilai.index');
        Route::get('pesan', [\App\Http\Controllers\WaliMuridMessageController::class, 'index'])->name('pesan.index');
        Route::post('pesan', [\App\Http\Controllers\WaliMuridMessageController::class, 'store'])->name('pesan.store');
        Route::delete('pesan/{pesan}', [\App\Http\Controllers\WaliMuridMessageController::class, 'destroy'])->name('pesan.destroy');
        Route::get('profil-anak', [\App\Http\Controllers\WaliMuridChildProfileController::class, 'index'])->name('profil.index');
    });

    // Profile
    Route::get("/profile", [\App\Http\Controllers\ProfileController::class, "index"])->name("profile.index");
    Route::put("/profile", [\App\Http\Controllers\ProfileController::class, "update"])->name("profile.update");

    Route::get("/pengaturan", function () { return redirect("/"); });
});
