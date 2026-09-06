<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('learning_session_id')->nullable()->after('school_class_id')->constrained()->cascadeOnDelete();
            $table->string('youtube_link')->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['learning_session_id']);
            $table->dropColumn('learning_session_id');
            $table->dropColumn('youtube_link');
        });
    }
};
