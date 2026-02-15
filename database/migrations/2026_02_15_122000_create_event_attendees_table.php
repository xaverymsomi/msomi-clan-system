<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('event_attendees');

        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users'); // For logged in users
            $table->foreignId('member_id')->nullable()->constrained('members'); // For linked members
            $table->string('name')->nullable(); // For guests/non-members
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('guests_count')->default(0);
            $table->enum('status', ['registered', 'cancelled', 'attended'])->default('registered');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
    }
};
