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
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('members');

            if (!array_key_exists('members_region_index', $indexes)) $table->index('region');
            if (!array_key_exists('members_district_index', $indexes)) $table->index('district');
            if (!array_key_exists('members_village_index', $indexes)) $table->index('village');
            if (!array_key_exists('members_membership_status_index', $indexes)) $table->index('membership_status');
        });

        Schema::table('contributions', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('contributions');

            if (!array_key_exists('contributions_status_index', $indexes)) $table->index('status');
            if (!array_key_exists('contributions_payment_method_index', $indexes)) $table->index('payment_method');
            if (!array_key_exists('contributions_member_id_index', $indexes)) $table->index('member_id');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('announcements');

            if (!array_key_exists('announcements_category_index', $indexes)) $table->index('category');
            // 'status' column does not exist in announcements table
        });

        Schema::table('customs_traditions', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('customs_traditions');

            if (!array_key_exists('customs_traditions_category_id_index', $indexes)) $table->index('category_id');
            if (!array_key_exists('customs_traditions_status_index', $indexes)) $table->index('status');
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
