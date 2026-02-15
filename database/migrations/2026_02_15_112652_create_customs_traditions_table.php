<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customs_traditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('tradition_categories')->onDelete('cascade');
            $table->string('title_sw');
            $table->string('title_en');
            $table->text('description_sw')->nullable();
            $table->text('description_en')->nullable();
            $table->longText('content_sw')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('featured_image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('views_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customs_traditions');
    }
};
