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
        Schema::table('members', function (Blueprint $table) {
            $table->index('region');
            $table->index('district');
            $table->index('village');
            $table->index('membership_status');
        });

        Schema::table('contributions', function (Blueprint $table) {
            $table->index('status');
            $table->index('payment_method');
            $table->index('member_id');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->index('category');
            $table->index('status');
        });

        Schema::table('customs_traditions', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropIndex(['region']);
            $table->dropIndex(['district']);
            $table->dropIndex(['village']);
            $table->dropIndex(['membership_status']);
        });

        Schema::table('contributions', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_method']);
            $table->dropIndex(['member_id']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['status']);
        });

        Schema::table('customs_traditions', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['status']);
        });
    }
};
