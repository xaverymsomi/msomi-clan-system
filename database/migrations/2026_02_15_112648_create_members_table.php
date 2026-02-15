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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('member_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('region')->nullable();
            $table->foreignId('father_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('mother_id')->nullable()->constrained('members')->onDelete('set null');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->string('occupation')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('bio_sw')->nullable();
            $table->text('bio_en')->nullable();
            $table->enum('membership_status', ['active', 'inactive', 'deceased'])->default('active');
            $table->date('joined_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
