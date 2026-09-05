<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("subjects", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("code")->unique();
            $table->foreignId("teacher_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignId("school_class_id")->nullable()->constrained("school_classes")->nullOnDelete();
            $table->foreignId("academic_year_id")->nullable()->constrained("academic_years")->nullOnDelete();
            $table->string("status")->default("Aktif");
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("subjects"); }
};
