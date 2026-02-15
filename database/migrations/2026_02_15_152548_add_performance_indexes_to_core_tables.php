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
            $indexes = collect(Schema::getIndexes('members'))->pluck('name')->toArray();

            if (!in_array('members_region_index', $indexes)) $table->index('region');
            if (!in_array('members_district_index', $indexes)) $table->index('district');
            if (!in_array('members_village_index', $indexes)) $table->index('village');
            if (!in_array('members_membership_status_index', $indexes)) $table->index('membership_status');
        });

        Schema::table('contributions', function (Blueprint $table) {
            $indexes = collect(Schema::getIndexes('contributions'))->pluck('name')->toArray();

            if (!in_array('contributions_status_index', $indexes)) $table->index('status');
            if (!in_array('contributions_payment_method_index', $indexes)) $table->index('payment_method');
            if (!in_array('contributions_member_id_index', $indexes)) $table->index('member_id');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $indexes = collect(Schema::getIndexes('announcements'))->pluck('name')->toArray();

            if (!in_array('announcements_category_index', $indexes)) $table->index('category');
            // 'status' column does not exist in announcements table
        });

        Schema::table('customs_traditions', function (Blueprint $table) {
            $indexes = collect(Schema::getIndexes('customs_traditions'))->pluck('name')->toArray();

            if (!in_array('customs_traditions_category_id_index', $indexes)) $table->index('category_id');
            if (!in_array('customs_traditions_status_index', $indexes)) $table->index('status');
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
