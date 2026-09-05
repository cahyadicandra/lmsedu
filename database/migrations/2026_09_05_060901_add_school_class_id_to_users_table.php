<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table("users", function (Blueprint $table) {
            $table->foreignId("school_class_id")->nullable()->constrained("school_classes")->nullOnDelete();
            $table->string("status")->default("Aktif");
        });
    }
    public function down(): void {
        Schema::table("users", function (Blueprint $table) {
            $table->dropForeign(["school_class_id"]);
            $table->dropColumn(["school_class_id", "status"]);
        });
    }
};
