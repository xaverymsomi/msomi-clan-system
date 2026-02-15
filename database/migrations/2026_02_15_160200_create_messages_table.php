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
        Schema::create('messages', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $blueprint->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $blueprint->text('body');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
