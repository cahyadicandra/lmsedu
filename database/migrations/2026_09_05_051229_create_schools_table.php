<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("schools", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("npsn")->unique();
            $table->string("level"); // SD, MI, SMP, MTS, SMA, MA, SMK
            $table->string("status")->default("Aktif"); // Aktif, Nonaktif
            $table->text("address")->nullable();
            $table->string("phone")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("schools");
    }
};
