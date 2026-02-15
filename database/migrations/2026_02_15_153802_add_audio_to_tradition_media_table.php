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
        Schema::table('tradition_media', function (Blueprint $table) {
            $table->string('type')->default('image')->change();
            $table->integer('duration')->nullable()->after('file_path'); // For audio/video
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tradition_media', function (Blueprint $table) {
            //
        });
    }
};
