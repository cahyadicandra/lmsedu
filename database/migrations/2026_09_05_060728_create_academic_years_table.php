<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("academic_years", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("semester");
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->string("status")->default("Nonaktif");
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("academic_years"); }
};
