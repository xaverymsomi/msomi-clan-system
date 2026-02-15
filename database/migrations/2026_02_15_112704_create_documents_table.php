<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('document_categories')->onDelete('cascade');
            $table->string('title_sw');
            $table->string('title_en');
            $table->text('description_sw')->nullable();
            $table->text('description_en')->nullable();
            $table->string('file_path');
            $table->string('file_type');
            $table->bigInteger('file_size')->nullable();
            $table->enum('access_level', ['public', 'members', 'elders', 'admin'])->default('members');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
