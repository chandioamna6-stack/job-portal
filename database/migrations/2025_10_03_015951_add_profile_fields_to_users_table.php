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
        Schema::table('users', function (Blueprint $table) {
            // Basic profile fields
            $table->string('phone')->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->string('country')->nullable()->after('address');

            // Optional banking fields
            $table->string('bank_name')->nullable()->after('country');
            $table->string('account_number')->nullable()->after('bank_name');

            // Avatar / profile picture path (stored as string)
            $table->string('avatar')->nullable()->after('account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
            if (Schema::hasColumn('users', 'account_number')) {
                $table->dropColumn('account_number');
            }
            if (Schema::hasColumn('users', 'bank_name')) {
                $table->dropColumn('bank_name');
            }
            if (Schema::hasColumn('users', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
