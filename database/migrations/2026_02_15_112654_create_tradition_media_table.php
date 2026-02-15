<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tradition_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tradition_id')->constrained('customs_traditions')->onDelete('cascade');
            $table->enum('type', ['image', 'video', 'audio']);
            $table->string('file_path');
            $table->string('caption_sw')->nullable();
            $table->string('caption_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tradition_media');
    }
};
