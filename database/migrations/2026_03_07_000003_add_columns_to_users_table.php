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
            // Thêm các columns không tồn tại
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->integer('user_type')->default(1)->after('password');
            }
            if (!Schema::hasColumn('users', 'is_delete')) {
                $table->integer('is_delete')->default(0)->after('user_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'user_type')) {
                $table->dropColumn('user_type');
            }
            if (Schema::hasColumn('users', 'is_delete')) {
                $table->dropColumn('is_delete');
            }
        });
    }
};
